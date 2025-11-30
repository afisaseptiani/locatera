<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'] ?? null;
    $action = $_POST['action'] ?? '';

    if ($orderId && $action === 'complete_order') {
        // Logika: Hanya bisa ubah ke 'Selesai' jika status sebelumnya 'Dikirim'
        // Ini mencegah user menyelesaikan pesanan yang masih 'Dibuat'
        $stmt = $conn->prepare("UPDATE orders SET status = 'Selesai' WHERE id = ? AND status = 'Dikirim'");
        $stmt->bind_param("s", $orderId);
        
        if ($stmt->execute()) {
            // Berhasil
            header("Location: order.php");
            exit;
        } else {
            echo "Gagal mengupdate status.";
        }
        $stmt->close();
    }
}

// Redirect balik jika akses ilegal
header("Location: order.php");
exit;
?>