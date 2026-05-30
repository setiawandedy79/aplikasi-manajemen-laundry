<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-balance-scale me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> Satuan</h5>
    </div>
    <div class="content-area">
        <div class="card" style="max-width: 500px;">
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'satuan_sabun/update/'.$row->id : 'satuan_sabun/save') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_satuan" class="form-control" value="<?= $row->nama_satuan ?? '' ?>" placeholder="Contoh: Liter, Kg, Ml" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <a href="<?= base_url('satuan_sabun') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>