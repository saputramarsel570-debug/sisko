<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Panduan Guru - SISKO</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-600 via-sky-500 to-blue-300 text-gray-800">

  <!-- Navbar -->
  <nav class="relative bg-white/20 backdrop-blur-md shadow-md px-6 py-3 flex items-center justify-end text-white">
    <h1 class="absolute left-1/2 transform -translate-x-1/2 font-bold text-lg sm:text-xl tracking-wide text-center drop-shadow-md">
      SISKO
    </h1>
    <a href="{{ route('about') }}" 
       class="flex items-center bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-full shadow-lg backdrop-blur-sm transition-all duration-300 animate-bounce-slow hover:scale-110 hover:shadow-blue-300">
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-1">
         <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
       </svg>
       Kembali
    </a>
  </nav>

  <!-- Header -->
  <section class="text-center py-12 px-6 animate-fadeInUp text-white">
    <h2 class="text-4xl font-extrabold drop-shadow-lg">Panduan Penggunaan untuk Guru</h2>
    <p class="mt-4 text-blue-50 text-lg max-w-2xl mx-auto leading-relaxed">
      Pelajari cara menggunakan fitur-fitur SISKO untuk mendukung kegiatan mengajar dengan mudah dan efisien.
    </p>
  </section>

  <!-- Panduan Langkah-langkah -->
  <section class="px-6 md:px-16 py-12 space-y-16 text-white">

    <!-- Langkah 1 -->
    <div class="flex flex-col md:flex-row items-center gap-8 animate-fadeInLeft">
      <img src="{{ asset('img/nnnn.jpg') }}" alt="Langkah 1" class="w-full md:w-1/2 rounded-2xl shadow-2xl">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-bold text-blue-100">1. Login ke Akun Guru</h3>
        <p class="mt-3 text-blue-50 leading-relaxed">
          Masuk ke sistem menggunakan akun guru yang telah disediakan oleh admin sekolah untuk mengakses dashboard mengajar.
        </p>
      </div>
    </div>

    <!-- Langkah 2 -->
    <div class="flex flex-col md:flex-row-reverse items-center gap-8 animate-fadeInRight">
      <img src="{{ asset('img/guru2.jpg') }}" alt="Langkah 2" class="w-full md:w-1/2 rounded-2xl shadow-2xl">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-bold text-blue-100">2. Melihat Jadwal Mengajar</h3>
        <p class="mt-3 text-blue-50 leading-relaxed">
          Guru dapat melihat jadwal pelajaran di menu “Jadwal” untuk mengetahui waktu dan kelas tempat mengajar setiap harinya.
        </p>
      </div>
    </div>

    <!-- Langkah 3 -->
    <div class="flex flex-col md:flex-row items-center gap-8 animate-fadeInLeft">
      <img src="{{ asset('img/guru3.jpg') }}" alt="Langkah 3" class="w-full md:w-1/2 rounded-2xl shadow-2xl">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-bold text-blue-100">3. Menginput Nilai dan Absensi</h3>
        <p class="mt-3 text-blue-50 leading-relaxed">
          Melalui menu “Nilai & Absensi”, guru dapat mencatat kehadiran siswa dan menginput nilai setiap mata pelajaran dengan cepat.
        </p>
      </div>
    </div>

    <!-- Langkah 4 -->
    <div class="flex flex-col md:flex-row-reverse items-center gap-8 animate-fadeInRight">
      <img src="{{ asset('img/guru4.jpg') }}" alt="Langkah 4" class="w-full md:w-1/2 rounded-2xl shadow-2xl">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-bold text-blue-100">4. Mengunggah Materi dan Tugas</h3>
        <p class="mt-3 text-blue-50 leading-relaxed">
          Gunakan menu “Materi & Tugas” untuk membagikan bahan ajar dan tugas kepada siswa, serta memantau pengumpulan tugas mereka.
        </p>
      </div>
    </div>

    <!-- Langkah 5 -->
    <div class="flex flex-col md:flex-row items-center gap-8 animate-fadeInLeft">
      <img src="{{ asset('img/guru5.jpg') }}" alt="Langkah 5" class="w-full md:w-1/2 rounded-2xl shadow-2xl">
      <div class="md:w-1/2">
        <h3 class="text-2xl font-bold text-blue-100">5. Membuat Pengumuman</h3>
        <p class="mt-3 text-blue-50 leading-relaxed">
          Guru juga dapat membuat pengumuman untuk kelas atau seluruh siswa melalui menu “Pengumuman”.
        </p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white/20 backdrop-blur-md text-white text-center py-5 mt-auto shadow-inner">
    <p class="font-light tracking-wide">Copyright &copy; {{ date('Y') }}. Created by <span class="font-semibold">Tamarog</span></p>
  </footer>

  <!-- Animasi -->
  <style>
    /* Fade-in efek */
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

    /* Tombol kembali animasi lembut */
    @keyframes bounceSlow {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-3px); }
    }
    .animate-bounce-slow {
      animation: bounceSlow 3s ease-in-out infinite;
    }
  </style>

</body>
</html>