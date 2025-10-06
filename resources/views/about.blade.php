<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang SISKO - Sistem Informasi Sekolah Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-600 via-sky-500 to-blue-300 text-gray-800">

  <!-- Navbar -->
  <nav class="relative bg-white/20 backdrop-blur-md shadow-md px-6 py-3 flex items-center justify-end text-white">
    
    <!-- Tengah: Judul -->
    <h1 class="absolute left-1/2 transform -translate-x-1/2 font-bold text-lg sm:text-xl tracking-wide text-center drop-shadow-md">
      SISKO
    </h1>

    <!-- Kanan: Tombol Kembali -->
    <a href="/" 
       class="flex items-center bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-full shadow-lg backdrop-blur-sm transition-all duration-300 animate-bounce-slow hover:scale-110 hover:shadow-blue-300">
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-1">
         <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
       </svg>
       Kembali
    </a>
  </nav>

  <!-- Hero -->
  <section class="text-center py-12 px-6 animate-fadeInUp text-white">
    <h2 class="text-4xl font-extrabold animate-fadeInUp delay-200 drop-shadow-lg">Tentang SISKO</h2>
    <p class="mt-4 text-blue-50 text-lg animate-fadeInUp delay-400 max-w-2xl mx-auto leading-relaxed">
      SISKO adalah Sistem Informasi Sekolah Online yang dirancang untuk mempermudah manajemen data dan komunikasi di lingkungan sekolah.
    </p>
  </section>

  <!-- Role Cards -->
  <section class="px-6 md:px-16 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

    <!-- Siswa -->
    <a href="{{ route('siswa') }}" class="bg-white/80 backdrop-blur-md p-6 rounded-2xl shadow-md hover:shadow-2xl hover:bg-white/90 transition transform hover:-translate-y-1 text-center">
      <div class="flex justify-center mb-4">
        <div class="bg-gradient-to-br from-blue-100 to-sky-200 p-4 rounded-full shadow-inner">
          <img src="https://cdn-icons-png.flaticon.com/512/921/921124.png" alt="Siswa" class="w-14 h-14 object-contain">
        </div>
      </div>
      <h3 class="text-xl font-bold text-blue-700">Siswa</h3>
      <p class="text-gray-600 mt-2">
        Siswa dapat melihat jadwal, nilai, absensi, serta menerima pengumuman terbaru dari sekolah secara langsung.
      </p>
    </a>

    <!-- Guru -->
    <a href="{{ route('guru') }}" class="bg-white/80 backdrop-blur-md p-6 rounded-2xl shadow-md hover:shadow-2xl hover:bg-white/90 transition transform hover:-translate-y-1 text-center">
      <div class="flex justify-center mb-4">
        <div class="bg-gradient-to-br from-sky-100 to-blue-200 p-4 rounded-full shadow-inner">
          <img src="https://cdn-icons-png.flaticon.com/512/201/201634.png" alt="Guru" class="w-14 h-14 object-contain">
        </div>
      </div>
      <h3 class="text-xl font-bold text-blue-700">Guru</h3>
      <p class="text-gray-600 mt-2">
        Guru dapat mengelola jadwal mengajar, input nilai, absen siswa, serta memberikan informasi kepada orangtua dan siswa.
      </p>
    </a>

    <!-- Orangtua -->
    <a href="{{ route('ortu') }}" class="bg-white/80 backdrop-blur-md p-6 rounded-2xl shadow-md hover:shadow-2xl hover:bg-white/90 transition transform hover:-translate-y-1 text-center">
      <div class="flex justify-center mb-4">
        <div class="bg-gradient-to-br from-blue-100 to-indigo-200 p-4 rounded-full shadow-inner">
          <img src="https://cdn-icons-png.flaticon.com/512/4140/4140047.png" alt="Orangtua" class="w-14 h-14 object-contain">
        </div>
      </div>
      <h3 class="text-xl font-bold text-blue-700">Orangtua</h3>
      <p class="text-gray-600 mt-2">
        Orangtua dapat memantau perkembangan anak di sekolah, mulai dari kehadiran, nilai, hingga jadwal kegiatan.
        Klik untuk melihat panduan lengkap cara menggunakan fitur orangtua di SISKO.
      </p>
    </a>

    <!-- Admin -->
    <a href="{{ route('admin') }}" class="bg-white/80 backdrop-blur-md p-6 rounded-2xl shadow-md hover:shadow-2xl hover:bg-white/90 transition transform hover:-translate-y-1 text-center">
      <div class="flex justify-center mb-4">
        <div class="bg-gradient-to-br from-blue-100 to-sky-200 p-4 rounded-full shadow-inner">
          <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" class="w-14 h-14 object-contain">
        </div>
      </div>
      <h3 class="text-xl font-bold text-blue-700">Admin</h3>
      <p class="text-gray-600 mt-2">
        Admin mengelola seluruh data sekolah, termasuk data siswa, guru, kelas, serta pengaturan sistem secara keseluruhan.
      </p>
    </a>

  </section>

  <!-- Footer -->
  <footer class="bg-white/20 backdrop-blur-md text-white text-center py-5 mt-auto shadow-inner">
    <p class="font-light tracking-wide">Copyright &copy; {{ date('Y') }}. Created by <span class="font-semibold">Tamarog</span></p>
  </footer>

  <!-- Animasi -->
  <style>
    .animate-fadeInUp {
      animation: fadeInUp 1s forwards;
      opacity: 0;
    }

    /* Tombol kembali animasi lembut */
    @keyframes bounceSlow {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-3px); }
    }
    .animate-bounce-slow {
      animation: bounceSlow 3s ease-in-out infinite;
    }

    /* Delay utility */
    .delay-200 { animation-delay: 0.2s; }
    .delay-400 { animation-delay: 0.4s; }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

</body>
</html>