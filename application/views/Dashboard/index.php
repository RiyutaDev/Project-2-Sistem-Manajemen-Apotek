<div class="container-fluid">

<!-- NOTIF -->
<div class="alert alert-success">
    Selamat datang, admin!
</div>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Dashboard</h3>

    <div>
        <a href="<?= base_url('produk') ?>" class="btn btn-light">
            Daftar Produk
        </a>
        <a href="<?= base_url('kasir') ?>" class="btn btn-success">
            KASIR
        </a>
    </div>
</div>

<!-- CARD -->
<div class="row">

    <div class="col-md-3">
        <div class="card text-white p-3" style="background:#0f766e;">
            <small>Total Produk</small>
            <h3><?= $total_produk ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white p-3" style="background:#14b8a6;">
            <small>Total Pelanggan</small>
            <h3><?= $total_pelanggan ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-dark p-3" style="background:#facc15;">
            <small>Produk Kadaluarsa</small>
            <h3><?= $kadaluarsa ?></h3>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white p-3" style="background:#ef4444;">
            <small>Produk Stok Rendah</small>
            <h3><?= $stok_rendah ?></h3>
        </div>
    </div>

</div>

<br>

<!-- CONTENT -->
<div class="row">

    <!-- GRAFIK -->
    <div class="col-md-8">
        <div class="card p-3">
            <h5>Grafik Penjualan</h5>
            <canvas id="chart"></canvas>
        </div>
    </div>

    <!-- PANEL KANAN -->
    <div class="col-md-4">
        <div class="card p-3 text-center">

            <h5>Penjualan & Keuntungan Hari Ini</h5>

            <h2 style="color:green;">
                Rp <?= number_format($penjualan_hari_ini,0,',','.') ?>
            </h2>

            <p>Total transaksi hari ini</p>

            <p>Keuntungan hari ini:
                <strong>Rp <?= number_format($penjualan_hari_ini * 0.2,0,',','.') ?></strong>
            </p>

            <a href="<?= base_url('kasir') ?>" class="btn btn-success">
                Buka KASIR
            </a>

        </div>
    </div>

</div>

</div>