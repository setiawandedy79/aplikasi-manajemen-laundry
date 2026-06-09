<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-truck-loading me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> Mutasi Masuk</h5>
    </div>
    <div class="content-area">
        <div class="card" style="max-width: 650px;">
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'mutasi/update/'.$row->id : 'mutasi/save') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $row->tanggal ?? date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Pilih Chemical <span class="text-danger">*</span></label>
                                <select name="sabun_id" id="sabun_id" class="form-select" required>
                                    <option value="">-- Pilih Chemical --</option>
                                    <?php foreach ($sabun as $s): ?>
                                    <option value="<?= $s->id ?>" data-stok="<?= $s->stok_akhir ?>" data-satuan="<?= $s->nama_satuan ?>" <?= ($row->sabun_id ?? '') == $s->id ? 'selected' : '' ?>>
                                        <?= $s->nama_sabun ?> (Stok saat ini: <?= $s->stok_akhir ?> <?= $s->nama_satuan ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Jumlah Masuk <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="jumlah" class="form-control" value="<?= $row->jumlah ?? '0' ?>" required min="0.01">
                                <small class="text-muted">Masukkan jumlah chemical yang baru diterima/ditambahkan</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" value="<?= $row->keterangan ?? '' ?>" placeholder="Contoh: Pembelian dari Supplier A">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <a href="<?= base_url('mutasi') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>