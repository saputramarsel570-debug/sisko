<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Aplikasi SISKO - Sistem Informasi Sekolah Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-600 via-sky-500 to-blue-300 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white/20 backdrop-blur-md shadow-md p-4 flex justify-center items-center text-white">
    <div class="flex items-center justify-center space-x-3">
      <h1 class="font-bold text-xl tracking-wide">Sistem Informasi Sekolah Online</h1>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="flex-1 flex flex-col md:flex-row items-center justify-center px-4 sm:px-6 md:px-16 py-12 md:py-16 gap-8 md:gap-12 overflow-hidden">

    <!-- Ilustrasi -->
    <div class="md:w-1/2 flex justify-center order-1 md:order-1 animate-fadeInLeft delay-800 mb-8 md:mb-0">
      <img src="{{ asset('img/cuyy.png') }}" 
           alt="Ilustrasi Sekolah" 
           class="w-64 sm:w-72 md:w-80 lg:w-96 max-w-full h-auto drop-shadow-2xl animate-floating">
    </div>
    
    <!-- Kotak Teks -->
    <div class="md:w-1/2 text-center md:text-left bg-white/80 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-xl order-2 md:order-2 animate-fadeInRight">
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-blue-700 leading-tight animate-fadeInUp delay-200">
        Selamat Datang di <br>
        <span class="text-sky-500">SISKO - Sistem Informasi Sekolah Online</span>
      </h2>
      <p class="mt-5 text-gray-600 text-base sm:text-lg leading-relaxed animate-fadeInUp delay-400">
        Kelola data siswa, guru, orang tua, dan kegiatan sekolah dengan mudah dalam satu platform modern.
      </p>

      <!-- Tombol -->
      <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4 animate-fadeInUp delay-600">
        <!-- Tombol Login -->
        <a href="/login" 
           class="bg-gradient-to-r from-blue-600 to-sky-500 text-white px-7 py-3 rounded-full shadow-lg hover:shadow-blue-300 hover:scale-105 transition-all duration-300 font-semibold">
           Login Sekarang
        </a>
        <!-- Tombol Pelajari -->
        <a href="{{ route('about') }}" 
           class="bg-white text-blue-600 border-2 border-blue-500 px-7 py-3 rounded-full font-semibold shadow-md hover:bg-blue-50 hover:text-blue-700 hover:scale-105 transition-all duration-300">
           Pelajari
        </a>
      </div>
    </div>

  </section>

  <!-- Footer -->
  <footer class="bg-white/20 backdrop-blur-md text-white text-center py-5 mt-auto">
    <p>Copyright &copy; {{ date('Y') }}. Created by Tamarog</p>
  </footer>

  <!-- Animasi halus -->
  <style>
    .animate-fadeInUp {
      animation: fadeInUp 1s forwards;
      opacity: 0;
    }
    .animate-fadeInLeft {
      animation: fadeInLeft 1s forwards;
      opacity: 0;
    }
    .animate-fadeInRight {
      animation: fadeInRight 1s forwards;
      opacity: 0;
    }

    /* Delay utility */
    .delay-200 { animation-delay: 0.2s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-600 { animation-delay: 0.6s; }
    .delay-800 { animation-delay: 0.8s; }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInLeft {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(20px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* Logo bergerak lembut */
    @keyframes floating {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .animate-floating {
      animation: floating 3s ease-in-out infinite;
    }
  </style>

</body>
</html>