<?php
session_start();
require_once 'db_connection.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$message = '';
$msgType = '';

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_profile'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    
    // 1. Handle Upload Foto (Jika ada)
    $avatarSql = ""; 
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $targetDir = "uploads/";
        // Buat nama file unik: time_namafile.jpg
        $fileName = time() . "_" . basename($_FILES["avatar"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        
        // Cek ekstensi (Security Basic)
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($fileType, $allowedTypes)) {
            // Upload file
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
                $avatarSql = ", avatar = '$targetFilePath'";
                // Update session agar navbar langsung berubah jika ada foto di navbar
            } else {
                $message = "Gagal mengupload gambar.";
                $msgType = "error";
            }
        } else {
            $message = "Hanya file JPG, JPEG, PNG, & GIF yang diperbolehkan.";
            $msgType = "error";
        }
    }

    // 2. Update Database
    // Note: Email biasanya tidak boleh diubah sembarangan tanpa verifikasi ulang
    if (empty($message)) { // Hanya update jika tidak ada error upload
        $sql = "UPDATE users SET name = ?, phone = ? $avatarSql WHERE id = ?";
        // Karena avatarSql dinamis (bisa ada bisa tidak), kita pakai query biasa atau bind param dinamis. 
        // Untuk simpel dan aman di sini:
        
        if ($avatarSql) {
             $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, avatar = ? WHERE id = ?");
             $stmt->bind_param("sssi", $name, $phone, $targetFilePath, $userId);
        } else {
             $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
             $stmt->bind_param("ssi", $name, $phone, $userId);
        }

        if ($stmt->execute()) {
            $message = "Profil berhasil diperbarui!";
            $msgType = "success";
            // Update Session Name
            $_SESSION['user_name'] = $name;
        } else {
            $message = "Gagal mengupdate database.";
            $msgType = "error";
        }
    }
}

// Ambil Data Terbaru untuk Ditampilkan di Form
$stmt = $conn->prepare("SELECT name, email, phone, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (empty($user['avatar'])) $user['avatar'] = './src/asset/profil.jpg';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - Locatera</title>
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
  <div class="max-w-md lg:max-w-2xl mx-auto min-h-screen shadow-xl bg-white lg:rounded-2xl">
    
    <header class="flex items-center justify-between p-4 border-b">
      <a href="profile.php" class="p-2 -ml-2 hover:bg-gray-100 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-locatera-dark"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
      </a>
      <h1 class="text-xl font-bold flex-grow text-center mr-6">Edit Profil</h1>
      <div class="w-6"></div>
    </header>

    <?php if ($message): ?>
      <div class="mx-4 mt-4 p-4 rounded <?php echo $msgType == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="p-6 lg:p-10 space-y-6">
      
      <div class="flex flex-col items-center mb-8">
        <img src="<?php echo htmlspecialchars($user['avatar']); ?>" class="w-28 h-28 rounded-full object-cover border-4 border-orange-100 shadow-md mb-3">
        <label for="avatar_upload" class="cursor-pointer text-sm font-semibold text-locatera-orange hover:text-orange-600 transition">
          Ubah Foto Profil
        </label>
        <input type="file" id="avatar_upload" name="avatar" class="hidden" accept="image/*">
      </div>

      <div>
        <label class="block text-xs text-gray-400 mb-1">Nama Lengkap</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="w-full border-b border-gray-200 py-2 font-medium focus:outline-none focus:border-locatera-orange" required>
      </div>

      <div>
        <label class="block text-xs text-gray-400 mb-1">Nomor Telepon</label>
        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" class="w-full border-b border-gray-200 py-2 font-medium focus:outline-none focus:border-locatera-orange">
      </div>

      <div>
        <label class="block text-xs text-gray-400 mb-1">Email (Tidak dapat diubah)</label>
        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full border-b border-gray-200 py-2 text-gray-500 bg-gray-50/50" readonly disabled>
      </div>

      <div class="pt-8">
        <button type="submit" name="save_profile" class="w-full bg-locatera-orange text-white font-bold text-lg py-3 rounded-full shadow-lg hover:bg-orange-600 transition active:scale-95">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</body>
</html>