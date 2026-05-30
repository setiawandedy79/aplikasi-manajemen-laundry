<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-users me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> Unit</h5>
    </div>
    <div class="content-area">
        <div class="card" style="max-width: 600px;">
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'pelanggan/update/'.$row->id : 'pelanggan/save') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Unit <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="<?= $row->nama ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= $row->alamat ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Telepon Ext.</label>
                        <input type="text" name="telepon" class="form-control" value="<?= $row->telepon ?? '' ?>">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <a href="<?= base_url('pelanggan') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>