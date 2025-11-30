<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $userId = $_SESSION['user_id'];

    // 1. Ambil password lama dari DB
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($new_pass !== $confirm_pass) {
        $message = ['type' => 'error', 'text' => 'Konfirmasi password tidak cocok.'];
    } elseif (strlen($new_pass) < 6) {
        $message = ['type' => 'error', 'text' => 'Password minimal 6 karakter.'];
    } elseif (!password_verify($old_pass, $user['password'])) {
        $message = ['type' => 'error', 'text' => 'Password lama salah.'];
    } else {
        // 2. Update Password Baru
        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->bind_param("si", $new_hash, $userId);
        
        if ($update->execute()) {
             $message = ['type' => 'success', 'text' => 'Password berhasil diubah.'];
        } else {
             $message = ['type' => 'error', 'text' => 'Gagal mengupdate database.'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Kata Sandi - Locatera</title>
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
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-locatera-dark">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
      </a>
      <h1 class="text-xl font-bold flex-grow text-center mr-6">Ubah Kata Sandi</h1>
      <div class="w-6"></div>
    </header>

    <?php if ($message): ?>
      <div class="p-4 mx-4 mt-4 rounded 
                <?php echo $message['type'] == 'success' ? 'bg-green-100 border-l-4 border-green-500 text-green-700' : 'bg-red-100 border-l-4 border-red-500 text-red-700'; ?>">
        <p class="font-bold"><?php echo $message['type'] == 'success' ? 'Berhasil!' : 'Gagal!'; ?></p>
        <p><?php echo $message['text']; ?></p>
      </div>
    <?php endif; ?>

    <form action="" method="POST" class="p-6 lg:p-10 space-y-6">

      <div>
        <label class="block text-xs text-gray-400 mb-1">Kata Sandi Lama</label>
        <input type="password" name="old_password" placeholder="Masukkan kata sandi lama Anda"
          class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium focus:outline-none focus:border-locatera-orange transition-colors"
          required>
      </div>

      <div>
        <label class="block text-xs text-gray-400 mb-1">Kata Sandi Baru</label>
        <input type="password" name="new_password" placeholder="Minimal 6 karakter"
          class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium focus:outline-none focus:border-locatera-orange transition-colors"
          required>
      </div>

      <div>
        <label class="block text-xs text-gray-400 mb-1">Konfirmasi Kata Sandi Baru</label>
        <input type="password" name="confirm_password" placeholder="Ulangi kata sandi baru"
          class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium focus:outline-none focus:border-locatera-orange transition-colors"
          required>
      </div>

      <div class="pt-8">
        <button type="submit" name="change_password"
          class="w-full bg-locatera-orange text-white font-bold text-lg py-3 rounded-full shadow-lg hover:bg-orange-600 transition transform active:scale-95">
          Simpan Kata Sandi Baru
        </button>
      </div>
    </form>

  </div>
</body>
</html>