@extends('layout.design')

@section('content')

    <div class="w-[90%] mx-auto bg-gray-800 rounded-2xl container-shadow overflow-hidden mb-5">
      <div>
            @if(session('success'))
                <div class="text-white p-6 rounded-xl max-w-3xl mx-auto">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-lg max-w-3xl mx-auto mt-8 shadow-sm">
                        <div class="flex flex-col space-y-1">
                            <h2 class="text-base font-semibold">{{ session('success') }}</h2>
                            <p class="text-base"><strong>Original Size:  </strong>{{ session('original_width') }} x {{ session('original_height') }} px</p>
                            <p class="text-base"><strong>New Size:  </strong>{{ session('new_width') }} x {{ session('new_height') }} px</p>
                        </div>
                    </div>
                    @if(session('output_image'))
                        <div class="p-4 rounded-lg">
                            <p class="text-sm mb-3 font-medium text-sky-300">Here is your upscaled image:</p>

                            <img src="{{ session('output_image') }}" alt="Upscaled Image"
                                class="w-full max-w-md mx-auto rounded-lg mb-4">

                            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-4">
                                <a href="{{ session('output_image') }}" download
                                class="bg-sky-400 text-black px-5 py-2.5 rounded-md font-semibold text-sm hover:bg-sky-300 transition duration-200">
                                    <i class="bi bi-download mr-1"></i>
                                     Download Image
                                </a>
                                <a href="{{ url()->previous() }}"
                                class="bg-[#3a3a55] text-white px-5 py-2.5 rounded-md font-semibold text-sm hover:bg-[#4a4a66] transition duration-200">
                                    <i class="bi bi-arrow-left mr-1"></i>
                                     Back
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

      </div>
    </div>

@endsection