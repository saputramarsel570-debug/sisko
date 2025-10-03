<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang SISKO - Sistem Informasi Sekolah Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-br from-sky-50 via-blue-100 to-sky-200">

  <!-- Navbar -->
  <nav class="bg-gradient-to-r from-blue-600 to-sky-500 shadow-md p-4 flex justify-between items-center text-white">
    <div class="flex items-center space-x-3">
      <img src="{{ asset('img/Sisko0.jpg') }}" alt="Logo Sekolah" class="w-10 h-10 rounded-full object-cover">
      <h1 class="font-bold text-xl tracking-wide">SISKO</h1>
    </div>
    <a href="/" class="bg-white text-blue-700 px-4 py-2 rounded-full shadow hover:bg-sky-50 transition">⬅ Kembali</a>
  </nav>

  <!-- Hero -->
  <section class="text-center py-12 px-6 animate-fadeInUp">
    <h2 class="text-4xl font-extrabold text-blue-700 animate-fadeInUp delay-200">Tentang SISKO</h2>
    <p class="mt-4 text-gray-600 text-lg animate-fadeInUp delay-400">
      SISKO adalah Sistem Informasi Sekolah Online yang dirancang untuk mempermudah manajemen data dan komunikasi di lingkungan sekolah.
    </p>
  </section>

  <!-- Role Cards -->
  <section class="px-6 md:px-16 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Siswa -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl hover:scale-105 transition transform animate-fadeInUp delay-200">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Siswa" class="w-16 mx-auto mb-4">
      <h3 class="text-xl font-bold text-blue-600">Siswa</h3>
      <p class="text-gray-600 mt-2">Siswa dapat melihat jadwal, nilai, absensi, serta menerima pengumuman terbaru dari sekolah secara langsung.</p>
    </div>
    <!-- Guru -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl hover:scale-105 transition transform animate-fadeInUp delay-400">
      <img src="https://cdn-icons-png.flaticon.com/512/201/201818.png" alt="Guru" class="w-16 mx-auto mb-4">
      <h3 class="text-xl font-bold text-blue-600">Guru</h3>
      <p class="text-gray-600 mt-2">Guru dapat mengelola jadwal mengajar, input nilai, absen siswa, serta memberikan informasi kepada orangtua dan siswa.</p>
    </div>
    <!-- Orangtua -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl hover:scale-105 transition transform animate-fadeInUp delay-600">
      <img src="https://cdn-icons-png.flaticon.com/512/2942/2942862.png" alt="Orangtua" class="w-16 mx-auto mb-4">
      <h3 class="text-xl font-bold text-blue-600">Orangtua</h3>
      <p class="text-gray-600 mt-2">Orangtua dapat memantau perkembangan anak di sekolah, mulai dari kehadiran, nilai, hingga jadwal kegiatan.</p>
    </div>
    <!-- Admin -->
    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl hover:scale-105 transition transform animate-fadeInUp delay-800">
      <img src="https://cdn-icons-png.flaticon.com/512/3595/3595455.png" alt="Admin" class="w-16 mx-auto mb-4">
      <h3 class="text-xl font-bold text-blue-600">Admin</h3>
      <p class="text-gray-600 mt-2">Admin mengelola seluruh data sekolah, termasuk data siswa, guru, kelas, serta pengaturan sistem secara keseluruhan.</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-blue-700 to-sky-600 text-white text-center py-5 mt-auto">
    <p>&copy; 2025 SISKO. Dibuat untuk mendukung pendidikan yang lebih modern.</p>
  </footer>

  <!-- Animasi halus -->
  <style>
    .animate-fadeInUp {
      animation: fadeInUp 1s forwards;
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
  </style>

</body>
</html>