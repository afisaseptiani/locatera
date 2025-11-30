<?php
session_start();
header('Content-Type: application/json');

// Inisialisasi array jika belum ada
if (!isset($_SESSION['favorites'])) {
  $_SESSION['favorites'] = [];
}

// Pastikan ID yang diterima adalah Integer
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$response = ['status' => 'error'];

if ($productId > 0) {
  // Cek apakah ID sudah ada di array session
  $key = array_search($productId, $_SESSION['favorites']);

  if ($key !== false) {
    // JIKA ADA: Hapus (Remove)
    unset($_SESSION['favorites'][$key]);
    // Re-index array supaya tidak bolong (misal indeks 0, 2, 3)
    $_SESSION['favorites'] = array_values($_SESSION['favorites']); 
    $response['status'] = 'removed';
  } else {
    // JIKA BELUM ADA: Tambahkan (Add)
    $_SESSION['favorites'][] = $productId;
    $response['status'] = 'added';
  }
  
  // Kirim jumlah favorit terbaru (opsional, berguna update badge navbar)
  $response['count'] = count($_SESSION['favorites']);
}

echo json_encode($response);
exit;
?>