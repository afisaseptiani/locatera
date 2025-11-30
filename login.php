<?php
session_start();
require_once 'db_connection.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = trim($_POST['username']); // Bisa Email atau No HP
    $password = $_POST['password'];

    // Cari user berdasarkan Email ATAU No HP
    $stmt = $conn->prepare("SELECT id, name, email, password, avatar FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi Password Hash
        if (password_verify($password, $user['password'])) {
            // Login Sukses: Simpan data penting ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // Redirect ke halaman utama
            header("Location: index.php");
            exit;
        } else {
            $message = "Password salah.";
        }
    } else {
        $message = "Akun tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In - Locatera</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { 'sans': ['Cantarell', 'sans-serif'], 'header': ['Lilita One', 'cursive'] },
          backgroundImage: { 'locatera-gradient': 'linear-gradient(to bottom, #FF9D3D, #FEEE91)' },
          colors: { 'locatera-orange': '#FF9D3D' }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Cantarell:wght@400;700&family=Lilita+One&display=swap" rel="stylesheet">
</head>

<body class="bg-locatera-gradient min-h-screen flex items-center justify-center p-6 font-sans">
  <div class="w-full max-w-sm">
    <h1 class="text-5xl font-bold text-white text-center mb-[94px] font-header">Log in</h1>

    <?php if($message): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $message; ?></span>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-4">
        <input type="text" name="username" placeholder="Number / Email" class="w-full px-5 py-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      </div>

      <div class="mb-[81px]">
        <input type="password" name="password" placeholder="Password" class="w-full px-5 py-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      </div>

      <button type="submit" class="w-full bg-orange-500 text-white font-bold text-lg py-3 px-6 rounded-lg shadow-lg hover:bg-orange-600 transition">
        Log In
      </button>
    </form>

    <p class="text-center text-sm text-gray-700 mt-6">
      Belum punya akun? <a href="register.php" class="font-bold text-green-600 hover:text-green-700">Sign Up</a>
    </p>
  </div>
</body>
</html>