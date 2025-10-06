<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Panduan Siswa - SISKO</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-600 via-sky-500 to-blue-300 text-white">

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

  <!-- Hero Section -->
  <section class="text-center py-12 px-6 animate-fadeInUp">
    <h2 class="text-4xl font-extrabold text-white drop-shadow-lg">Panduan Penggunaan untuk Siswa</h2>
    <p class="mt-4 text-blue-50 text-lg">Ikuti panduan ini untuk memahami semua fitur di aplikasi SISKO.</p>
  </section>

  <!-- Panduan Fitur -->
  <section class="px-6 md:px-16 py-12 space-y-10">

    <!-- 1. Dashboard -->
    <div class="flex flex-col md:flex-row items-center bg-white/80 backdrop-blur-md rounded-2xl shadow-lg p-6 animate-fadeInLeft">
      <div class="md:w-1/3 text-center md:text-left">
        <h3 class="text-2xl font-bold text-blue-700">1. Dashboard</h3>
      </div>
      <div class="md:w-2/3 mt-3 md:mt-0 text-gray-700">
        Halaman pertama setelah login adalah <strong>Dashboard</strong>. Siswa dapat melihat detail pribadi seperti NIS, nama, kelas, alamat, username, dan role. Dashboard berfungsi sebagai pusat informasi utama.
      </div>
    </div>

    <!-- 2. Kelola Absensi -->
    <div class="flex flex-col md:flex-row-reverse items-center bg-white/80 backdrop-blur-md rounded-2xl shadow-lg p-6 animate-fadeInRight">
      <div class="md:w-1/3 text-center md:text-left">
        <h3 class="text-2xl font-bold text-blue-700">2. Kelola Absensi</h3>
      </div>
      <div class="md:w-2/3 mt-3 md:mt-0 text-gray-700">
        Fitur ini khusus untuk <strong>siswa perwakilan kelas</strong>. Kamu dapat mencatat kehadiran teman-teman dengan memilih status: Hadir, Izin, Sakit, atau Alfa, dan menambahkan keterangan jika perlu.
        <ul class="list-disc list-inside mt-2">
          <li><strong>Absensi Harian:</strong> Lihat dan edit status siswa per hari.</li>
          <li><strong>Rekap Harian:</strong> Mengubah data jika ada perubahan atau kesalahan.</li>
          <li><strong>Absensi Bulanan:</strong> Melihat ringkasan kehadiran per bulan dengan filter tanggal.</li>
        </ul>
      </div>
    </div>

    <!-- 3. Pengaturan Sekolah -->
    <div class="flex flex-col md:flex-row items-center bg-white/80 backdrop-blur-md rounded-2xl shadow-lg p-6 animate-fadeInLeft">
      <div class="md:w-1/3 text-center md:text-left">
        <h3 class="text-2xl font-bold text-blue-700">3. Pengaturan Sekolah</h3>
      </div>
      <div class="md:w-2/3 mt-3 md:mt-0 text-gray-700">
        Menampilkan informasi umum sekolah seperti nama, alamat, kontak, dan data penting lainnya untuk siswa.
      </div>
    </div>

    <!-- 4. Jadwal Pelajaran -->
    <div class="flex flex-col md:flex-row-reverse items-center bg-white/80 backdrop-blur-md rounded-2xl shadow-lg p-6 animate-fadeInRight">
      <div class="md:w-1/3 text-center md:text-left">
        <h3 class="text-2xl font-bold text-blue-700">4. Jadwal Pelajaran</h3>
      </div>
      <div class="md:w-2/3 mt-3 md:mt-0 text-gray-700">
        Klik <strong>Pilih Kelas</strong> untuk menampilkan daftar kelas. Setelah memilih, jadwal pelajaran sesuai kelas akan muncul, sehingga siswa mudah mengetahui jadwal harian dan mingguan.
      </div>
    </div>

    <!-- 5. Pengumuman Sekolah -->
    <div class="flex flex-col md:flex-row items-center bg-white/80 backdrop-blur-md rounded-2xl shadow-lg p-6 animate-fadeInLeft">
      <div class="md:w-1/3 text-center md:text-left">
        <h3 class="text-2xl font-bold text-blue-700">5. Pengumuman Sekolah</h3>
      </div>
      <div class="md:w-2/3 mt-3 md:mt-0 text-gray-700">
        Semua pengumuman dari guru akan muncul di menu ini. Klik <strong>Lihat Detail</strong> untuk membaca informasi lengkap agar tidak ketinggalan info penting.
      </div>
    </div>

    <!-- 6. Keluhan & Saran -->
    <div class="flex flex-col md:flex-row-reverse items-center bg-white/80 backdrop-blur-md rounded-2xl shadow-lg p-6 animate-fadeInRight">
      <div class="md:w-1/3 text-center md:text-left">
        <h3 class="text-2xl font-bold text-blue-700">6. Keluhan & Saran</h3>
      </div>
      <div class="md:w-2/3 mt-3 md:mt-0 text-gray-700">
        Siswa dapat mengirimkan keluhan atau saran. Pilih jenis data yang ingin dikirim, simpan, dan dapat diedit, dilihat detail, atau dihapus.
        <ul class="list-disc list-inside mt-2">
          <li><strong>Pending:</strong> Belum diproses guru</li>
          <li><strong>Proses:</strong> Sedang ditanggapi guru</li>
          <li><strong>Selesai:</strong> Telah ditindaklanjuti, balasan guru bisa dilihat</li>
        </ul>
      </div>
    </div>

  </section>

  <!-- Footer -->
  <footer class="bg-white/20 backdrop-blur-md text-white text-center py-5 mt-auto shadow-inner">
    <p class="font-light tracking-wide">
      Copyright &copy; {{ date('Y') }}. Created by <span class="font-semibold">Tamarog</span>
    </p>
  </footer>

  <!-- Animasi -->
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