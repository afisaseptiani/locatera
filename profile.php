<?php
session_start();
require_once 'db_connection.php';

// 1. CEK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. AMBIL DATA USER
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header("Location: logout.php");
    exit;
}

// Fallback avatar
if (empty($user['avatar']) || !file_exists($user['avatar'])) {
    $user['avatar'] = './src/asset/profil.jpg'; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - Locatera</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { 'sans': ['Poppins', 'sans-serif'] },
          colors: { 'locatera-orange': '#FF9D3D', 'locatera-dark': '#374151' }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 font-poppins text-gray-800">
  <?php include 'navbar.php'; ?>

  <main class="w-full max-w-7xl mx-auto px-4 pb-24 sm:px-6 lg:px-8 lg:pb-10 lg:pt-28 pt-4">
    <header class="flex items-center justify-between p-2 mb-8 lg:hidden">
      <a href="index.php" class="p-2 -ml-2 hover:bg-gray-200 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-locatera-dark"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
      </a>
      <h1 class="text-xl font-bold text-locatera-dark flex-grow text-center mr-8">Profil Saya</h1>
    </header>

    <div class="max-w-2xl mx-auto bg-white p-6 lg:p-10 rounded-2xl shadow-lg border border-gray-100">
      <div class="flex flex-col items-center border-b pb-6 mb-6">
        <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-orange-100 shadow-md mb-4">
        
        <h2 class="text-2xl font-bold text-locatera-dark">
            <?php echo htmlspecialchars($user['name']); ?>
        </h2>
        
        <p class="text-sm text-gray-500">
            <?php echo htmlspecialchars($user['email']); ?>
        </p>
      </div>

      <div class="space-y-4">
        <?php
        // Konfigurasi Menu dengan Icon SVG yang Benar
        $menuItems = [
          [
            'label' => 'Edit Profil & Akun', 
            'href' => 'edit_profile.php', 
            'color' => 'text-locatera-orange',
            // Icon User
            'path' => 'M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.668-7.812-1.815a.75.75 0 0 1-.437-.695Z'
          ],
          [
            'label' => 'Ubah Kata Sandi', 
            'href' => 'change_password.php', 
            'color' => 'text-locatera-orange',
            // Icon Gembok (Lock)
            'path' => 'M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z'
          ],
          [
            'label' => 'Keluar (Logout)', 
            'href' => 'logout.php', 
            'color' => 'text-red-500',
            // Icon Pintu Keluar
            'path' => 'M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9'
          ],
        ];
        ?>
        
        <?php foreach ($menuItems as $item): ?>
          <a href="<?php echo $item['href']; ?>" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-orange-50 rounded-xl transition duration-200">
            <div class="flex items-center gap-4">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 <?php echo $item['color']; ?>">
                   <?php if(strpos($item['label'], 'Logout') !== false): ?>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" fill="none" d="<?php echo $item['path']; ?>" />
                   <?php else: ?>
                        <path fill-rule="evenodd" d="<?php echo $item['path']; ?>" clip-rule="evenodd" />
                   <?php endif; ?>
               </svg>
               
              <span class="font-medium <?php echo strpos($item['label'], 'Logout') !== false ? 'text-red-500' : 'text-gray-700'; ?>">
                  <?php echo $item['label']; ?>
              </span>
            </div>
            <span class="text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </main>
</body>
</html>