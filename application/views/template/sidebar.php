<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('dashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PT Maju Jaya Elektronik</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= site_url('dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <?php if ($this->session->userdata('role_id') == 1): ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Manajemen Data</div>

        <li class="nav-item <?= ($this->uri->segment(1) == 'product') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('product'); ?>">
                <i class="fas fa-boxes"></i>
                <span>Produk</span>
            </a>
        </li>

        <li class="nav-item <?= ($this->uri->segment(1) == 'customer') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('customer'); ?>">
                <i class="fas fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>

        <li class="nav-item <?= ($this->uri->segment(1) == 'sales') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('sales'); ?>">
                <i class="fas fa-user-tie"></i>
                <span>Sales</span>
            </a>
        </li>

        <li class="nav-item <?= ($this->uri->segment(1) == 'orders') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('orders'); ?>">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Sales Order</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Laporan Aktivitas</div>

        <li class="nav-item <?= ($this->uri->segment(1) == 'audit_log') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('audit_log'); ?>">
                <i class="fas fa-history"></i>
                <span>Riwayat Login</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($this->session->userdata('role_id') == 2): ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Transaksi Saya</div>

        <li class="nav-item <?= ($this->uri->segment(1) == 'orders') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('orders'); ?>">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Sales Order Saya</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($this->session->userdata('role_id') == 3): ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Laporan</div>

        <li class="nav-item <?= ($this->uri->segment(1) == 'report') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= site_url('report'); ?>">
                <i class="fas fa-chart-line"></i>
                <span>Laporan Penjualan</span>
            </a>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<div id="content-wrapper" class="d-flex flex-column"> 

    <div id="content">
        
<!-- 
---

## 3. 🔝 `template/topbar.php`

Ini menggunakan `ml-auto` dan mengakses data profil dari *session* untuk memastikan gambar profil SVG muncul di **pojok kanan atas**.

```php
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= $this->session->userdata('fullname'); ?> (<?= $this->session->userdata('role'); ?>)
                </span>
                
                <?php 
                    $role_id = $this->session->userdata('role_id');
                    $profile_image = 'default.svg'; 
                    
                    if ($role_id == 1) {
                        $profile_image = 'undraw_profile_1.svg';
                    } elseif ($role_id == 2) {
                        $profile_image = 'undraw_profile_2.svg';
                    } elseif ($role_id == 3) {
                        $profile_image = 'undraw_profile_3.svg';
                    }
                ?>
                <img class="img-profile rounded-circle"
                    src="<?= base_url('assets/img/profile/') . $profile_image; ?>" width="40">
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <a class="dropdown-item" href="<?= site_url('user/profile'); ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                
                <div class="dropdown-divider"></div>
                
                <span class="dropdown-item text-muted small" style="pointer-events: none;">
                    **Terakhir Login:**
                    <?php 
                    $last_login = $this->session->userdata('last_login');
                    if (!empty($last_login)) {
                        echo date('d M Y H:i', strtotime($last_login)) . ' WIB';
                    } else {
                        echo 'Belum pernah login';
                    }
                    ?>
                </span>
                
                <div class="dropdown-divider"></div>
                
                <a class="dropdown-item" href="<?= site_url('auth/logout'); ?>">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav> -->