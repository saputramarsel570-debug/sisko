<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SISKO | Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 via-sky-500 to-blue-300">

  <!-- Container -->
  <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6 animate-fadeIn">
    
    <!-- Logo -->
    <div class="flex flex-col items-center space-y-2">
      <img src="{{ asset('/img/putih.jpg') }}" class="w-16 h-16 rounded-full shadow-md" alt="Logo SISKO">
      <h1 class="text-2xl font-bold text-blue-700">SISKO</h1>
      <p class="text-gray-500 text-sm">Sistem Informasi Sekolah Online</p>
    </div>

    <!-- Heading -->
    <div class="text-center">
      <h2 class="text-xl font-semibold text-gray-800">Welcome Back 👋</h2>
      <p class="text-sm text-gray-500">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Form -->
    <form class="space-y-4" method="POST" action="{{ route('login') }}">
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

      <!-- Remember & Forgot -->
      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center gap-2 text-gray-600">
          <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="remember" />
          Remember me
        </label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Forgot password?</a>
        @endif
      </div>

      <!-- Submit -->
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-semibold shadow-md transition">
        Login
      </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-sm text-gray-500">© Copyright © 2025. Created by Tamarog</p>
  </div>

  <!-- Script show/hide password -->
  <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;

      if (type === 'text') {
        eyeIcon.setAttribute('stroke', 'blue');
      } else {
        eyeIcon.setAttribute('stroke', 'currentColor');
      }
    });
  </script>

  <!-- Animasi -->
  <style>
    .animate-fadeIn {
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

</body>
</html>