<?php
session_start();
require_once 'db_connection.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['number']); // Di form name-nya 'number'
    $password = $_POST['password'];

    // 1. Cek apakah email sudah terdaftar
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Email sudah terdaftar!";
    } else {
        // 2. Enkripsi Password (HASHING) - WAJIB!
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 3. Insert ke Database
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

        if ($stmt->execute()) {
            // Sukses, redirect ke login
            echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location='login.php';</script>";
            exit;
        } else {
            $message = "Terjadi kesalahan sistem.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Locatera</title>
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
    <h1 class="text-5xl font-bold text-white text-center mb-[50px] font-header">Sign Up</h1>

    <?php if($message): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $message; ?></span>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-4">
        <input type="text" name="name" placeholder="Full Name" class="w-full px-5 py-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      </div>

      <div class="mb-4">
        <input type="text" name="number" placeholder="Phone Number" class="w-full px-5 py-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      </div>

      <div class="mb-4">
        <input type="email" name="email" placeholder="Email" class="w-full px-5 py-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      </div>

      <div class="mb-[40px]">
        <input type="password" name="password" placeholder="Password" class="w-full px-5 py-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      </div>

      <button type="submit" class="w-full bg-orange-500 text-white font-bold text-lg py-3 px-6 rounded-lg shadow-lg hover:bg-orange-600 transition">
        Sign Up
      </button>
    </form>

    <p class="text-center text-sm text-gray-700 mt-6">
      Sudah punya akun? <a href="login.php" class="font-bold text-green-600 hover:text-green-700">Log In</a>
    </p>
  </div>
</body>
</html>