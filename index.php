<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// 1. MULAI SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db_connection.php'; 
if (!isset($conn)) { die("Koneksi DB gagal/tidak ditemukan."); }


$activeFilter = $_GET['filter'] ?? 'All';
$products = []; // Ini variabel pengganti $products dari data.php

// A. SIAPKAN QUERY PRODUK
$sql = "SELECT * FROM products";
if ($activeFilter !== 'All') {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $activeFilter);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

// B. AMBIL PRODUK DAN SIAPKAN SLOT VARIAN
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['id'] = (int)$row['id'];
        $row['price'] = (int)$row['price'];
        $row['rating'] = (float)$row['rating'];
        
        $row['variants'] = []; 
        
        $products[$row['id']] = $row;
    }
}

$sqlVariants = "SELECT product_id, variant_name FROM product_variants";
$resVariants = $conn->query($sqlVariants);

if ($resVariants->num_rows > 0) {
    while($var = $resVariants->fetch_assoc()) {
        $p_id = $var['product_id'];
        if (isset($products[$p_id])) {
            $products[$p_id]['variants'][] = $var['variant_name'];
        }
    }
}

$products = array_values($products);

$favoriteIds = $_SESSION['favorites'] ?? [];
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Locatera</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Cantarell', 'sans-serif'],
            'fontLogo': ['Lobster', 'cursive'],
            'roboto': ['Roboto', 'sans-serif'],
            'poppins': ['Poppins', 'sans-serif'],
          },
          colors: {
            'locatera-orange': '#FF9D3D',
            'locatera-gray': '#F3F4F6',
            'locatera-dark': '#374151',
            'locatera-light-gray': '#9CA3AF',
          }
        }
      }
    }
  </script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Lilita+One&family=Lobster&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <script type_module="text/javascript" src="https://unpkg.com/heroicons@2.1.1/24/outline/index.js"></script>
  <script type_module="text/javascript" src="https://unpkg.com/heroicons@2.1.1/24/solid/index.js"></script>

</head>

