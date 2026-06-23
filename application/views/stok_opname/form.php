<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-clipboard-check me-2"></i> Input Stok Opname</h5>
    </div>
    <div class="content-area">
        <form action="<?= base_url('stok_opname/save') ?>" method="post">
            <div class="card">
                <div class="card-header bg-info text-white fw-bold">
                    <i class="fas fa-info-circle me-2"></i> Petunjuk Pengisian
                </div>
                <div class="card-body">
                    <div class="alert alert-light border">
                        <strong>Cara Melakukan Stok Opname:</strong>
                        <ol class="mb-0 mt-2">
                            <li>Pilih chemical yang akan diopname</li>
                            <li>Lihat <strong>Stok Sistem</strong> (otomatis dari database)</li>
                            <li>Hitung fisik chemical di gudang, masukkan ke <strong>Stok Fisik</strong></li>
                            <li>Sistem akan otomatis menghitung <strong>Selisih</strong></li>
                            <li>Isi keterangan jika ada selisih (misal: "Tumpah 2 liter", "Koreksi sisa wadah")</li>
                            <li>Klik Simpan → Stok sistem akan disesuaikan dengan stok fisik</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Opname <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" 
                                   value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pilih Chemical <span class="text-danger">*</span></label>
                            <select name="sabun_id" id="sabun_id" class="form-select" required>
                                <option value="">-- Pilih Chemical --</option>
                                <?php foreach ($sabun as $s): ?>
                                    <option value="<?= $s->id ?>" 
                                            data-stok="<?= $s->stok_akhir ?>" 
                                            data-satuan="<?= $s->nama_satuan ?? '' ?>">
                                        <?= $s->nama_sabun ?> (Stok Sistem: <?= number_format($s->stok_akhir, 2) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Stok Sistem (Otomatis)</label>
                            <input type="text" id="stok_sistem_display" class="form-control bg-light" 
                                   readonly placeholder="Pilih chemical dulu">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Stok Fisik (Hasil Hitung) <span class="text-danger">*</span></label>
                            <input type="number" name="stok_fisik" id="stok_fisik" class="form-control" 
                                   step="0.01" min="0" required placeholder="Masukkan hasil hitung fisik">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Selisih (Otomatis)</label>
                            <input type="text" id="selisih_display" class="form-control bg-light fw-bold" 
                                   readonly placeholder="-">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" 
                                      placeholder="Contoh: Tumpah 2 liter, Koreksi sisa di jerigen, dll"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary btn-lg" 
                        onclick="return confirm('Yakin stok sistem akan disesuaikan dengan stok fisik?')">
                    <i class="fas fa-save me-2"></i> Simpan & Sesuaikan Stok
                </button>
                <a href="<?= base_url('stok_opname') ?>" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sabunSelect   = document.getElementById('sabun_id');
    const stokSistem    = document.getElementById('stok_sistem_display');
    const stokFisik     = document.getElementById('stok_fisik');
    const selisihDisplay = document.getElementById('selisih_display');
    
    let currentStokSistem = 0;
    
    // Saat pilih chemical
    sabunSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        currentStokSistem = parseFloat(option.dataset.stok) || 0;
        const satuan = option.dataset.satuan || '';
        
        if (currentStokSistem > 0) {
            stokSistem.value = currentStokSistem.toFixed(2) + ' ' + satuan;
        } else {
            stokSistem.value = '-';
        }
        hitungSelisih();
    });
    
    // Saat input stok fisik berubah
    stokFisik.addEventListener('input', hitungSelisih);
    
    function hitungSelisih() {
        const fisik = parseFloat(stokFisik.value) || 0;
        const selisih = fisik - currentStokSistem;
        
        if (currentStokSistem > 0 && stokFisik.value !== '') {
            if (selisih > 0) {
                selisihDisplay.value = '+ ' + selisih.toFixed(2) + ' (Surplus/Stok Fisik Lebih)';
                selisihDisplay.classList.add('text-success');
                selisihDisplay.classList.remove('text-danger');
            } else if (selisih < 0) {
                selisihDisplay.value = '- ' + Math.abs(selisih).toFixed(2) + ' (Defisit/Stok Fisik Kurang)';
                selisihDisplay.classList.add('text-danger');
                selisihDisplay.classList.remove('text-success');
            } else {
                selisihDisplay.value = '0 (Cocok)';
                selisihDisplay.classList.remove('text-success', 'text-danger');
            }
        } else {
            selisihDisplay.value = '-';
        }
    }
});
</script>