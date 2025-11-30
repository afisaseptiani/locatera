<?php
// 1. MULAI SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. KONEKSI KE DATABASE
require_once 'db_connection.php';

// 3. AMBIL ID DARI SESSION
$favoriteIds = $_SESSION['favorites'] ?? [];
$favoriteProducts = [];

// 4. QUERY DATABASE (Hanya jika ada ID di favorit)
if (!empty($favoriteIds)) {
    // A. Sanitasi ID: Pastikan semua ID adalah angka (Integer) untuk mencegah SQL Injection
    //    karena kita akan memasukkannya langsung ke string query "IN (...)"
    $safeIds = array_map('intval', $favoriteIds);
    
    // B. Buat string comma-separated (contoh: "1,3,5")
    $idList = implode(',', $safeIds);
    
    // C. Ambil data produk yang ID-nya ada di daftar tersebut
    $sql = "SELECT * FROM products WHERE id IN ($idList)";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $favoriteProducts[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tanda Suka - Locatera</title>

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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 font-poppins text-gray-800">

  <?php include 'navbar.php'; ?>

  <main class="w-full max-w-7xl mx-auto px-4 pb-32 sm:px-6 lg:px-8 lg:pt-28 pt-4">

    <header class="flex items-center p-2 mb-6 lg:hidden">
      <a href="index.php" class="p-2 -ml-2 hover:bg-gray-200 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-locatera-dark">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
      </a>
      <h1 class="text-xl font-bold text-locatera-dark ml-4">Locatera</h1>
    </header>

    <h1 class="hidden lg:block text-3xl font-bold text-locatera-dark mb-8 mt-4">Produk Favorit Anda</h1>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
      <?php if (!empty($favoriteProducts)): ?>
        <?php foreach ($favoriteProducts as $product):
          $productId = $product['id'];
        ?>
          <a href="product_detail.php?id=<?php echo $productId; ?>"
            class="block bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:scale-105 relative group">

            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"
              class="w-full h-32 sm:h-40 md:h-48 object-cover">

            <button
              onclick="event.preventDefault(); removeFromFavorites(<?php echo $productId; ?>);"
              class="absolute top-2 right-2 p-1.5 rounded-full shadow-md transition duration-300 z-10 bg-red-500 text-white hover:bg-red-600">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path d="m11.645 20.91-.007-.003-.024-.01a11.02 11.02 0 0 1-.365-.136 7.056 7.056 0 0 1-.375-.119 1.82 1.82 0 0 1-.351-.137l-.023-.01-.008-.003.003-.004c-.381-.295-.838-.59-1.38-.934-1.579-1.003-3.213-2.338-4.79-4.265C3.69 13.12 3 11.55 3 10c0-3 2.4-5.5 5.4-5.5 1.4 0 2.8.5 4.1 1.6 1.3-1.1 2.7-1.6 4.1-1.6 3 0 5.4 2.5 5.4 5.5 0 1.55-.69 3.12-1.855 4.516-1.577 1.927-3.211 3.262-4.79 4.265-.542.344-.999.639-1.38.934l-.003.004-.008.003-.023.01a1.82 1.82 0 0 1-.351.137 7.056 7.056 0 0 1-.375.119 11.02 11.02 0 0 1-.365.136l-.024.01-.007.003-.002.001c-.161.077-.323.153-.485.228-.004.002-.007.003-.01.006l-.002.001a1.8 1.8 0 0 1-.502.164.8.8 0 0 1-.161.024h-.001a1.8 1.8 0 0 1-.502-.164l-.01-.006a10.957 10.957 0 0 1-.485-.228Z" />
              </svg>
            </button>

            <div class="p-3">
              <h3 class="font-bold text-sm text-locatera-dark truncate"><?php echo htmlspecialchars($product['name']); ?></h3>
              <div class="flex justify-between items-center mt-2">
                <span class="flex items-center text-sm text-locatera-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-yellow-500 mr-1">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.27 1.134-.959 2.036-1.99 1.409L12 18.049l-4.555 2.666c-1.03.628-2.26-.275-1.99-1.409l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.006Z" clip-rule="evenodd" />
                  </svg>
                  <?php echo $product['rating']; ?>
                </span>
                <span class="font-bold text-locatera-orange text-sm">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></span>
              </div>
            </div>
          </a>

        <?php endforeach; ?>
      <?php else: ?>
        <div class="lg:col-span-4 text-center py-16 w-full">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
          </svg>
          <p class="text-gray-500 text-lg">Anda belum menambahkan produk ke daftar favorit.</p>
          <a href="index.php" class="text-locatera-orange font-semibold mt-2 inline-block hover:underline">Mulai Berbelanja</a>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script>
    function removeFromFavorites(productId) {
      if (confirm('Yakin ingin menghapus produk ini dari favorit?')) {
        fetch('handle_favorite.php?id=' + productId, {
            method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'removed') {
              window.location.reload();
            } else {
              alert('Gagal menghapus favorit.');
            }
          })
          .catch(error => console.error('Error removing favorite:', error));
      }
    }
  </script>
</body>
</html>