<?php
$productName = $_POST['product_name'] ?? 'Produk';
$productPrice = $_POST['product_price'] ?? 0;

$variant = $_POST['selected_variant'] ?? '-'; 
$qty = $_POST['quantity'] ?? 1;
$subtotal = intval($_POST['subtotal'] ?? 0);

$fullname = $_POST['fullname'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';

$shippingCost = intval($_POST['shipping_cost'] ?? 15000);
$shippingOption = $_POST['shipping_option'] ?? 'Reguler';

$total = $subtotal + $shippingCost;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment - Locatera</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Cantarell', 'sans-serif'],
            'poppins': ['Poppins', 'sans-serif'],
          },
          colors: {
            'locatera-orange': '#FF9D3D',
            'locatera-dark': '#202020',
            'locatera-blue': '#001833',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-50 font-poppins min-h-screen flex flex-col items-center py-8 px-4">

  <div class="w-full max-w-md lg:max-w-5xl bg-white lg:rounded-3xl shadow-xl min-h-[80vh] flex flex-col relative overflow-hidden">
      <div class="bg-white pt-6 px-6 lg:px-10">
        <div class="flex items-center justify-between mb-6">
          <a href="javascript:history.back()" class="p-2 -ml-2 hover:bg-gray-100 rounded-full transition"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-locatera-dark"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg></a>
          <h1 class="text-xl font-bold text-locatera-blue">Pembayaran</h1>
          <div class="w-10"></div>
        </div>
      </div>

      <form action="process_payment.php" method="POST" class="flex-grow flex flex-col px-6 lg:px-10 pb-10">
        
        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productName); ?>">
        <input type="hidden" name="variant" value="<?php echo htmlspecialchars($variant); ?>">
        <input type="hidden" name="qty" value="<?php echo $qty; ?>">
        <input type="hidden" name="price_per_unit" value="<?php echo $productPrice; ?>">
        <input type="hidden" name="shipping_cost" value="<?php echo $shippingCost; ?>">
        <input type="hidden" name="total_price" value="<?php echo $total; ?>">
        
        <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
        <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">

        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-12 flex-grow">
          <div class="lg:col-span-7 lg:order-1 order-2">
            <h2 class="text-xl font-bold text-locatera-dark mb-6 mt-6 lg:mt-0">Metode Pembayaran</h2>

            <label class="relative block mb-4 cursor-pointer group">
              <input type="radio" name="payment_method" value="credit_card" class="peer sr-only" checked>
              <div class="flex items-center justify-between p-4 rounded-2xl border border-transparent bg-locatera-orange text-white shadow-lg peer-checked:scale-[1.02] transition-all">
                <div class="flex items-center gap-4">
                  <div class="bg-white/20 p-1 rounded w-10 h-6 flex items-center justify-center relative overflow-hidden">
                    <div class="w-4 h-4 bg-red-500 rounded-full absolute left-1 opacity-90"></div>
                    <div class="w-4 h-4 bg-yellow-400 rounded-full absolute right-1 opacity-90"></div>
                  </div>
                  <div>
                    <p class="text-xs font-medium opacity-90">Kartu Kredit</p>
                    <p class="text-sm font-bold">5105 **** **** 0505</p>
                  </div>
                </div>
                <div class="w-5 h-5 rounded-full border-2 border-white flex items-center justify-center">
                  <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                </div>
              </div>
            </label>
            
            </div>

          <div class="lg:col-span-5 lg:order-2 order-1">
            <div class="bg-gray-50 lg:bg-white p-4 lg:p-6 rounded-2xl lg:border lg:border-gray-100">
              <h2 class="text-xl font-bold text-locatera-dark mb-4">Ringkasan Pesanan</h2>

              <div class="space-y-3 mb-6">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Produk</span>
                    <span class="font-medium text-gray-700 text-right">
                        <?php echo $productName; ?> 
                        <br><span class="text-xs text-gray-400">(<?php echo $variant; ?>) x<?php echo $qty; ?></span>
                    </span>
                </div>
                <div class="flex justify-between text-sm text-gray-500"><span>Harga Satuan</span><span class="font-medium text-gray-700">Rp <?php echo number_format($productPrice, 0, ',', '.'); ?></span></div>
                <div class="flex justify-between text-sm text-gray-500"><span>Ongkir (<?php echo $shippingOption; ?>)</span><span class="font-medium text-gray-700">Rp <?php echo number_format($shippingCost, 0, ',', '.'); ?></span></div>

                <hr class="border-gray-200 my-2">

                <div class="flex justify-between items-center">
                  <span class="font-bold text-locatera-dark">Total:</span>
                  <span class="font-bold text-locatera-dark text-xl">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 lg:border-none flex flex-col lg:flex-row lg:justify-end items-center gap-4">
            <button type="submit" class="w-full lg:w-auto bg-locatera-orange text-white font-bold px-12 py-4 rounded-xl shadow-lg hover:bg-orange-600 transition transform active:scale-95 uppercase tracking-wide">
                BAYAR SEKARANG
            </button>
        </div>
      </form>
    </div>
</body>
</html>