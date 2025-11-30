<?php
// (Opsional) Di sini biasanya tempat developer menghapus session/keranjang belanja
session_start();
session_destroy();
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Success - Locatera</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Cantarell', 'sans-serif'],
            'header': ['Lilita One', 'cursive'],
            'fontLogo': ['Lobster', 'cursive'],
            'roboto': ['Roboto', 'sans-serif'],
            'poppins': ['Poppins', 'sans-serif'],
          },
          colors: {
            // Definisikan warna utama dari design
            'locatera-orange': '#FF9D3D', // Oranye untuk tombol, nav, dll.
            'locatera-gray': '#F3F4F6', // Latar belakang tombol filter
            'locatera-dark': '#202020', // Teks
            'locatera-gray': '#6A6A6A', // Teks sekunder
            'locatera-blue': '#001833', // Teks sekunder
          }
        }
      }
    }
  </script>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Lilita+One&family=Lobster&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-poppins min-h-screen flex justify-center">

    <div class="w-full max-w-md lg:max-w-3xl bg-white shadow-xl min-h-screen flex flex-col relative">
        
        <div class="flex items-center justify-center p-6">
            <h1 class="text-lg font-bold text-locatera-blue">Checkout</h1>
        </div>

        <div class="flex items-center justify-center gap-4 mb-12 px-6">
            <div class="text-locatera-orange">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                </svg>
            </div>

            <div class="flex gap-1">
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
            </div>

            <div class="text-locatera-orange">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                    <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                </svg>
            </div>

             <div class="flex gap-1">
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
                <div class="w-1 h-1 rounded-full bg-locatera-orange"></div>
            </div>

            <div class="bg-locatera-orange p-1 rounded-full text-white">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 0 1 1.04-.208Z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <div class="flex-grow flex items-center justify-center px-6 pb-20">
            
            <div class="bg-white w-full rounded-[2rem] shadow-2xl p-8 flex flex-col items-center text-center transform transition-all hover:scale-105 duration-500">
                
                <div class="w-24 h-24 bg-locatera-orange rounded-full flex items-center justify-center mb-6 shadow-lg shadow-orange-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-10 h-10 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>

                <h2 class="text-3xl font-bold text-locatera-orange mb-4">Success !</h2>
                
                <p class="text-gray-400 text-sm leading-relaxed mb-10 px-2">
                    Terima kasih telah membeli. Pesanan Anda akan dikirim dalam 3-5 hari kerja
                </p>

                <a href="index.php" class="block w-full bg-locatera-orange text-white font-bold py-4 rounded-xl shadow-lg hover:bg-orange-600 transition transform active:scale-95">
                    Kembali Belanja
                </a>

            </div>
        </div>

    </div>
</body>

</html>