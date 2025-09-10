@extends('layout.design')

@section('content')

    <div class="w-full bg-gray-800 rounded-2xl container-shadow overflow-hidden mb-5">
      <div>
        @if(session('error'))
          <div class="bg-red-600 text-white p-4 rounded-lg shadow-md m-6">
            <h2 class="text-lg font-semibold mb-2">❌ Error</h2>
            <p>{{ session('error') }}</p>
          </div>
        @endif

        <form method="POST" action="/upscale_image" enctype="multipart/form-data" class="min-h-[380px]" id="myForm">
          @csrf

          <!-- Upload Section -->
          <div class="bg-gray-900 p-6 justify-center">
            <h3 class="text-xl font-semibold text-white mb-6">Upload Image</h3>

            <div id="dropArea"
              class="upload-area border-2 border-dashed border-sky-500 rounded-xl p-6 text-center cursor-pointer transition">
              <div class="text-sky-400 text-6xl mb-4">
                <i class="bi bi-cloud-arrow-up"></i>
              </div>
              <p class="text-sky-300 font-medium mb-2">Drag & drop your image here</p>
              <p class="text-sm text-gray-500 mb-4">or browse to select a file</p>
              <button class="upload-button bg-sky-600 hover:bg-sky-500 text-white px-5 py-2 rounded-lg text-sm shadow-md transition">
                Browse Files
              </button>
              <input type="file" name="image" id="fileInput" accept="image/*" class="hidden" />
            </div>

            @if ($errors->has('image'))
              <p class="text-red-500 text-sm mt-2">{{ $errors->first('image') }}</p>
            @endif

            <!-- Preview -->
            <div id="imagePreviewContainer" class="hidden mt-6 relative flex flex-col items-center">
              <div class="relative w-full h-64 flex justify-center items-center bg-gray-800 rounded-xl border-2 border-dashed border-sky-500">
                <img id="previewImage" class="max-h-full max-w-full object-contain rounded-lg" alt="Preview" />
                <button id="removeImageBtn" class="absolute top-3 right-3 hover:scale-110 transition" title="Remove image">
                  <i class="fas fa-times-circle text-sky-400 text-2xl"></i>
                </button>
              </div>
              <p class="text-xs text-gray-400 mt-2 italic">Click × to remove the image</p>
            </div>
          </div>

          <!-- Resize Options -->
          <div class="preview-section bg-gray-800 p-4">
            <h3 class="text-xl font-semibold text-white mb-6">Upscale Image</h3>

            <div class="flex flex-wrap w-full mb-6">        

              <!-- Dimensions Box - 50% width -->
              <div class="w-full sm:w-1/2 px-2">
                <div
                  class="bg-gray-900 p-4 rounded-lg border border-gray-700 text-center shadow-md w-full">
                  <p class="text-md text-gray-300">
                    Original dimensions: <span id="originalDimensions">Height × Width px</span>
                  </p>
                </div>
              </div>

              <!-- Checkbox Section - 50% width with border -->
              <div class="w-full sm:w-1/2 px-2 mb-4 sm:mb-0">
                <div class="rounded-lg p-4 w-full flex items-center">
                  <label for="upscaleCheckbox" class="flex items-center space-x-3 cursor-pointer w-full text-sky-400">
                    <!-- <input type="checkbox" id="upscaleCheckbox" name="upscale" class="w-5 h-5 rounded border-2 text-sky-600 bg-gray-900 border-gray-600 focus:ring-sky-500 mr-2" checked /> -->
                    <input type="checkbox" id="upscale" checked hidden>
                    <span class="text-md font-medium">Increase image size by 2 times.</span>
                  </label>
                </div>
              </div>

        </div>


            <!-- Submit Button -->
            <button id="resizeButton" type="submit"
              class="w-full bg-sky-600 hover:bg-sky-500 text-white py-3 rounded-lg text-sm font-semibold shadow-md transition disabled:bg-gray-600 disabled:cursor-not-allowed"
              disabled>
              Upscale Image
            </button>
          </div>
        </form>
      </div>
    </div>

  <script>

    document.addEventListener("DOMContentLoaded", function () {
      const dropArea = document.getElementById("dropArea");
      const fileInput = document.getElementById("fileInput");
      const imagePreviewContainer = document.getElementById("imagePreviewContainer");
      const previewImage = document.getElementById("previewImage");
      const removeImageBtn = document.getElementById("removeImageBtn");
      const resizeButton = document.getElementById("resizeButton");
      const originalDimensions = document.getElementById("originalDimensions");
      const upscaleCheckbox = document.getElementById("upscale");
      const widthInput = document.getElementById("width");
      const heightInput = document.getElementById("height");

      let originalWidth = 1080;
      let originalHeight = 2000;
      let aspectRatio = originalWidth / originalHeight;

      dropArea.addEventListener("click", () => fileInput.click());
      fileInput.addEventListener("change", () => handleFiles(fileInput.files));
      removeImageBtn.addEventListener("click", (e) => {
        e.stopPropagation(); resetImagePreview();
      });

      ["dragenter", "dragover", "dragleave", "drop"].forEach(ev =>
        dropArea.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); })
      );

      ["dragenter","dragover"].forEach(ev => dropArea.addEventListener(ev, () => dropArea.classList.add("bg-sky-50")));
      ["dragleave","drop"].forEach(ev => dropArea.addEventListener(ev, () => dropArea.classList.remove("bg-sky-50")));

      dropArea.addEventListener("drop", (e) => handleFiles(e.dataTransfer.files));

      function handleFiles(files) {
        if (files.length > 0 && files[0].type.match("image.*")) {
          const reader = new FileReader();
          reader.onload = (e) => {
            previewImage.src = e.target.result;
            imagePreviewContainer.classList.remove("hidden");
            dropArea.classList.add("hidden");
            const img = new Image();
            img.onload = () => {
              originalWidth = img.width;
              originalHeight = img.height;
              aspectRatio = originalWidth / originalHeight;
              originalDimensions.textContent = `${originalWidth} × ${originalHeight} px`;
              widthInput.value = originalWidth;
              heightInput.value = originalHeight;
            };
            img.src = e.target.result;
            resizeButton.disabled = false;
          };
          reader.readAsDataURL(files[0]);
        }
      }

      function resetImagePreview() {
        imagePreviewContainer.classList.add("hidden");
        previewImage.src = "";
        fileInput.value = "";
        resizeButton.disabled = true;
        dropArea.classList.remove("hidden");
        originalWidth = 1080; originalHeight = 2000; aspectRatio = originalWidth / originalHeight;
        originalDimensions.textContent = "1080 × 2000 px";
        widthInput.value = 1080; heightInput.value = 2000;
        upscaleCheckbox.checked = false;
      }

      upscaleCheckbox.addEventListener("change", function () {
        widthInput.value = this.checked ? originalWidth * 2 : originalWidth;
        heightInput.value = this.checked ? originalHeight * 2 : originalHeight;
      });

      widthInput.addEventListener("input", function () {
        if (this.value && !upscaleCheckbox.checked) heightInput.value = Math.round(this.value / aspectRatio);
      });
      heightInput.addEventListener("input", function () {
        if (this.value && !upscaleCheckbox.checked) widthInput.value = Math.round(this.value * aspectRatio);
      });
    });

    const form = document.getElementById('myForm');
    const button = document.getElementById('resizeButton');

    form.addEventListener('submit', function(event) {
      // Disable the button
      button.disabled = true;
      // Change the button text
      button.textContent = 'Wait while processing...';
    });

  </script>

@endsection