<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="card shadow mb-4">
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
               value="<?= $this->security->get_csrf_hash(); ?>" />

        <div class="form-group">
          <label>Kode Sales</label>
          <input type="text" name="sales_code" class="form-control" value="<?= $sales_code; ?>" readonly>
        </div>
        <div class="form-group">
          <label>Nama</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Telepon</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
          <label>Catatan</label>
          <textarea name="note" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= base_url('sales'); ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
