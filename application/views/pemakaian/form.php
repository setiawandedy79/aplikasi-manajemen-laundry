<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-clock me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> Pemakaian Chemical</h5>
    </div>
    <div class="content-area">
        <div class="card" style="max-width: 650px;">
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'pemakaian/update/'.$row->id : 'pemakaian/save') ?>" method="post" id="formPemakaian">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $row->tanggal ?? date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Shift <span class="text-danger">*</span></label>
                                <select name="shift" class="form-select" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="pagi" <?= ($row->shift ?? '') == 'pagi' ? 'selected' : '' ?>>Pagi (06:00 - 13:00)</option>
                                    <option value="siang" <?= ($row->shift ?? '') == 'siang' ? 'selected' : '' ?>>Siang (13:00 - 20:00)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500">Pilih Chemical <span class="text-danger">*</span></label>
                        <select name="sabun_id" id="sabun_id" class="form-select" required>
                            <option value="">-- Pilih Chemical --</option>
                            <?php foreach ($sabun as $s): ?>
                            <option value="<?= $s->id ?>" data-stok="<?= $s->stok_akhir ?>" data-satuan="<?= $s->nama_satuan ?>" <?= ($row->sabun_id ?? '') == $s->id ? 'selected' : '' ?>>
                                <?= $s->nama_sabun ?> (Stok: <?= $s->stok_akhir ?> <?= $s->nama_satuan ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Jumlah Dipakai <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="jumlah" id="jumlah" class="form-control" value="<?= $row->jumlah ?? '0' ?>" required>
                                <small class="text-muted" id="stok_info"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" value="<?= $row->keterangan ?? '' ?>" placeholder="Opsional">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                        <a href="<?= base_url('pemakaian') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('sabun_id').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const stok = opt.getAttribute('data-stok');
    const satuan = opt.getAttribute('data-satuan');
    document.getElementById('stok_info').textContent = stok ? `Stok tersedia: ${stok} ${satuan}` : '';
    if(stok) document.getElementById('jumlah').setAttribute('max', stok);
});
</script>