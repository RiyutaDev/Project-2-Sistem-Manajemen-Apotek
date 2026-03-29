<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('orders/create'); ?>" class="btn btn-primary mb-3 shadow-sm">
        <i class="fas fa-plus-circle"></i> Tambah Order
    </a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi Sales Order</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="orderTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Kode & Item</th>
                            <th>Customer</th>
                            <th>Sales</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($orders as $o): ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="align-middle">
                                <strong><?= $o->order_code; ?></strong><br>
                                <button class="btn btn-link btn-sm p-0 text-info" type="button" data-toggle="collapse" data-target="#detail-<?= $o->id; ?>">
                                    <i class="fas fa-search-plus"></i> Lihat Barang
                                </button>
                                
                                <div class="collapse mt-2" id="detail-<?= $o->id; ?>">
                                    <div class="card card-body bg-light p-2 shadow-sm" style="font-size: 0.85rem;">
                                        <ul class="list-unstyled mb-0">
                                            <?php if(!empty($o->items_list)): 
                                                $items = explode('|', $o->items_list); 
                                                foreach($items as $item): ?>
                                                    <li><i class="fas fa-caret-right text-primary"></i> <?= htmlspecialchars($item); ?></li>
                                                <?php endforeach; 
                                            else: ?>
                                                <li class="text-muted italic">Detail tidak tersedia</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle"><?= htmlspecialchars($o->customer_name); ?></td>
                            <td class="align-middle"><?= htmlspecialchars($o->sales_name); ?></td>
                            <td class="text-center align-middle">
                                <?php 
                                $badge = ($o->status == 'draft') ? 'warning' : (($o->status == 'dikirim') ? 'info' : (($o->status == 'selesai') ? 'success' : 'danger'));
                                ?>
                                <span class="badge badge-<?= $badge; ?> px-2 py-1 w-100">
                                    <?= strtoupper($o->status); ?>
                                </span>
                            </td>
                            <td class="text-right align-middle font-weight-bold">
                                Rp <?= number_format($o->total_price,0,',','.'); ?>
                            </td>
                            <td class="text-center align-middle small">
                                <?= date('d/m/Y', strtotime($o->order_date)); ?>
                            </td>
                            <td class="align-middle">
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <div class="d-flex flex-column">
                                        <form action="<?= base_url('orders/update_status/'.$o->id); ?>" method="post" class="mb-1">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">   
                                            <div class="input-group input-group-sm">
                                                <select name="status" class="custom-select custom-select-sm">
                                                    <option value="draft" <?= $o->status=='draft' ? 'selected':'' ?>>Draft</option>
                                                    <option value="dikirim" <?= $o->status=='dikirim' ? 'selected':'' ?>>Dikirim</option>
                                                    <option value="selesai" <?= $o->status=='selesai' ? 'selected':'' ?>>Selesai</option>
                                                    <option value="dibatalkan" <?= $o->status=='dibatalkan' ? 'selected':'' ?>>Batal</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-success" type="submit"><i class="fas fa-check"></i> Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                        <a href="<?= base_url('orders/delete/'.$o->id); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus order ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <span class="badge badge-light text-muted border">Read Only</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#orderTable').DataTable({
            "paging": true,          // Pagination (Halaman)
            "lengthChange": true,    // Show Entries (Jumlah Data)
            "searching": true,       // Search (Pencarian Real-time)
            "ordering": true,        // Sorting
            "info": true,            // Info "Showing x of y"
            "autoWidth": false,      // Mencegah tabel melebar tidak jelas
            "responsive": true,
            "pageLength": 10,        // Default data per halaman
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "language": {
                "search": "Cari Data:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                },
            }
        });
    });
</script>