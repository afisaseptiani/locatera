<?php
// Pengaturan path base untuk XAMPP
$projectBasePath = '/locatera/';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Support - Locatera</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Poppins', 'sans-serif']
          },
          colors: {
            'locatera-orange': '#FF9D3D',
            'locatera-dark': '#374151',
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-white font-poppins text-locatera-dark">

  <div class="max-w-md mx-auto min-h-screen shadow-xl flex flex-col bg-gray-50">

    <header class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-10">
      <a href="javascript:history.back()" class="p-2 -ml-2 hover:bg-gray-100 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-locatera-dark">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
      </a>
      <h1 class="text-lg font-bold flex-grow text-center mr-6">Customer support</h1>
      <button class="p-2 rounded-full hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>
    </header>

    <div class="flex-grow overflow-y-auto p-4 space-y-4">

      <div class="flex items-end gap-2 max-w-xs sm:max-w-sm">
        <div class="w-8 h-8 rounded-full bg-orange-200 flex items-center justify-center text-locatera-dark text-lg font-bold">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-locatera-orange">
            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.668-7.812-1.815a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="bg-gray-100 p-3 rounded-xl rounded-bl-none text-sm shadow-sm">
          Hi, ada yang bisa saya bantu?
        </div>
      </div>

      <div class="flex justify-end">
        <div class="flex items-end gap-2 max-w-xs sm:max-w-sm">
          <div class="bg-locatera-orange text-white p-3 rounded-xl rounded-br-none text-sm shadow-md">
            Hi, saya mau memesan 1 cheesecult dan 1 tiramisusu matcha, apakah ada?
          </div>
          <div class="w-8 h-8 rounded-full bg-pink-300 flex items-center justify-center text-white text-xs font-bold overflow-hidden">
            <img src="./src/asset/profil.jpg" alt="User" class="w-full h-full object-cover">
          </div>
        </div>
      </div>

      <div class="flex items-end gap-2 max-w-xs sm:max-w-sm">
        <div class="w-8 h-8 rounded-full bg-orange-200 flex items-center justify-center text-locatera-dark text-lg font-bold">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-locatera-orange">
            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.668-7.812-1.815a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="bg-gray-100 p-3 rounded-xl rounded-bl-none text-sm shadow-sm">
          Baik, akan saya periksa, mohon ditunggu
        </div>
      </div>

      <div class="flex justify-end">
        <div class="flex items-end gap-2 max-w-xs sm:max-w-sm">
          <button class="bg-locatera-orange text-white font-bold px-4 py-2 rounded-xl text-sm shadow-md transition">
            Oke
          </button>
          <div class="w-8 h-8 rounded-full bg-pink-300 text-white text-xs font-bold overflow-hidden">
            <img src="./src/asset/profil.jpg" alt="User" class="w-full h-full object-cover">
          </div>
        </div>
      </div>

      <div class="flex items-end gap-2 max-w-xs sm:max-w-sm">
        <div class="w-8 h-8 rounded-full bg-orange-200 flex items-center justify-center text-locatera-dark text-lg font-bold">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-locatera-orange">
            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.668-7.812-1.815a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="bg-gray-100 p-3 rounded-xl rounded-bl-none text-sm shadow-sm">
          Untuk kedua barang tersebut ada, silakan langsung pesan
        </div>
      </div>

      <div class="flex justify-end">
        <div class="flex items-end gap-2 max-w-xs sm:max-w-sm">
          <div class="bg-locatera-orange text-white p-3 rounded-xl rounded-br-none text-sm shadow-md">
            Tentu, terimakasih
          </div>
          <div class="w-8 h-8 rounded-full bg-pink-300 text-white text-xs font-bold overflow-hidden">
            <img src="./src/asset/profil.jpg" alt="User" class="w-full h-full object-cover">
          </div>
        </div>
      </div>

    </div>

    <div class="p-4 bg-white border-t border-gray-100">
      <div class="flex gap-2">
        <input type="text" placeholder="Ketik pesan..." class="flex-grow p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-1 focus:ring-locatera-orange">
        <button class="bg-locatera-orange text-white p-3 rounded-full hover:bg-orange-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
          </svg>
        </button>
      </div>
    </div>

  </div>
</body>

</html>