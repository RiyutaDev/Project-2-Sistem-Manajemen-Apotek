<div class="container-fluid">

<h4 class="mb-3">🛒 KASIR</h4>

<div class="row">

    <!-- ========================= -->
    <!-- PRODUK -->
    <!-- ========================= -->
    <div class="col-md-8">

        <!-- SEARCH -->
        <input type="text" id="search" class="form-control mb-3" placeholder="🔍 Cari produk...">

        <div class="row" id="produkList">

            <?php if(!empty($produk)): ?>
            <?php foreach($produk as $p): ?>

            <div class="col-md-4 produk-item">
                <div class="card p-3 mb-3 h-100 text-center">

                    <!-- GAMBAR -->
                    <img src="<?= !empty($p->gambar) ? $p->gambar : 'https://via.placeholder.com/150' ?>" 
                         class="img-fluid mb-2"
                         style="height:120px; object-fit:cover; border-radius:10px;">

                    <!-- NAMA -->
                    <h6 class="fw-bold"><?= htmlspecialchars($p->nama_produk) ?></h6>

                    <!-- KATEGORI & SUPPLIER -->
                    <small class="text-muted">
                        <?= $p->nama_kategori ?? '-' ?> | <?= $p->nama_supplier ?? '-' ?>
                    </small>

                    <!-- HARGA -->
                    <div class="text-success fw-bold">
                        Rp <?= number_format($p->harga_jual,0,',','.') ?>
                    </div>

                    <!-- STOK -->
                    <small class="text-muted">Stok: <?= $p->stok ?></small>

                    <!-- BUTTON -->
                    <button class="btn btn-success btn-sm mt-2"
                        onclick="tambah(
                            <?= (int)$p->id_produk ?>,
                            '<?= addslashes($p->nama_produk) ?>',
                            <?= (int)$p->harga_jual ?>
                        )">
                        + Tambah
                    </button>

                </div>
            </div>

            <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning">Produk tidak tersedia</div>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <!-- ========================= -->
    <!-- KERANJANG -->
    <!-- ========================= -->
    <div class="col-md-4">

        <div class="card p-3">

            <h5 class="mb-3">🧾 Keranjang</h5>

            <div style="max-height:300px; overflow-y:auto;">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="cart"></tbody>
                </table>
            </div>

            <hr>

            <!-- TOTAL -->
            <h5>Total: Rp <span id="total">0</span></h5>

            <!-- BAYAR -->
            <input type="number" id="bayar" class="form-control mt-2" placeholder="Masukkan uang">

            <!-- KEMBALIAN -->
            <h6 class="mt-2">Kembalian: Rp <span id="kembalian">0</span></h6>

            <!-- BUTTON CEPAT -->
            <div class="mt-2">
                <button class="btn btn-light btn-sm" onclick="setBayar(10000)">10K</button>
                <button class="btn btn-light btn-sm" onclick="setBayar(20000)">20K</button>
                <button class="btn btn-light btn-sm" onclick="setBayar(50000)">50K</button>
                <button class="btn btn-light btn-sm" onclick="setBayar(100000)">100K</button>
            </div>

            <!-- CHECKOUT -->
            <button class="btn btn-primary w-100 mt-3" onclick="checkout()">
                💳 Bayar
            </button>

        </div>

    </div>

</div>

</div>

<!-- ========================= -->
<!-- SCRIPT -->
<!-- ========================= -->
<script>
const BASE_URL = "<?= base_url() ?>";

let cart = [];

// TAMBAH PRODUK
function tambah(id,nama,harga){
    let item = cart.find(i => i.id == id);

    if(item){
        item.qty++;
    } else {
        cart.push({id,nama,harga,qty:1});
    }

    render();
}

// RENDER CART
function render(){
    let html = '';
    let total = 0;

    cart.forEach(i => {
        let sub = i.qty * i.harga;
        i.subtotal = sub;
        total += sub;

        html += `
        <tr>
            <td>${i.nama}</td>
            <td>${i.qty}</td>
            <td>Rp ${rupiah(sub)}</td>
        </tr>`;
    });

    document.getElementById('cart').innerHTML = html;
    document.getElementById('total').innerText = rupiah(total);

    hitungKembalian();
}

// SET BAYAR CEPAT
function setBayar(nominal){
    document.getElementById('bayar').value = nominal;
    hitungKembalian();
}

// HITUNG KEMBALIAN
function hitungKembalian(){
    let total = cart.reduce((a,b)=>a + (b.subtotal || 0), 0);
    let bayar = parseInt(document.getElementById('bayar').value) || 0;

    let kembali = bayar - total;
    document.getElementById('kembalian').innerText = rupiah(kembali > 0 ? kembali : 0);
}

// CHECKOUT
function checkout(){

    let total = cart.reduce((a,b)=>a + (b.subtotal || 0), 0);
    let bayar = parseInt(document.getElementById('bayar').value) || 0;

    if(cart.length === 0){
        alert('Keranjang kosong!');
        return;
    }

    if(bayar < total){
        alert('Uang tidak cukup!');
        return;
    }

    fetch(BASE_URL + 'kasir/simpan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            produk: cart,
            total: total
        })
    })
    .then(res => res.json())
    .then(res => {
        alert('Transaksi berhasil!');
        location.reload();
    })
    .catch(err => {
        alert('Terjadi error!');
        console.error(err);
    });
}

// FORMAT RUPIAH
function rupiah(angka){
    return new Intl.NumberFormat('id-ID').format(angka);
}

// SEARCH PRODUK
document.getElementById('search').addEventListener('keyup', function(){
    let keyword = this.value.toLowerCase();
    let items = document.querySelectorAll('.produk-item');

    items.forEach(item => {
        let nama = item.innerText.toLowerCase();
        item.style.display = nama.includes(keyword) ? '' : 'none';
    });
});
</script>