<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi SISKO - Sistem Informasi Sekolah Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-600 via-sky-500 to-blue-300 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white/20 backdrop-blur-md shadow-md p-4 flex justify-between items-center text-white">
    <div class="flex items-center space-x-3">
      <img src="{{ asset('img/Sisko0.jpg') }}" alt="Logo Sekolah" class="w-10 h-10 rounded-full object-cover shadow-md">
      <h1 class="font-bold text-xl tracking-wide">SISKO</h1>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="flex-1 flex flex-col md:flex-row items-center justify-center px-6 md:px-16 py-16 gap-12">

    <!-- Text -->
    <div class="md:w-1/2 text-center md:text-left bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-xl animate-fadeInLeft">
      <h2 class="text-4xl md:text-5xl font-extrabold text-blue-700 leading-tight animate-fadeInUp delay-200">
        Selamat Datang di <br>
        <span class="text-sky-500">Sistem Informasi Sekolah Online</span>
      </h2>
      <p class="mt-5 text-gray-600 text-lg leading-relaxed animate-fadeInUp delay-400">
        Kelola data siswa, guru, dan kegiatan sekolah dengan mudah dalam satu platform modern.
      </p>
      <div class="mt-8 flex justify-center md:justify-start gap-5 animate-fadeInUp delay-600">
        <a href="/login" 
           class="bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700 transition">
           Login Sekarang
        </a>
        <a href="{{ route('about') }}" 
           class="bg-white border border-blue-600 text-blue-600 px-6 py-3 rounded-full shadow hover:bg-blue-50 transition">
           Pelajari
        </a>
      </div>
    </div>

    <!-- Ilustrasi -->
    <div class="md:w-1/2 flex justify-center animate-fadeInRight delay-800">
      <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" 
           alt="Ilustrasi Sekolah" 
           class="w-80 md:w-96 drop-shadow-2xl">
    </div>

  </section>

  <!-- Footer -->
  <footer class="bg-white/20 backdrop-blur-md text-white text-center py-5 mt-auto">
    <p>&copy; Copyright © 2025. Created by Tamarog</p>
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
  </style>

</body>
</html>