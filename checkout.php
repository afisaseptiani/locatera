<?php
session_start();
require_once 'db_connection.php';

// Cek apakah ada data cart/produk yang dikirim
$productName = '';
$productPrice = 0;
$variant = '';
$qty = 0;
$subtotal = 0;
$grandTotal = 0;
$productId = null;

// Tangkap data dari POST (baik dari Product Detail atau Cart)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productId = $_POST['product_id'] ?? null;
    $variant = $_POST['selected_variant'] ?? 'Default';
    $qty = (int)($_POST['quantity'] ?? 1);
    
    // Jika dari Cart (multi item), logic bisa disesuaikan, 
    // tapi ini logic dasar untuk single item / direct order dulu
    if ($productId) {
        $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $productName = $row['name'];
            $productPrice = (int)$row['price'];
            $subtotal = $productPrice * $qty;
            $grandTotal = $subtotal;
        }
        $stmt->close();
    } elseif (isset($_POST['subtotal'])) {
        // Fallback jika data datang dari Cart (sudah dihitung di cart.php)
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];
        $subtotal = $_POST['subtotal'];
        $grandTotal = $subtotal;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Locatera</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Poppins', 'sans-serif'],
          },
          colors: {
            'locatera-orange': '#FF9D3D',
            'locatera-gray': '#6A6A6A',
            'locatera-dark': '#202020',
            'locatera-blue': '#001833',
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 font-poppins min-h-screen flex flex-col items-center py-8 px-4">

  <div class="w-full max-w-md lg:max-w-3xl bg-white lg:rounded-3xl shadow-xl min-h-[80vh] flex flex-col relative overflow-hidden">

    <div class="bg-white pt-6 pb-2 px-6 lg:px-10">
      <div class="flex items-center justify-between mb-6">
        <a href="javascript:history.back()" class="p-2 -ml-2 hover:bg-gray-100 rounded-full transition">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-locatera-dark">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
          </svg>
        </a>
        <h1 class="text-xl font-bold text-locatera-blue">Checkout</h1>
        <div class="w-10"></div>
      </div>
      
      <div class="flex items-center justify-center gap-4 mb-4">
        <div class="flex flex-col items-center">
            <div class="bg-orange-100 p-2 rounded-full mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-locatera-orange" viewBox="0 0 24 24" fill="currentColor"><path d="M11.54 22.351l.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg>
            </div>
            <span class="text-xs font-bold text-locatera-orange">Alamat</span>
        </div>
        <div class="w-10 h-0.5 bg-gray-200"></div>
        <div class="flex flex-col items-center opacity-40">
            <div class="bg-gray-100 p-2 rounded-full mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" /><path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" /></svg>
            </div>
        </div>
      </div>
    </div>

    <form action="payment.php" method="POST" id="checkoutForm" onsubmit="return validateCheckoutForm()" class="px-6 lg:px-10 pb-10 flex-grow flex flex-col">

      <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productName); ?>">
      <input type="hidden" name="product_price" value="<?php echo $productPrice; ?>">
      <input type="hidden" name="selected_variant" value="<?php echo htmlspecialchars($variant); ?>">
      <input type="hidden" name="quantity" value="<?php echo $qty; ?>">
      <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">

      <h2 class="text-xl font-bold text-locatera-dark mb-6">Detail Pengiriman</h2>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-x-8">

        <div class="group lg:col-span-2">
          <label class="block text-xs text-gray-400 mb-1">Nama Lengkap</label>
          <input type="text" name="fullname" class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium focus:outline-none focus:border-locatera-orange transition-colors" placeholder="Contoh: Budi Santoso" required>
        </div>

        <div class="lg:col-span-2">
          <label class="block text-xs text-gray-400 mb-1">Alamat Lengkap</label>
          <input type="text" name="address" class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium text-sm truncate focus:outline-none focus:border-locatera-orange transition-colors" placeholder="Jalan, No Rumah, RT/RW, Kelurahan" required>
        </div>

        <div class="relative">
          <label class="block text-xs text-gray-400 mb-1">Provinsi</label>
          <input type="text" id="provinceDisplay" readonly 
                 class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium text-sm focus:outline-none focus:border-locatera-orange transition-colors cursor-pointer bg-white" 
                 placeholder="Pilih Provinsi..."
                 onclick="openProvinceModal()">
          <input type="hidden" name="province" id="provinceInput">
          
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pt-4 text-gray-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </div>
        </div>

        <div>
          <label class="block text-xs text-gray-400 mb-1">Kode Pos</label>
          <input type="text" name="zipcode" id="zipcodeInput"
                 maxlength="5" 
                 pattern="\d{5}"
                 class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium focus:outline-none focus:border-locatera-orange transition-colors" 
                 placeholder="Contoh: 40123"
                 oninput="this.value = this.value.replace(/[^0-9]/g, '')">
          <p class="text-[10px] text-red-500 hidden mt-1" id="zipError">Wajib 5 digit angka</p>
        </div>

        <div>
          <label class="block text-xs text-gray-400 mb-1">Nomor Telepon</label>
          <input type="tel" name="phone" id="phoneInput"
                 minlength="10" maxlength="15"
                 pattern="\d{10,15}"
                 class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium focus:outline-none focus:border-locatera-orange transition-colors" 
                 placeholder="0812..."
                 required
                 oninput="this.value = this.value.replace(/[^0-9]/g, '')">
           <p class="text-[10px] text-red-500 hidden mt-1" id="phoneError">Min 10 - Max 15 angka</p>
        </div>

        <div class="relative mb-6">
          <label class="block text-xs text-gray-400 mb-1">Opsi Pengiriman</label>
          <input type="text" id="shippingDisplay" readonly 
                 class="w-full border-b border-gray-200 py-2 text-locatera-dark font-medium text-sm focus:outline-none focus:border-locatera-orange transition-colors cursor-pointer bg-white" 
                 placeholder="Pilih Pengiriman..."
                 onclick="openShippingModal()">
          <input type="hidden" name="shipping_option" id="shippingInput">
          <input type="hidden" name="shipping_cost" id="shippingCostInput">
          
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pt-4 text-gray-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </div>
        </div>
      </div>

      <div class="flex items-start mt-4 mb-8">
        <div class="flex items-center h-5">
          <input id="save_address" name="save_address" type="checkbox" class="w-5 h-5 text-locatera-orange rounded focus:ring-locatera-orange accent-locatera-orange" checked>
        </div>
        <div class="ml-3 text-xs lg:text-sm">
          <label for="save_address" class="font-medium text-gray-400">Simpan detail alamat ini (Akan berfungsi nanti)</label>
        </div>
      </div>

      <button type="submit" class="mt-auto lg:mt-8 w-full bg-locatera-orange text-white font-bold text-lg py-4 rounded-full shadow-lg hover:bg-orange-600 transition transform active:scale-95">
        Lanjut ke Pembayaran
      </button>
    </form>
  </div>

  <div id="provinceOverlay" onclick="closeProvinceModal()" class="fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300 opacity-0"></div>
  <div id="provinceModal" class="fixed bottom-0 left-0 right-0 bg-white z-50 rounded-t-3xl transform translate-y-full transition-transform duration-300 ease-out shadow-2xl max-w-md mx-auto h-[70vh] flex flex-col">
    <div class="p-6 border-b">
      <div class="flex items-center">
        <button type="button" onclick="closeProvinceModal()" class="p-1 -ml-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-gray-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
          </svg>
        </button>
        <h3 class="text-lg font-bold text-gray-800 ml-4">Pilih Provinsi</h3>
      </div>
      <div id="provinceLoading" class="hidden text-sm text-locatera-orange mt-2">Sedang memuat data...</div>
    </div>
    
    <div id="provinceListContainer" class="flex-grow overflow-y-auto p-6 space-y-2">
       </div>
  </div>

  <div id="shippingOverlay" onclick="closeShippingModal()" class="fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300 opacity-0"></div>
  <div id="shippingModal" class="fixed bottom-0 left-0 right-0 bg-white z-50 rounded-t-3xl transform translate-y-full transition-transform duration-300 ease-out shadow-2xl max-w-md mx-auto">
    <div class="p-6">
      <div class="flex items-center mb-6">
        <button type="button" onclick="closeShippingModal()" class="p-1 -ml-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 text-gray-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
          </svg>
        </button>
        <h3 class="text-lg font-bold text-gray-800 ml-4">Pilih Opsi Pengiriman</h3>
      </div>
      <div class="max-h-80 overflow-y-auto mb-6 space-y-2">
        <?php
        $shippingOptions = [
          ['name' => 'Reguler', 'cost' => 15000, 'display' => 'Reguler (+ Rp 15.000)'],
          ['name' => 'Hemat', 'cost' => 13000, 'display' => 'Hemat (+ Rp 13.000)'],
          ['name' => 'Kargo', 'cost' => 22500, 'display' => 'Kargo (+ Rp 22.500)'],
          ['name' => 'Kilat', 'cost' => 25000, 'display' => 'Kilat (+ Rp 25.000)'],
        ];
        foreach ($shippingOptions as $option):
        ?>
          <label class="flex justify-between items-center bg-gray-50 p-4 rounded-xl cursor-pointer hover:bg-gray-100 transition">
            <span class="font-medium text-locatera-dark text-sm"><?php echo htmlspecialchars($option['display']); ?></span>
            <input type="radio" name="selected_shipping" value="<?php echo htmlspecialchars($option['name']); ?>" 
                   data-cost="<?php echo htmlspecialchars($option['cost']); ?>" 
                   class="shipping-option h-5 w-5 text-locatera-orange border-gray-300 focus:ring-locatera-orange accent-locatera-orange" 
                   onchange="selectShipping(this.value, this.dataset.cost)">
          </label>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <script>
    const UI = {
      // Province Elements
      provinceModal: document.getElementById('provinceModal'),
      provinceOverlay: document.getElementById('provinceOverlay'),
      provinceDisplay: document.getElementById('provinceDisplay'),
      provinceInput: document.getElementById('provinceInput'),
      provinceList: document.getElementById('provinceListContainer'),
      provinceLoading: document.getElementById('provinceLoading'),

      // Shipping Elements
      shippingModal: document.getElementById('shippingModal'),
      shippingOverlay: document.getElementById('shippingOverlay'),
      shippingDisplay: document.getElementById('shippingDisplay'),
      shippingInput: document.getElementById('shippingInput'),
      shippingCostInput: document.getElementById('shippingCostInput'),

      // Inputs Validation
      zipInput: document.getElementById('zipcodeInput'),
      zipError: document.getElementById('zipError'),
      phoneInput: document.getElementById('phoneInput'),
      phoneError: document.getElementById('phoneError'),
      
      // State
      provincesLoaded: false,
    };

    // --- LOGIC API PROVINSI ---
    async function fetchProvinces() {
        if (UI.provincesLoaded) return; // Jangan fetch ulang kalau sudah ada

        UI.provinceLoading.classList.remove('hidden');
        try {
            // Menggunakan API Wilayah Indonesia Gratis
            const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
            const data = await response.json();
            
            UI.provinceList.innerHTML = ''; // Kosongkan list
            
            data.forEach(prov => {
                const label = document.createElement('label');
                label.className = 'flex justify-between items-center bg-gray-50 p-4 rounded-xl cursor-pointer hover:bg-gray-100 transition';
                label.innerHTML = `
                    <span class="font-medium text-locatera-dark text-sm">${prov.name}</span>
                    <input type="radio" name="temp_province" value="${prov.name}" 
                           class="province-option h-5 w-5 text-locatera-orange border-gray-300 focus:ring-locatera-orange accent-locatera-orange"
                           onchange="selectProvince('${prov.name}')">
                `;
                UI.provinceList.appendChild(label);
            });
            UI.provincesLoaded = true;

        } catch (error) {
            console.error('Gagal mengambil provinsi:', error);
            UI.provinceList.innerHTML = '<p class="text-red-500 text-center">Gagal memuat data provinsi. Cek koneksi internet.</p>';
        } finally {
            UI.provinceLoading.classList.add('hidden');
        }
    }

    function openProvinceModal() {
      fetchProvinces(); // Panggil API saat modal dibuka
      UI.provinceOverlay.classList.remove('hidden');
      setTimeout(() => {
        UI.provinceOverlay.classList.remove('opacity-0');
        UI.provinceModal.classList.remove('translate-y-full');
      }, 10);
    }

    function closeProvinceModal() {
      UI.provinceModal.classList.add('translate-y-full');
      UI.provinceOverlay.classList.add('opacity-0');
      setTimeout(() => {
        UI.provinceOverlay.classList.add('hidden');
      }, 300);
    }

    function selectProvince(name) {
      UI.provinceDisplay.value = name;
      UI.provinceInput.value = name;
      closeProvinceModal();
    }

    // --- LOGIC SHIPPING ---
    function openShippingModal() {
      UI.shippingOverlay.classList.remove('hidden');
      setTimeout(() => {
        UI.shippingOverlay.classList.remove('opacity-0');
        UI.shippingModal.classList.remove('translate-y-full');
      }, 10);
    }

    function closeShippingModal() {
      UI.shippingModal.classList.add('translate-y-full');
      UI.shippingOverlay.classList.add('opacity-0');
      setTimeout(() => {
        UI.shippingOverlay.classList.add('hidden');
      }, 300);
    }

    function selectShipping(name, cost) {
      const formattedCost = new Intl.NumberFormat('id-ID').format(cost);
      UI.shippingDisplay.value = name + ' (+ Rp ' + formattedCost + ')';
      UI.shippingInput.value = name;
      UI.shippingCostInput.value = cost;
      closeShippingModal();
    }

    // --- VALIDASI FORM ---
    function validateCheckoutForm() {
      let isValid = true;

      // 1. Validasi Kode Pos (5 Digit)
      const zipVal = UI.zipInput.value;
      if (!/^\d{5}$/.test(zipVal)) {
        UI.zipError.classList.remove('hidden');
        UI.zipInput.classList.add('border-red-500');
        isValid = false;
      } else {
        UI.zipError.classList.add('hidden');
        UI.zipInput.classList.remove('border-red-500');
      }

      // 2. Validasi Telepon (10-15 Digit)
      const phoneVal = UI.phoneInput.value;
      if (!/^\d{10,15}$/.test(phoneVal)) {
        UI.phoneError.classList.remove('hidden');
        UI.phoneInput.classList.add('border-red-500');
        isValid = false;
      } else {
        UI.phoneError.classList.add('hidden');
        UI.phoneInput.classList.remove('border-red-500');
      }

      // 3. Validasi Provinsi
      if (UI.provinceInput.value.trim() === "") {
        alert("Mohon pilih Provinsi.");
        return false;
      }

      // 4. Validasi Shipping
      if (UI.shippingInput.value.trim() === "") {
        alert("Mohon pilih Opsi Pengiriman.");
        return false;
      }

      return isValid;
    }
  </script>
</body>
</html>