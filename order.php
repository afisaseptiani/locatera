<?php
session_start();
require_once 'db_connection.php';

// 1. Query Data (Join Orders & Items)
$sql = "SELECT 
            o.id as order_id, 
            o.order_date, 
            o.total, 
            o.status, 
            o.delivery_date,
            oi.product_name_snapshot, 
            oi.variant_name_snapshot, 
            oi.quantity
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        ORDER BY o.order_date DESC, o.id DESC";

$result = $conn->query($sql);
$orderHistory = [];

// 2. Grouping Data (Mengelompokkan item berdasarkan Order ID)
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['order_id'];
        
        if (!isset($orderHistory[$id])) {
            $orderHistory[$id] = [
                'id' => $id,
                'date' => $row['order_date'], 
                'total' => (int)$row['total'],
                'status' => $row['status'],
                'delivery_date' => $row['delivery_date'],
                'items' => [] 
            ];
        }
        
        $orderHistory[$id]['items'][] = [
            'name' => $row['product_name_snapshot'],
            'variant' => $row['variant_name_snapshot'],
            'qty' => (int)$row['quantity']
        ];
    }
}

// Re-index array
$orderHistory = array_values($orderHistory);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesanan Saya - Locatera</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Poppins', 'sans-serif']
          },
          colors: {
            'locatera-orange': '#F9A826',
            'locatera-dark': '#374151'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans text-gray-800">

  <?php include 'navbar.php'; ?>

  <main class="w-full max-w-7xl mx-auto px-4 pb-24 sm:px-6 lg:px-8 lg:pb-10 lg:pt-28 pt-4">

    <header class="flex justify-between items-center mb-4 lg:hidden">
      <a href="index.php" class="p-2 -ml-2 hover:bg-gray-100 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-locatera-dark">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
      </a>
      <h1 class="text-xl font-bold text-locatera-dark flex-grow ml-4">Pesanan Saya</h1>
      <div class="w-6 h-6"></div>
    </header>

    <h1 class="hidden lg:block text-3xl font-bold text-locatera-dark mb-8 mt-4">Daftar Pesanan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <?php if (!empty($orderHistory)): ?>
        <?php foreach ($orderHistory as $order): ?>

          <div class="bg-white p-5 rounded-2xl shadow-md border-t-4 
                    <?php
                    if ($order['status'] == 'Dikirim') echo 'border-blue-500';
                    elseif ($order['status'] == 'Selesai') echo 'border-green-500';
                    else echo 'border-gray-400';
                    ?>
                ">
            <div class="flex justify-between items-center border-b pb-3 mb-3 border-gray-100">
              <span class="text-sm font-semibold text-locatera-dark"><?php echo htmlspecialchars($order['id']); ?></span>
              <span class="text-xs font-medium px-2 py-1 rounded-full 
                            <?php
                            if ($order['status'] == 'Dikirim') echo 'text-blue-500 bg-blue-50';
                            elseif ($order['status'] == 'Selesai') echo 'text-green-500 bg-green-50';
                            else echo 'text-gray-600 bg-gray-200';
                            ?>
                        ">
                <?php echo htmlspecialchars($order['status']); ?>
              </span>
            </div>

            <div class="space-y-2">
              <?php foreach (array_slice($order['items'], 0, 2) as $item): ?>
                <p class="text-sm text-gray-700">
                  <?php echo htmlspecialchars($item['name']); ?> 
                  <span class="text-gray-500 text-xs"><?php echo $item['variant'] ? '('.htmlspecialchars($item['variant']).')' : ''; ?></span> 
                  <span class="font-bold">x<?php echo $item['qty']; ?></span>
                </p>
              <?php endforeach; ?>

              <?php if (count($order['items']) > 2): ?>
                <p class="text-xs text-gray-500 italic">+ <?php echo count($order['items']) - 2; ?> produk lainnya</p>
              <?php endif; ?>
            </div>

            <hr class="my-3 border-gray-100">

            <div class="flex justify-between items-end">
              <div class="text-gray-500 text-xs">
                Total Bayar: <br>
                <span class="font-bold text-base text-locatera-dark">
                  Rp <?php echo number_format($order['total'], 0, ',', '.'); ?>
                </span>
              </div>
              
              <div class="text-right">
                <?php if ($order['status'] == 'Dikirim'): ?>
                    <form action="update_status.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <input type="hidden" name="action" value="complete_order">
                        <button type="submit" class="bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full hover:bg-green-600 transition shadow">
                            Pesanan Diterima
                        </button>
                    </form>
                <?php elseif ($order['status'] == 'Dibuat'): ?>
                    <span class="text-xs text-gray-400 italic">Menunggu konfirmasi admin</span>
                <?php else: ?>
                    <span class="text-xs text-green-600 font-bold flex items-center gap-1">
                        Selesai
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" /></svg>
                    </span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-gray-500 lg:col-span-3 text-center py-10">
            Anda belum memiliki riwayat pesanan.
        </p>
      <?php endif; ?>
    </div>

  </main>
</body>
</html>