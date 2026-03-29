<div class="container-fluid">

    <?php
    // Tentukan sapaan berdasarkan jam saat ini (Pagi, Siang, Sore)
    $jam = date('H');
    if ($jam >= 5 && $jam < 12) {
        $salam = "Selamat Pagi";
    } elseif ($jam >= 12 && $jam < 17) {
        $salam = "Selamat Siang";
    } else {
        $salam = "Selamat Sore/Malam";
    }
    ?>

    <h1 class="h3 mb-4 text-gray-800">
        <?= $salam; ?>, Senang Melihat Anda Kembali **<?= $user["nama"]; ?>**! Siap Beraksi Hari Ini.

        <br>
        <small class="text-muted" style="font-size: 0.7em;">
            Anda login pada: <?= date('d M Y, H:i:s'); ?> WIB
        </small>
    </h1>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $jumlah_barang; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $jumlah_user; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>