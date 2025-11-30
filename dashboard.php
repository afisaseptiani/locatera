<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selamat Datang di Locatera</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Cantarell', 'sans-serif'],
            'header': ['Lilita One', 'cursive'],
          },
          backgroundImage: {
            // Tambahkan gradasi yang mirip gambar splash screen awal
            'splash-gradient': 'linear-gradient(to bottom, #FF9D3D, #FFF7D9)' // Contoh gradasi kuning-oranye yang lembut
          },
          colors: {
            'locatera-orange': '#FF9D3D', // Warna tombol
            'locatera-green': '#10B981', // Warna link Log In
            'locatera-dark-gray': '#374151' // Warna teks tagline
          }
        }
      }
    }
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Lilita+One&display=swap" rel="stylesheet">

</head>

<body class="bg-splash-gradient min-h-screen flex flex-col font-sans">

  <main class="flex-grow flex flex-col items-center justify-center text-center p-8">
    <img src="./src/asset/logo-locatera.png" alt="Locatera Logo" class="w-3/4 max-w-xs">
    <p class="text-base sm:text-lg md:text-xl text-locatera-dark-gray font-normal">"Satu Titipan Sejuta Cerita Lokal"</p>
  </main>

  <footer class="w-full p-8">
    <a href="register.php"
      class="block w-full max-w-md mx-auto bg-locatera-orange text-white font-bold text-lg py-3 px-6 text-center rounded-full shadow-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-opacity-75 transition duration-300 ease-in-out">
      Sign Up
    </a>

    <p class="text-center text-sm text-locatera-dark-gray mt-4">
      Sudah punya akun?
      <a href="login.php" class="font-bold text-locatera-green hover:text-green-700">
        Log In
      </a>
    </p>
  </footer>

</body>

</html>