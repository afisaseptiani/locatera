<?php
session_start();
require_once 'db_connection.php';

// --- LOGIKA UTAMA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. JIKA TOMBOL "HAPUS SEMUA DATA" DITEKAN
    if (isset($_POST['action']) && $_POST['action'] === 'reset_database') {
        // Hapus detail barang dulu (Anak)
        $conn->query("DELETE FROM order_items");
        // Baru hapus pesanan utama (Induk)
        $conn->query("DELETE FROM orders");
        
        header("Location: admin_simulation.php");
        exit;
    }

    // 2. JIKA TOMBOL "UBAH STATUS" DITEKAN
    if (isset($_POST['new_status']) && isset($_POST['order_id'])) {
        $orderId = $_POST['order_id'];
        $newStatus = $_POST['new_status'];
        
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("ss", $newStatus, $orderId);
        $stmt->execute();
        $stmt->close();
        
        header("Location: admin_simulation.php");
        exit;
    }
}

// AMBIL DATA PESANAN
$sql = "SELECT * FROM orders ORDER BY order_date DESC, id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Simulasi - Locatera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100 p-6 min-h-screen">

    <div class="max-w-6xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
                <p class="text-sm text-gray-500">Pantau dan update status pesanan secara real-time.</p>
            </div>
            
            <div class="flex gap-3">
                <form method="POST" onsubmit="return confirm('PERINGATAN KERAS:\n\nSemua riwayat pesanan akan dihapus permanen dari database.\nHalaman pesanan user akan menjadi kosong.\n\nApakah Anda yakin ingin mereset ulang sistem?');">
                    <input type="hidden" name="action" value="reset_database">
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 shadow-md flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" /></svg>
                        Hapus Semua Pesanan
                    </button>
                </form>

                <a href="index.php" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 shadow-sm">
                    Kembali ke Toko
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4 text-sm font-semibold">Order ID</th>
                        <th class="p-4 text-sm font-semibold">Tanggal</th>
                        <th class="p-4 text-sm font-semibold">Total</th>
                        <th class="p-4 text-sm font-semibold">Status Saat Ini</th>
                        <th class="p-4 text-sm font-semibold text-center">Aksi (Ubah Status)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="p-4 font-mono text-sm text-blue-600 font-bold group-hover:underline cursor-pointer">
                                    <?php echo htmlspecialchars($row['id']); ?>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    <?php echo htmlspecialchars($row['order_date']); ?>
                                </td>
                                <td class="p-4 text-sm font-bold text-gray-800">
                                    Rp <?php echo number_format($row['total'], 0, ',', '.'); ?>
                                </td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border
                                        <?php 
                                            if($row['status'] == 'Dibuat') echo 'bg-gray-100 text-gray-600 border-gray-200';
                                            elseif($row['status'] == 'Dikirim') echo 'bg-blue-50 text-blue-600 border-blue-200';
                                            elseif($row['status'] == 'Selesai') echo 'bg-green-50 text-green-600 border-green-200';
                                        ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <?php if ($row['status'] == 'Dibuat'): ?>
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="new_status" value="Dikirim">
                                            <button type="submit" class="bg-blue-600 text-white text-xs px-4 py-2 rounded shadow hover:bg-blue-700 transition transform active:scale-95">
                                                Proses Kirim
                                            </button>
                                        </form>

                                    <?php elseif ($row['status'] == 'Dikirim'): ?>
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-[10px] text-gray-400 italic">Menunggu User Klik Terima</span>
                                            <form method="POST">
                                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                                <input type="hidden" name="new_status" value="Selesai">
                                                <button type="submit" class="text-[10px] text-gray-400 hover:text-red-500 underline">
                                                    Paksa Selesai
                                                </button>
                                            </form>
                                        </div>

                                    <?php else: ?>
                                        <div class="flex items-center justify-center text-green-600 gap-1 text-xs font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" /></svg>
                                            Tuntas
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-16 text-center">
                                <div class="flex flex-col items-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                                    <p>Database pesanan bersih.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>