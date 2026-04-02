<div class="container-fluid">

  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success">
              <?= $this->session->flashdata('success'); ?>
          </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger">
              <?= $this->session->flashdata('error'); ?>
          </div>
      <?php endif; ?>

  <div class="card shadow mb-4">
    <div class="card-body">
      <form method="POST" 
            action="<?= isset($product) ? base_url('product/update/'.$product->id) : base_url('product/save'); ?>">

        <!-- CSRF TOKEN -->
        <input type="hidden" 
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <!-- Kode Produk -->
        <div class="form-group">
          <label><strong>Kode Produk</strong></label>
          <input type="text" name="product_code" class="form-control"
            value="<?= isset($product) ? $product->product_code : $product_code; ?>" 
            readonly>
        </div>

        <!-- Nama Produk -->
        <div class="form-group">
          <label>Nama Produk</label>
          <input type="text" name="name" class="form-control"
            value="<?= isset($product) ? $product->name : ''; ?>" required>
        </div>

        <!-- Harga -->
        <div class="form-group">
          <label>Harga Produk</label>
          <input type="number" name="price" class="form-control"
            value="<?= isset($product) ? $product->price : ''; ?>" required>
        </div>

        <!-- Stok -->
        <div class="form-group">
          <label>Stok</label>
          <input type="number" name="stock" class="form-control"
            value="<?= isset($product) ? $product->stock : ''; ?>" required>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
          <label>Deskripsi Produk</label>
          <textarea name="description" class="form-control" rows="3" required>
            <?= isset($product) ? $product->description : ''; ?>
          </textarea>
        </div>

        <button type="submit" class="btn btn-success">
          <i class="fas fa-save"></i> Simpan
        </button>
        <a href="<?= base_url('product'); ?>" class="btn btn-secondary">Kembali</a>

      </form>
    </div>
  </div>
</div>
