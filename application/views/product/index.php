<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> <?= $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= site_url('product/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php $no = 1; foreach ($products as $p): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><span class="badge badge-light"><?= htmlspecialchars($p->product_code); ?></span></td>
                                <td><?= htmlspecialchars($p->name); ?></td>
                                <td>Rp <?= number_format($p->price, 0, ',', '.'); ?></td>
                                <td>
                                    <?php
                                        $stock = $p->stock;
                                        if ($stock <= 5) {
                                            $badge = 'badge badge-danger';   // merah
                                        } elseif ($stock <= 10) {
                                            $badge = 'badge badge-warning';  // kuning
                                        } else {
                                            $badge = 'badge badge-success';  // hijau
                                        }
                                    ?>
                                    <span class="<?= $badge; ?> px-3"><?= htmlspecialchars($stock); ?></span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= site_url('product/edit/'.$p->id); ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= site_url('product/delete/'.$p->id); ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Data yang sudah ada di transaksi tidak akan bisa dihapus.');" 
                                           title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data produk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>