<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    $variant = $_POST['selected_variant'] ?? 'Default';
    $qty = (int)$_POST['quantity'];

    $cartKey = $productId . '_' . $variant;

    if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$cartKey] = [
            'product_id' => $productId,
            'variant' => $variant,
            'qty' => $qty
        ];
    }
}

$displayItems = [];
$grandTotal = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartKey => $item) {
        $pId = $item['product_id'];
        $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE id = ?");
        $stmt->bind_param("i", $pId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($product = $result->fetch_assoc()) {
            $subtotal = $product['price'] * $item['qty'];
            $grandTotal += $subtotal;

            $displayItems[] = [
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => (int)$product['price'],
                'variant' => $item['variant'],
                'qty' => $item['qty'],
                'subtotal' => $subtotal
            ];
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Locatera</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Cantarell', 'sans-serif'],
                        'header': ['Lilita One', 'cursive'],
                        'fontLogo': ['Lobster', 'cursive'],
                        'roboto': ['Roboto', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'], 
                    },
                    colors: {
                        'locatera-orange': '#FF9D3D',
                        'locatera-gray': '#F3F4F6',
                        'locatera-dark': '#202020',
                        'locatera-blue': '#001833',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/heroicons@2.1.1/24/outline/index.js"></script>
    <script type="module" src="https://unpkg.com/heroicons@2.1.1/24/solid/index.js"></script>
</head>
<body class="bg-gray-50 font-poppins text-gray-800">

    <?php include 'navbar.php'; ?>

    <div class="w-full max-w-7xl mx-auto min-h-screen relative bg-gray-50 pb-32 lg:pt-28 lg:px-8">

        <div class="flex justify-between items-center p-6 bg-gray-50 sticky top-0 z-10 lg:hidden">
            <a href="index.php" class="p-2 -ml-2 text-locatera-dark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            </a>
            <h1 class="text-lg font-bold text-locatera-dark flex-grow ml-4">Keranjang Saya</h1>
        </div>

        <h1 class="hidden lg:block text-3xl font-bold text-locatera-dark mb-8 mt-4">Keranjang Belanja</h1>

        <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-8 items-start">
            
            <div class="w-full lg:col-span-8 px-6 lg:px-0 space-y-4">
                
                <?php foreach($displayItems as $item): ?>
                <div class="bg-white p-4 rounded-2xl shadow-sm flex items-center gap-4 transition hover:shadow-md border border-transparent hover:border-orange-100">
                    <div class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="font-bold text-locatera-dark text-sm lg:text-base"><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="text-xs text-gray-400 mb-1 lg:text-sm"><?php echo htmlspecialchars($item['variant']); ?></p>
                        <p class="text-sm font-medium text-gray-600 lg:text-base lg:font-bold lg:text-locatera-orange">
                            Rp <?php echo number_format($item['price'], 0, ',', '.'); ?>
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-locatera-dark w-8 text-center lg:text-base">x<?php echo $item['qty']; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if(empty($displayItems)): ?>
                    <div class="text-center py-10 text-gray-400">Keranjang masih kosong.</div>
                <?php endif; ?>

            </div>

            <div class="w-full lg:col-span-4 px-6 lg:px-0 mt-8 lg:mt-0">
                <div class="lg:bg-white lg:p-6 lg:rounded-2xl lg:shadow-md lg:sticky lg:top-32">
                    <h2 class="hidden lg:block text-lg font-bold text-locatera-dark mb-4">Ringkasan Belanja</h2>

                    <div class="flex items-center justify-between lg:mb-6">
                        <div class="flex items-center gap-2 lg:flex-col lg:items-start lg:gap-0">
                            <span class="text-sm font-bold text-locatera-dark lg:text-gray-500 lg:font-normal">Total:</span>
                            <span class="text-lg lg:text-2xl font-bold text-locatera-dark">
                                Rp <?php echo number_format($grandTotal, 0, ',', '.'); ?>
                            </span>
                        </div>
                        
                        <?php if(!empty($displayItems)): ?>
                        <form action="checkout.php" method="POST" class="lg:hidden">
                            <input type="hidden" name="product_name" value="Mix Order (<?php echo count($displayItems); ?> Items)">
                            <input type="hidden" name="product_price" value="<?php echo $grandTotal; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="subtotal" value="<?php echo $grandTotal; ?>">
                            
                            <button type="submit" class="bg-locatera-orange text-white font-medium px-8 py-2.5 rounded-xl shadow-lg hover:bg-orange-500 transition active:scale-95">
                                CheckOut
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>

                    <?php if(!empty($displayItems)): ?>
                    <form action="checkout.php" method="POST" class="hidden lg:block w-full">
                        <input type="hidden" name="product_name" value="Mix Order (<?php echo count($displayItems); ?> Items)">
                        <input type="hidden" name="product_price" value="<?php echo $grandTotal; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="subtotal" value="<?php echo $grandTotal; ?>">
                        
                        <div class="space-y-2 mb-6 text-sm text-gray-500 border-t border-gray-100 pt-4">
                            <div class="flex justify-between"><span>Total Harga</span><span>Rp <?php echo number_format($grandTotal, 0, ',', '.'); ?></span></div>
                        </div>

                        <button type="submit" class="w-full bg-locatera-orange text-white font-bold text-lg py-3 rounded-xl shadow-lg hover:bg-orange-500 transition transform active:scale-95">
                            CheckOut
                        </button>
                    </form>
                    <?php endif; ?>

                </div>
            </div>
        </div> 
    </div>
</body>
</html>