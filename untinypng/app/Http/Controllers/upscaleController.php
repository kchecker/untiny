<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UpscaleController extends Controller
{
   
    public function upscale(Request $request)
    {
        set_time_limit(300);
        // 1️⃣ Validate uploaded image
        $request->validate([
            'image' => 'required|image|mimes:png|max:5120', // Max 5MB
        ]);

        try {
            // 2️⃣ Save uploaded image locally
            $image = $request->file('image');
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = public_path('uploads');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $image->move($uploadPath, $filename);
            $localPath = 'uploads/' . $filename;
            $imageUrl = asset($localPath); // Public URL for Fal.ai
            // $imageUrl = 'https://pdfthisthat.com/images/og-image/pdf.png'; // Temporary public URL for testing

            // 3️⃣ Get original image dimensions
            [$originalWidth, $originalHeight] = getimagesize($imageUrl);

            // 4️⃣ Prepare Fal.ai payload
            $falKey = env('FAL_API_KEY');
            $payload = [
                "model" => "Standard V2",
                "upscale_factor" => 2,
                "image_url" => $imageUrl,
                "output_format" => "jpeg",
                "subject_detection" => "All",
                "face_enhancement" => false
            ];

            // 5️⃣ Submit job to Fal.ai
            $submitResponse = Http::withHeaders([
                'Authorization' => 'Key ' . $falKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)
            ->post('https://queue.fal.run/fal-ai/topaz/upscale/image', $payload);

            if ($submitResponse->failed()) {
                throw new \Exception("❌ Failed to submit job: " . $submitResponse->body());
            }

            $submitData = $submitResponse->json();
            $requestId   = $submitData['request_id'] ?? null;
            $statusUrl   = $submitData['status_url'] ?? null;
            $responseUrl = $submitData['response_url'] ?? null;

            if (!$requestId || !$statusUrl || !$responseUrl) {
                throw new \Exception("❌ Fal.ai returned incomplete job data.");
            }

            // 6️⃣ Poll until job completed
            $maxAttempts = 40;
            $attempt = 0;
            $outputUrl = null;

            while ($attempt < $maxAttempts) {
                sleep(5); // wait 5 seconds between polls
                $statusResponse = Http::withHeaders([
                    'Authorization' => 'Key ' . $falKey,
                ])->get($statusUrl);

                $statusData = $statusResponse->json();
                $status = strtoupper($statusData['status'] ?? '');
                \Log::info("Attempt $attempt: Status = $status");

                if ($status === 'COMPLETED') {
                    // 7️⃣ Fetch final result
                    $resultResponse = Http::withHeaders([
                        'Authorization' => 'Key ' . $falKey,
                    ])->get($responseUrl);

                    $resultData = $resultResponse->json();

                    // ✅ Correct path to upscaled image
                    $outputUrl = $resultData['image']['url'] ?? null;

                    if (!$outputUrl) {
                        throw new \Exception("Fal.ai completed the job but no output image URL found.");
                    }

                    // Optional: download upscaled image locally
                    $upscaledPath = public_path('uploads/upscaled');
                    if (!File::exists($upscaledPath)) {
                        File::makeDirectory($upscaledPath, 0755, true);
                    }
                    $upFileName = Str::uuid() . '.jpg';
                    $upFilePath = $upscaledPath . '/' . $upFileName;
                    $imageData = file_get_contents($outputUrl);
                    if ($imageData) {
                        file_put_contents($upFilePath, $imageData);
                    }

                    // 8️⃣ Get new dimensions
                    [$newWidth, $newHeight] = getimagesize($outputUrl);

                    break;
                } elseif ($status === 'FAILED') {
                    throw new \Exception("❌ Fal.ai processing failed.");
                }

                $attempt++;
            }

            if (!$outputUrl) {
                throw new \Exception("❌ Fal.ai did not return an output image within retry limit.");
            }

            // 9️⃣ Return results to success page
            return redirect()->route('success')->with([
                'success' => '✅ Image has been successfully upscaled 2X!',
                'output_image' => $outputUrl,
                'original_width' => $originalWidth,
                'original_height' => $originalHeight,
                'new_width' => $newWidth,
                'new_height' => $newHeight,
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Exception: ' . $e->getMessage());
        }
    }
    
    public function success()
    {
        return view('success');
    }

}