<body class="bg-white font-roboto min-h-screen">

  <?php include 'navbar.php'; ?>
  <main class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 pb-24 lg:pb-8">

    <header class="flex justify-between items-center mb-4">
      <div class="lg:hidden">
        <h1 class="text-3xl font-extrabold text-locatera-dark font-fontLogo">Locatera</h1>
        <p class="text-xs text-locatera-light-gray mt-1 font-poppins">"Satu Titipan Sejuta Cerita Lokal"</p>
      </div>
      <a href="profile.php">
        <img src="./src/asset/profil.jpg" alt="Profil" class="w-12 h-12 rounded-full">
      </a>
    </header>

    <div class="flex gap-2 mb-4">
      <input type="text" placeholder="Search" class="flex-grow px-4 py-3 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-locatera-orange">
      <button class="flex-shrink-0 w-12 h-12 bg-locatera-orange text-white rounded-lg shadow-sm flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
      </button>
    </div>

    <div class="w-full overflow-x-auto whitespace-nowrap py-2 mb-4">
      <a href="index.php?filter=All"
        class="inline-block text-sm font-medium py-2 px-5 rounded-full mr-2 
                <?php echo ($activeFilter == 'All') ? 'bg-locatera-orange text-white' : 'bg-locatera-gray text-locatera-dark'; ?>">
        All
      </a>
      <a href="index.php?filter=Makanan Basah"
        class="inline-block text-sm font-medium py-2 px-5 rounded-full mr-2
                <?php echo ($activeFilter == 'Makanan Basah') ? 'bg-locatera-orange text-white' : 'bg-locatera-gray text-locatera-dark'; ?>">
        Makanan Basah
      </a>
      <a href="index.php?filter=Makanan Kering"
        class="inline-block text-sm font-medium py-2 px-5 rounded-full mr-2
                <?php echo ($activeFilter == 'Makanan Kering') ? 'bg-locatera-orange text-white' : 'bg-locatera-gray text-locatera-dark'; ?>">
        Makanan Kering
      </a>
      <a href="index.php?filter=Minuman"
        class="inline-block text-sm font-medium py-2 px-5 rounded-full mr-2
                <?php echo ($activeFilter == 'Minuman') ? 'bg-locatera-orange text-white' : 'bg-locatera-gray text-locatera-dark'; ?>">
        Minuman
      </a>
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
      <?php foreach ($products as $product):
        $productId = $product['id'];
        // Cek apakah produk ini ada di daftar favorit
        $isFavorite = in_array($productId, $favoriteIds);
      ?>

        <?php if ($activeFilter == 'All' || $product['category'] == $activeFilter): ?>

          <a href="product_detail.php?id=<?php echo $productId; ?>"
            class="block bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-105 relative group">

            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"
              class="w-full h-32 sm:h-40 md:h-48 object-cover">

            <button
              onclick="event.preventDefault(); toggleFavorite(<?php echo $productId; ?>);"
              id="favorite-btn-<?php echo $productId; ?>"
              class="absolute top-2 right-2 p-1.5 rounded-full shadow-md transition duration-300 z-10 
                                   <?php echo $isFavorite ? 'bg-red-500 text-white' : 'bg-white text-gray-400 hover:text-red-500'; ?>">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path d="m11.645 20.91-.007-.003-.024-.01a11.02 11.02 0 0 1-.365-.136 7.056 7.056 0 0 1-.375-.119 1.82 1.82 0 0 1-.351-.137l-.023-.01-.008-.003.003-.004c-.381-.295-.838-.59-1.38-.934-1.579-1.003-3.213-2.338-4.79-4.265C3.69 13.12 3 11.55 3 10c0-3 2.4-5.5 5.4-5.5 1.4 0 2.8.5 4.1 1.6 1.3-1.1 2.7-1.6 4.1-1.6 3 0 5.4 2.5 5.4 5.5 0 1.55-.69 3.12-1.855 4.516-1.577 1.927-3.211 3.262-4.79 4.265-.542.344-.999.639-1.38.934l-.003.004-.008.003-.023.01a1.82 1.82 0 0 1-.351.137 7.056 7.056 0 0 1-.375.119 11.02 11.02 0 0 1-.365.136l-.024.01-.007.003-.002.001c-.161.077-.323.153-.485.228-.004.002-.007.003-.01.006l-.002.001a1.8 1.8 0 0 1-.502.164.8.8 0 0 1-.161.024h-.001a1.8 1.8 0 0 1-.502-.164l-.01-.006a10.957 10.957 0 0 1-.485-.228Z" />
              </svg>
            </button>

            <div class="p-3">
              <h3 class="font-bold text-sm text-locatera-dark truncate"><?php echo $product['name']; ?></h3>
              <div class="flex justify-between items-center mt-2">
                <span class="flex items-center text-sm text-locatera-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-500 mr-1">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.27 1.134-.959 2.036-1.99 1.409L12 18.049l-4.555 2.666c-1.03.628-2.26-.275-1.99-1.409l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.006Z" clip-rule="evenodd" />
                  </svg>
                  <?php echo $product['rating']; ?>
                </span>
                <span class="font-bold text-locatera-orange text-sm">Rp <?php echo number_format($product['price'] ?? 0, 0, ',', '.'); ?></span>
              </div>
            </div>
          </a>

        <?php endif; ?>

      <?php endforeach; ?>
    </div>
  </main>

  <script>
    // Fungsi untuk mengirim permintaan favorit ke server
    function toggleFavorite(productId) {
      // Hentikan default behavior (mencegah klik tombol membuka link kartu)
      event.preventDefault();
      event.stopPropagation();

      const btn = document.getElementById('favorite-btn-' + productId);

      // Menggunakan path relatif 'handle_favorite.php' karena file ada di root folder
      fetch('handle_favorite.php?id=' + productId, {
          method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'added') {
            // Berhasil ditambahkan
            btn.classList.remove('bg-white', 'text-gray-400', 'hover:text-red-500');
            btn.classList.add('bg-red-500', 'text-white');
          } else if (data.status === 'removed') {
            // Berhasil dihapus
            btn.classList.remove('bg-red-500', 'text-white');
            btn.classList.add('bg-white', 'text-gray-400', 'hover:text-red-500');
          }
        })
        .catch(error => console.error('Error toggling favorite:', error));
    }
  </script>
</body>

</html>