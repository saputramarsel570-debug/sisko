<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISKO | Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-sky-500 to-blue-300 flex items-center justify-center p-4">

  <!-- Container Utama -->
  <div class="w-full max-w-5xl bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row animate-fadeIn">

    <!-- Kolom Kiri (Ilustrasi) -->
    <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-blue-700 to-sky-500 items-center justify-center p-8 relative">
      <div class="text-center text-white space-y-4 z-10">
        <img src="{{ asset('/img/BBB.png') }}" class="w-32 h-32 mx-auto drop-shadow-2xl animate-bounce-slow" alt="Logo SISKO">
        <h1 class="text-3xl font-bold tracking-wide">SISKO</h1>
        <p class="text-white/80 text-sm">Sistem Informasi Sekolah Online</p>
      </div>
      <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
    </div>

    <!-- Kolom Kanan (Form Login) -->
    <div class="w-full md:w-1/2 p-8 sm:p-10 flex flex-col justify-center space-y-6">
      
      <!-- Heading -->
      <div class="text-center mb-2">
        <h2 class="text-2xl font-bold text-blue-700">Selamat Datang 👋</h2>
        <p class="text-gray-500 text-sm">Silakan login untuk melanjutkan</p>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
            class="mt-1 block w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 px-4 py-2 text-gray-700 placeholder-gray-400 shadow-sm">
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <div class="relative mt-1">
            <input type="password" id="password" name="password" required
              class="block w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 px-4 py-2 pr-10 text-gray-700 placeholder-gray-400 shadow-sm">
            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-400 hover:text-blue-500" id="togglePassword">
              <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
              </svg>
            </span>
          </div>
        </div>

       

        <!-- Tombol Login -->
        <button type="submit" 
          class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transition duration-200 ease-in-out">
          Login
        </button>
      </form>

      <!-- Footer -->
      <p class="text-center text-xs text-gray-500 mt-4">© {{ date('Y') }} SISKO — Created by Tamarog</p>
    </div>
  </div>

  <!-- Script show/hide password -->
  <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
      eyeIcon.setAttribute('stroke', type === 'text' ? 'blue' : 'currentColor');
    });
  </script>

  <!-- Animasi -->
  <style>
    .animate-fadeIn {
      animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px) scale(0.98); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .animate-bounce-slow {
      animation: bounceSlow 3s infinite ease-in-out;
    }
    @keyframes bounceSlow {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }
  </style>

</body>
</html>