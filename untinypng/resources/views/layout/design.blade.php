<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Favicon  -->
  <link rel="icon" href="{{ asset('images/favi-image/png-favi.png') }}" type="image/png" />

  <!-- Title -->
  <title>untinyPNG – Enhance Your PNGs with 2X Upscaling</title>

  <!-- Meta Description -->
  <meta name="description" content="UntinyPNG lets you upscale your PNG images 2X instantly, preserving quality and clarity. Easy, fast, and perfect for all your image needs." />

  <!-- Meta keywords  -->
  <meta name="keywords" content="PNG upscaler, upscale PNG images, enlarge PNG, PNG image enhancer, 2x PNG upscale, increase PNG size, high-quality PNG enlargement, image upscaling tool, PNG image resizer, untiny PNG" />

  <!-- OG Tag  -->
  <meta property="og:title" content="UntinyPNG – Upscale Your PNG Images 2X with Zero Quality Loss" />
  <meta property="og:description" content="Instantly enlarge your PNG images by 2X while preserving sharpness and transparency. Fast, easy, and free online tool." />
  <meta property="og:url" content="https://untinypng.com/" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="https://untinypng.com/images/og-image/png-og.jpg" />

  <!-- Canonical  -->
  <link rel="canonical" href="https://www.untinypng.com/" />

  <!-- Google tag (gtag.js) --> 
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-HR47PH9DXY"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-HR47PH9DXY'); </script>

  <!-- Index follow Meta Tag  -->
  <meta name="robots" content="index, follow" />

  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .container-shadow {
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.45);
    }
    .upload-area {
      transition: all 0.3s ease;
    }
    .upload-area:hover {
      background-color: #1f2937; /* gray-800 */
      border-color: #38bdf8; /* sky-400 */
      transform: scale(1.02);
    }
    .preview-section {
      max-height: calc(100vh - 140px);
      overflow-y: auto;
    }
  </style>
