<?php
// Mendapatkan nama file halaman saat ini (misal: 'index.php', 'cart.php')
// Ini digunakan untuk menentukan menu mana yang harus diberi warna 'Active'
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>

<nav class="hidden lg:flex fixed top-0 left-0 right-0 h-20 bg-white shadow-sm z-50 items-center justify-between px-8 max-w-7xl mx-auto w-full transition-all">

  <div class="flex items-center gap-2">
    <img src="./src/asset/logo-locatera.png" alt="Logo" class="w-10 h-10">
    <div class="flex flex-col">
      <span class="text-2xl font-fontLogo font-extrabold text-locatera-orange tracking-tight">Locatera</span>
      <span class="text-[10px] text-gray-400 mt-1 font-poppins font-medium">Satu Titipan Sejuta Cerita Lokal</span>
    </div>
  </div>

  <div class="flex items-center gap-8 font-medium text-gray-500">

    <a href="index.php" class="transition hover:text-locatera-orange <?php echo ($currentPage == 'index.php') ? 'text-locatera-orange font-bold' : ''; ?>">
      Home
    </a>


    <div class="flex items-center gap-8 font-medium text-gray-500">
      <a href="order.php" class="transition hover:text-locatera-orange <?php echo ($currentPage == 'order.php') ? 'text-locatera-orange font-bold' : ''; ?>">
        Pesanan
      </a>

    </div>
    <a href="favorites.php" class="transition hover:text-locatera-orange <?php echo ($currentPage == 'favorites.php') ? 'text-locatera-orange font-bold' : ''; ?>">
      Favorit
    </a>

    <a href="cart.php" class="transition hover:text-locatera-orange <?php echo ($currentPage == 'cart.php') ? 'text-locatera-orange font-bold' : ''; ?>">
      Keranjang
    </a>
    <a href="customer_support.php" class="transition hover:text-locatera-orange <?php echo ($currentPage == 'customer_support.php') ? 'text-locatera-orange font-bold' : ''; ?>">
      Customer Support
    </a>


  </div>

  <div class="flex items-center gap-4">
    <a href="profile.php" class="relative">
      <img src="./src/asset/profil.jpg" alt="Profile" class="w-10 h-10 rounded-full border border-gray-200">
    </a>
  </div>
</nav>


<nav class="fixed bottom-0 left-0 right-0 h-16 bg-locatera-orange shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-40 lg:hidden rounded-t-2xl transition-all">
  <div class="flex justify-around items-center h-full text-white/80">

    <a href="index.php" class="text-center w-12 <?php echo ($currentPage == 'index.php') ? 'text-white' : 'hover:text-white'; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?php echo ($currentPage == 'index.php') ? 'currentColor' : 'none'; ?>" stroke-width="2" stroke="currentColor" class="w-7 h-7 mx-auto">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.06l-8.69-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.06 1.06l8.69-8.69Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5.432 4.687 12.745v6.528a2.25 2.25 0 0 0 2.25 2.25h3v-6.375a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 .75.75v6.375h3a2.25 2.25 0 0 0 2.25-2.25v-6.528L12 5.432Z" />
      </svg>
    </a>

    <a href="order.php" class="text-center w-12 <?php echo ($currentPage == 'order.php') ? 'text-white' : 'hover:text-white'; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" fill="<?php echo ($currentPage == 'order.php') ? 'currentColor' : 'none'; ?>" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 mx-auto">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0A4.5 4.5 0 0 1 12 7.5a4.5 4.5 0 0 1 2.573 7.682ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM15.91 15.91a.75.75 0 0 0-1.06-1.06c-.529.529-1.22.8-1.94.8s-1.411-.271-1.94-.8a.75.75 0 0 0-1.06 1.06c.699.699 1.62.98 2.59.98s1.891-.281 2.59-.98Z" />
      </svg>
    </a>

    <div class="w-16"></div>

    <a href="favorites.php" class="text-center w-12 <?php echo ($currentPage == 'favorites.php') ? 'text-white' : 'hover:text-white'; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" fill="<?php echo ($currentPage == 'favorites.php') ? 'currentColor' : 'none'; ?>" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 mx-auto">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
      </svg>
    </a>

    <a href="customer_support.php" class="text-center w-12 <?php echo ($currentPage == 'customer_support.php') ? 'text-white' : 'hover:text-white'; ?>">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
      </svg>
    </a>
  </div>
</nav>

<a href="cart.php" class="lg:hidden fixed bottom-8 left-1/2 -translate-x-1/2 w-16 h-16 bg-locatera-orange border-4 border-white rounded-full flex items-center justify-center shadow-xl z-50 hover:scale-105 transition-transform">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
  </svg>
</a>