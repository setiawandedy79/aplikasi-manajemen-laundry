<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-truck me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> Supplier</h5>
    </div>
    <div class="content-area">
        <div class="card" style="max-width: 650px;">
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'supplier/update/'.$row->id : 'supplier/save') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="nama_supplier" class="form-control" value="<?= isset($row->nama_supplier) ? $row->nama_supplier : '' ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Kontak / PIC</label>
                                <input type="text" name="kontak" class="form-control" value="<?= isset($row->kontak) ? $row->kontak : '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="<?= isset($row->telepon) ? $row->telepon : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-500">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= isset($row->alamat) ? $row->alamat : '' ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <a href="<?= base_url('supplier') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>