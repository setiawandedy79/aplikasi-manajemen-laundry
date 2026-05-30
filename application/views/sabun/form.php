<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-soap me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> Sabun</h5>
    </div>
    <div class="content-area">
        <div class="card" style="max-width: 600px;">
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'sabun/update/'.$row->id : 'sabun/save') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Sabun <span class="text-danger">*</span></label>
                        <input type="text" name="nama_sabun" class="form-control" value="<?= $row->nama_sabun ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Satuan <span class="text-danger">*</span></label>
                        <select name="satuan_id" class="form-select" required>
                            <option value="">Pilih Satuan</option>
                            <?php foreach ($satuan as $s): ?>
                            <option value="<?= $s->id ?>" <?= ($row->satuan_id ?? '') == $s->id ? 'selected' : '' ?>><?= $s->nama_satuan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="stok_awal" class="form-control" value="<?= $row->stok_awal ?? '0' ?>" required>
                    </div>
                    <?php if (isset($row)): ?>
                    <div class="mb-3">
                        <label class="form-label fw-500">Stok Akhir</label>
                        <input type="number" step="0.01" name="stok_akhir" class="form-control" value="<?= $row->stok_akhir ?? '0' ?>" required>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label fw-500">Supplier</label>
                        <select name="supplier_id" class="form-select">
                            <option value="">-- Pilih Supplier --</option>
                            <?php if (!empty($supplier)): foreach ($supplier as $s): ?>
                            <option value="<?= $s->id ?>" <?= (isset($row->supplier_id) && $row->supplier_id == $s->id) ? 'selected' : '' ?>>
                                <?= isset($s->nama_supplier) ? $s->nama_supplier : '' ?>
                        </option>
                        <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <a href="<?= base_url('sabun') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>