</head>
<body class="bg-gray-900 text-gray-200 flex flex-col">
  
  <!-- Header -->
  <header class="bg-gray-800 container-shadow text-sky-400 py-4 shadow-md px-4">
    <div class="w-full max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between px-4 sm:px-12">
      
      <!-- Logo -->
      <div class="flex items-center mb-4 sm:mb-0 sm:ml-0 ml-4">
        <img src="{{ asset('images/logo-image/png-logo.png') }}" alt="Logo" class="w-10 h-10 mr-2" />
        <h1 class="text-2xl font-bold text-white whitespace-nowrap">untinyPNG.com</h1>
      </div>

      <!-- Menu -->
      <div class="flex space-x-3 sm:space-x-8 text-sm sm:text-base">
        <div class="flex items-center cursor-pointer text-sky-400 hover:text-white px-2 py-1 sm:px-3 sm:py-1.5 rounded" onclick="showPopup()">
          <span class="font-semibold">API</span>
        </div>
        <div class="flex items-center cursor-pointer text-sky-400 hover:text-white px-2 py-1 sm:px-3 sm:py-1.5 rounded" onclick="showPricing()">
          <span class="font-semibold">Pricing</span>
        </div>
      </div>

    </div>
  </header>


        <!-- Popup API Modal -->
      <div 
        id="popupModal" 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 opacity-0 pointer-events-none transition-opacity duration-300 z-50 text-center">
        <div 
          id="popupContent"
          class="relative bg-[#0d1b2a] text-white rounded-[12px] p-6 max-w-lg container-shadow font-sans transform -translate-y-5 transition-transform duration-300"  >

          <!-- Close Icon -->
          <button 
            onclick="hidePopup()" 
            aria-label="Close popup"
            class="absolute top-3 right-3 text-white hover:text-sky-400 focus:outline-none"
            >
            <!-- Simple X icon using SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <h2 class="font-bold text-xl mb-4 text-[#1e90ff] tracking-[0.03em]">
            API Coming Soon!
          </h2>
          <p class="text-md mb-6 leading-6 text-slate-300">
            We’re building a powerful API to let you integrate untinyPNG’s image upscaling directly into your applications. Stay tuned for launch updates!
          </p>
          <button 
            onclick="hidePopup()" 
            class="bg-sky-600 border-0 px-3 py-2 rounded-lg text-white font-bold cursor-pointer text-md ">
            Close
          </button>
        </div>
      </div>

      <!-- Pricing Modal -->
      <div 
        id="pricingModal" 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 opacity-0 pointer-events-none transition-opacity duration-300 z-50 text-center">
        <div 
          id="pricingContent"
          class="relative bg-[#0d1b2a] text-white rounded-[12px] p-8 max-w-md container-shadow font-sans transform -translate-y-5 transition-transform duration-300 shadow-lg">

          <!-- Close Icon -->
          <button 
            onclick="hidePricing()" 
            aria-label="Close pricing popup"
            class="absolute top-4 right-4 text-white hover:text-sky-400 focus:outline-none"
            >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>

          <h2 class="font-bold text-2xl mb-6 text-[#1e90ff] tracking-wide">
            Pricing
          </h2>
          <p class="text-md mb-8 leading-7 text-slate-300">
            Pricing is also coming soon! Stay tuned for updates.
          </p>
          
          <button 
            onclick="hidePopup()" 
            class="bg-sky-600 border-0 px-3 py-2 rounded-lg text-white font-bold cursor-pointer text-md ">
            Close
          </button>
        </div>
      </div>

  <!-- Intro Section -->
  <section class="text-center py-8 px-4">
    <i class="bi bi-arrows-fullscreen text-sky-400 text-4xl font-semibold mb-4"></i>
    <h2 class="text-5xl font-bold text-white mb-2">Upscale Your Image</h2>
    <p class="text-lg text-gray-300 max-w-2xl mx-auto">
      Enhance your images with 2× upscaling.
      Easy, and AI-powered.
    </p>
  </section>

  <!-- Main Tool -->
  <main class="w-full max-w-3xl mx-auto px-4 pb-5">

     <!-- Content -->
     @yield('content')

    <!-- Process Section -->
    <section class="w-full max-w-4xl p-5 mx-auto">
      <h2 class="text-2xl font-bold text-white text-center mb-6">How It Works</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
        <div class="group">
          <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-gray-700 text-sky-400 mb-4 text-3xl group-hover:bg-sky-600 group-hover:text-white transition">
            <i class="bi bi-cloud-arrow-up"></i>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">1. Upload</h3>
          <p class="text-gray-400 max-w-xs mx-auto">Drag & drop or browse your image file.</p>
        </div>
        <div class="group">
          <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-gray-700 text-sky-400 mb-4 text-3xl group-hover:bg-sky-600 group-hover:text-white transition">
            <i class="bi bi-arrows-fullscreen"></i>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">2. Upscale</h3>
          <p class="text-gray-400 max-w-xs mx-auto">Double your image resolution instantly.</p>
        </div>
        <div class="group">
          <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-gray-700 text-sky-400 mb-4 text-3xl group-hover:bg-sky-600 group-hover:text-white transition">
            <i class="bi bi-download"></i>
          </div>
          <h3 class="text-lg font-semibold text-white mb-2">3. Download</h3>
          <p class="text-gray-400 max-w-xs mx-auto">Save your enhanced image in high quality.</p>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 container-shadow text-white py-3 text-center mt-auto">
    <p class="text-sm font-semibold tracking-wide">
      © 2025 A product of 
      <a href="https://essenn.associates/" target="_blank" rel="noopener noreferrer" class="underline">
        ESS ENN
      </a> 
      Associates. All rights reserved.
    </p>
  </footer>

  <!-- Script -->
  <script>

    const popupModal = document.getElementById('popupModal');
    const popupContent = document.getElementById('popupContent');

    function showPopup() {
      popupModal.classList.remove('pointer-events-none');
      popupModal.classList.add('opacity-100');
      popupContent.style.transform = 'translateY(0)';
      popupModal.style.opacity = '1';
    }

    function hidePopup() {
      popupContent.style.transform = 'translateY(-20px)';
      popupModal.style.opacity = '0';
      setTimeout(() => {
        popupModal.classList.add('pointer-events-none');
        popupModal.classList.remove('opacity-100');
      }, 300);
    }

    // 🧠 Click outside popupContent closes the modal
    popupModal.addEventListener('click', function (event) {
      // If the click target is NOT inside the popupContent
      if (!popupContent.contains(event.target)) {
        hidePopup();
      }
    });


    const pricingModal = document.getElementById('pricingModal');
    const pricingContent = document.getElementById('pricingContent');

    function showPricing() {
      pricingModal.classList.remove('pointer-events-none');
      pricingModal.classList.add('opacity-100');
      pricingContent.style.transform = 'translateY(0)';
      pricingModal.style.opacity = '1';
    }

    function hidePricing() {
      pricingContent.style.transform = 'translateY(-20px)';
      pricingModal.style.opacity = '0';
      setTimeout(() => {
        pricingModal.classList.add('pointer-events-none');
        pricingModal.classList.remove('opacity-100');
      }, 300);
    }

    // Close when clicking outside pricing content
    pricingModal.addEventListener('click', function(event) {
      if (!pricingContent.contains(event.target)) {
        hidePricing();
      }
    });


  </script>

</body>
</html>
