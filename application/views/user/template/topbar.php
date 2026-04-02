<!doctype html>
<html lang="id" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toko Header Footer</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&amp;display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; }
    body { font-family: 'Nunito Sans', sans-serif; }

    .search-box:focus-within {
      box-shadow: 0 0 0 2px #03AC0E;
    }

    .nav-item {
      transition: all 0.2s ease;
    }
    .nav-item:hover {
      transform: translateY(-2px);
    }

    .footer-link {
      transition: color 0.2s ease, padding-left 0.2s ease;
    }
    .footer-link:hover {
      padding-left: 4px;
    }

    .promo-banner {
      animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
      from { transform: translateY(-100%); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .icon-btn {
      transition: background 0.2s ease, transform 0.15s ease;
    }
    .icon-btn:hover {
      transform: scale(1.1);
    }
    .icon-btn:active {
      transform: scale(0.95);
    }

    .category-pill {
      transition: all 0.2s ease;
    }
    .category-pill:hover {
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .mobile-nav-item {
      transition: color 0.2s ease;
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full">
  <div id="app-wrapper" class="w-full h-full flex flex-col overflow-auto" style="background-color: #F0F3F7;"><!-- Promo Banner -->
   <div id="promo-banner" class="promo-banner w-full text-center py-1.5 text-xs font-semibold tracking-wide" style="background-color: #03AC0E; color: #FFFFFF;"><span id="promo-text">🚚 Gratis Ongkir Tanpa Batas — Belanja Sekarang!</span>
   </div><!-- Header -->
   <header class="w-full sticky top-0 z-50 shadow-md" style="background-color: #FFFFFF;"><!-- Top Header -->
    <div class="w-full px-4 md:px-8 lg:px-16 py-3">
     <div class="flex items-center gap-3 md:gap-6 max-w-7xl mx-auto"><!-- Logo --> <a href="#" id="store-name-link" class="flex-shrink-0 flex items-center gap-2" onclick="event.preventDefault()">
       <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #03AC0E;">
        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" /> <line x1="3" y1="6" x2="21" y2="6" /> <path d="M16 10a4 4 0 0 1-8 0" />
        </svg>
       </div><span id="store-name" class="hidden md:block text-lg font-extrabold" style="color: #03AC0E;">Apotek Belanja Bayur Farma</span> </a> <!-- Category Button (Desktop) --> <button class="hidden lg:flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold border-2 hover:bg-gray-50 transition" style="border-color: #E0E0E0; color: #333333;" onclick="event.preventDefault()"> <i data-lucide="layout-grid" style="width:16px;height:16px;"></i> Kategori </button> <!-- Search Bar -->
      <div class="flex-1 relative">
       <div class="search-box flex items-center rounded-lg border-2 overflow-hidden transition-all" style="border-color: #E0E0E0; background-color: #FFFFFF;">
        <div class="pl-3 flex items-center" style="color: #9E9E9E;"><i data-lucide="search" style="width:18px;height:18px;"></i>
        </div><input id="search-input" type="text" placeholder="Cari di TokoKu" class="w-full py-2.5 px-3 text-sm outline-none" style="color: #333333; background: transparent;"> <button class="px-4 py-2.5 text-sm font-bold text-white flex-shrink-0 hover:opacity-90 transition" style="background-color: #03AC0E;"> Cari </button>
       </div>
      </div><!-- Action Icons -->
      <div class="flex items-center gap-1 md:gap-2"><!-- Cart --> <button class="icon-btn relative p-2 rounded-full hover:bg-gray-100" style="color: #555555;" aria-label="Keranjang"> <i data-lucide="shopping-cart" style="width:22px;height:22px;"></i> <span class="absolute -top-0.5 -right-0.5 w-5 h-5 rounded-full text-white text-[10px] font-bold flex items-center justify-center" style="background-color: #F94D63;">3</span> </button> <!-- Notifications --> <button class="icon-btn hidden md:flex relative p-2 rounded-full hover:bg-gray-100" style="color: #555555;" aria-label="Notifikasi"> <i data-lucide="bell" style="width:22px;height:22px;"></i> <span class="absolute -top-0.5 -right-0.5 w-5 h-5 rounded-full text-white text-[10px] font-bold flex items-center justify-center" style="background-color: #F94D63;">5</span> </button> <!-- Chat --> <button class="icon-btn hidden md:flex p-2 rounded-full hover:bg-gray-100" style="color: #555555;" aria-label="Chat"> <i data-lucide="message-circle" style="width:22px;height:22px;"></i> </button> <!-- Divider -->
       <div class="hidden md:block w-px h-6 mx-1" style="background-color: #E0E0E0;"></div><!-- User --> <button class="icon-btn hidden md:flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition" style="color: #555555;">
        <div class="w-7 h-7 rounded-full flex items-center justify-center" style="background-color: #E8F5E9;"><i data-lucide="user" style="width:16px;height:16px;color:#03AC0E;"></i>
        </div><span class="text-sm font-semibold hidden lg:block" style="color: #333333;">Masuk</span> </button>
      </div>
     </div>
    </div><!-- Category Bar (Desktop) -->
    <div class="hidden md:block w-full border-t px-4 md:px-8 lg:px-16 py-2" style="border-color: #F0F0F0;">
     <div class="flex items-center gap-2 max-w-7xl mx-auto overflow-x-auto no-scrollbar"><a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #E8F5E9; color: #03AC0E;">🔥 Promo Hari Ini</a> <a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #F5F5F5; color: #555555;">Elektronik</a> <a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #F5F5F5; color: #555555;">Fashion Pria</a> <a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #F5F5F5; color: #555555;">Fashion Wanita</a> <a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #F5F5F5; color: #555555;">Handphone</a> <a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #F5F5F5; color: #555555;">Makanan</a> <a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #F5F5F5; color: #555555;">Kecantikan</a> <a href="#" onclick="event.preventDefault()" class="category-pill flex-shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: #F5F5F5; color: #555555;">Rumah Tangga</a>
     </div>
    </div>
   </header><!-- Main Content Area -->
</html>