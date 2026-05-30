<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-tshirt me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> Linen</h5>
    </div>
    <div class="content-area">
        <div class="card" style="max-width: 600px;">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Form Linen</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'pakaian/update/'.$row->id : 'pakaian/save') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Linen <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pakaian" class="form-control" value="<?= $row->nama_pakaian ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="Linen" <?= ($row->kategori ?? '') == 'Linen' ? 'selected' : '' ?>>Linen</option>
                            <option value="Baju" <?= ($row->kategori ?? '') == 'Baju' ? 'selected' : '' ?>>Baju</option>
                            <option value="Keset" <?= ($row->kategori ?? '') == 'Keset' ? 'selected' : '' ?>>Keset</option>
                            <option value="Perlak" <?= ($row->kategori ?? '') == 'Perlak' ? 'selected' : '' ?>>Perlak</option>
                            <option value="Scort" <?= ($row->kategori ?? '') == 'Scort' ? 'selected' : '' ?>>Scort</option>
                            <option value="Bed" <?= ($row->kategori ?? '') == 'Bed' ? 'selected' : '' ?>>Bed</option>
                            <option value="Bantal" <?= ($row->kategori ?? '') == 'Bantal' ? 'selected' : '' ?>>Bantal</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Berat Kotor (Kg)</label>
                                <input type="number" step="0.01" name="berat_kotor" class="form-control" 
                                       value="<?= isset($row->berat_kotor) ? $row->berat_kotor : '0.00' ?>">
                                <small class="text-muted">Berat sebelum dicuci</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Berat Bersih (Kg)</label>
                                <input type="number" step="0.01" name="berat_bersih" class="form-control" 
                                       value="<?= isset($row->berat_bersih) ? $row->berat_bersih : '0.00' ?>">
                                <small class="text-muted">Berat setelah dicuci</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                        <a href="<?= base_url('pakaian') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>