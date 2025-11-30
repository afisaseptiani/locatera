<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // 1. Generate Order ID Unik
    $orderId = '#LOC' . date('ymdHis');
    
    // 2. Persiapan Data Order
    $total = (int)$_POST['total_price'];
    $shippingFee = (int)$_POST['shipping_cost'];
    $orderDate = date('Y-m-d');
    $deliveryDate = date('Y-m-d', strtotime('+3 days')); // Estimasi dummy
    $status = 'Dibuat'; // Status awal

    // 3. Insert ke Tabel Orders
    $stmtOrder = $conn->prepare("INSERT INTO orders (id, order_date, total, status, delivery_date, shipping_fee) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtOrder->bind_param("ssdssd", $orderId, $orderDate, $total, $status, $deliveryDate, $shippingFee);
    
    if ($stmtOrder->execute()) {
        
        // 4. Insert ke Tabel Order Items
        $prodName = $_POST['product_name'];
        $variant  = $_POST['variant'];
        $qty      = (int)$_POST['qty'];
        $price    = (int)$_POST['price_per_unit'];

        $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_name_snapshot, variant_name_snapshot, quantity, price_per_unit) VALUES (?, ?, ?, ?, ?)");
        $stmtItem->bind_param("sssid", $orderId, $prodName, $variant, $qty, $price);
        $stmtItem->execute();
        
        // 5. Redirect ke Halaman Pesanan
        header("Location: order.php"); 
        exit();
        
    } else {
        echo "Error: " . $stmtOrder->error;
    }

    $stmtOrder->close();
    $conn->close();

} else {
    header("Location: index.php");
    exit();
}
?>