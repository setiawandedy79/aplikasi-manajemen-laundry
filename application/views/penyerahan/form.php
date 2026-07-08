<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-hand-holding me-2"></i> Form Penyerahan Laundry</h5>
    </div>
    <div class="content-area">

        <form action="<?= base_url('penyerahan/save') ?>" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="transaksi_id" value="<?= $header->id ?>">

            <!-- Info Transaksi -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-info-circle me-2"></i> Informasi Transaksi
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"><strong>No Transaksi:</strong> <?= $header->no_transaksi ?></div>
                        <div class="col-md-6"><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($header->tanggal)) ?></div>
                        <div class="col-md-6"><strong>Pengirim:</strong> <?= $header->nama_pengirim ?></div>
                        <div class="col-md-6"><strong>Penerima:</strong> <?= $header->nama_penerima ?></div>
                    </div>
                </div>
            </div>

            <!-- Nama Pengambil -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pengambil / Penerima Serahan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pengambil" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- ✅ SECTION 1: KLAIM DARI TRANSAKSI SEBELUMNYA -->
            <?php if (isset($pending_klaim) && !empty($pending_klaim)): ?>
            <div class="card mb-3 border-warning">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Klaim Kekurangan dari Transaksi Sebelumnya (<?= count($pending_klaim) ?> item)
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Nama Linen</th>
                                    <th class="text-center">Dikirim</th>
                                    <th class="text-center">Dikembalikan</th>
                                    <th class="text-center">Kurang</th>
                                    <th>Dikembalikan Sekarang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_klaim as $klaim): ?>
                                <tr>
                                    <td><?= $klaim->no_transaksi ?></td>
                                    <td><?= $klaim->nama_pakaian ?></td>
                                    <td class="text-center"><?= $klaim->jumlah ?></td>
                                    <td class="text-center"><?= $klaim->jumlah_diserahkan ?></td>
                                    <td class="text-center text-danger fw-bold"><?= $klaim->kurang ?></td>
                                    <td>
                                        <input type="number" name="klaim_jumlah[<?= $klaim->id ?>]" class="form-control form-control-sm" value="<?= $klaim->kurang ?>" max="<?= $klaim->kurang ?>" min="0">
                                        <input type="hidden" name="klaim_id[]" value="<?= $klaim->id ?>">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ✅ SECTION 2: DAFTAR LINEN TRANSAKSI SAAT INI -->
            <div class="card mb-3">
                <div class="card-header bg-info text-white fw-bold">
                    <i class="fas fa-list me-2"></i> Daftar Linen & Jumlah Penyerahan
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Linen</th>
                                    <th>Kategori</th>
                                    <th width="80">Status</th>
                                    <th width="150">Jumlah Diserahkan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                $ada_item_dipilih = false;
                                if (!empty($detail)):
                                    foreach ($detail as $d):
                                        if ($d->ceklis == 1): 
                                            $ada_item_dipilih = true;
                                            
                                            // 1. Ambil nilai dari database dengan aman
                                            $qty_awal  = isset($d->jumlah) ? (int)$d->jumlah : 0;
                                            $qty_serah = isset($d->jumlah_diserahkan) ? (int)$d->jumlah_diserahkan : 0;
                                            
                                            // 2. Logika Tampilan
                                            $tampil_qty = ($qty_serah > 0) ? $qty_serah : $qty_awal;
                                ?>
                                <!-- ✅ TAMBAHKAN class="row-detail" DAN data-* DI SINI -->
                                <tr class="row-detail" 
                                    data-detail-id="<?= $d->detail_id ?>" 
                                    data-nama-linen="<?= htmlspecialchars($d->nama_pakaian) ?>" 
                                    data-jumlah-awal="<?= $qty_awal ?>">
                                    
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $d->nama_pakaian ?></td>
                                    <td><?= $d->kategori ?></td>
                                    <td class="text-center"><span class="badge bg-success">Ya</span></td>
                                    <td>
                                        <input type="hidden" name="detail_id[]" value="<?= $d->detail_id ?>">
                                        <!-- ✅ TAMBAHKAN class="input-jumlah-diserahkan" DAN data-* DI INPUT INI -->
                                        <input type="number" name="jumlah_diserahkan[]" 
                                               class="form-control form-control-sm input-jumlah-diserahkan" 
                                               value="<?= $tampil_qty ?>" min="0" max="<?= $qty_awal ?>"
                                               data-status-kekurangan="<?= isset($d->status_kekurangan) ? $d->status_kekurangan : '' ?>"
                                               data-keterangan-kekurangan="<?= isset($d->keterangan_kekurangan) ? htmlspecialchars($d->keterangan_kekurangan) : '' ?>">
                                    </td>
                                    <td><input type="text" name="keterangan[]" class="form-control form-control-sm" value="<?= $d->keterangan ?>"></td>
                                </tr>
                                <?php 
                                        endif;
                                    endforeach;
                                endif; 
                                ?>

                                <?php if (!$ada_item_dipilih): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox me-2"></i> Tidak ada barang yang dipilih
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ✅ SECTION 3: TABEL DINAMIS KEKURANGAN (Muncul otomatis via JS) -->
            <div class="card mb-3 border-danger" id="card_kekurangan" style="display:none;">
                <div class="card-header bg-danger text-white fw-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i> Daftar Linen yang Belum Diserahkan Penuh
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="30%">Nama Linen</th>
                                    <th width="15%" class="text-center">Jumlah Kekurangan</th>
                                    <th width="25%">Status Kekurangan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_kekurangan">
                                <!-- Diisi otomatis oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ✅ SECTION 4: TAMBAH LINEN MANUAL -->
          <!--   <div class="mb-3">
                <button type="button" class="btn btn-success btn-sm" onclick="tambahLinenManual()">
                    <i class="fas fa-plus me-1"></i> Tambah Linen (Tidak Ada di Transaksi)
                </button>
                <small class="text-muted ms-2">Untuk linen yang hilang/rusak dan diganti baru</small>
            </div>
            <div id="container_linen_tambahan"></div> -->

            <!-- Tombol Aksi -->
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary btn-lg" id="btnSimpan">
                    <i class="fas fa-save me-2"></i> Simpan Penyerahan
                </button>
                <a href="<?= base_url('penyerahan') ?>" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>

<!-- ✅ JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateKekuranganTable() {
        const tbody = document.getElementById('tbody_kekurangan');
        if (!tbody) return; // Jika tabel tidak ada, keluar
        
        tbody.innerHTML = '';
        let hasKekurangan = false;

        document.querySelectorAll('.row-detail').forEach(row => {
            const detailId = row.dataset.detailId;
            const namaLinen = row.dataset.namaLinen;
            const jumlahAwal = parseInt(row.dataset.jumlahAwal) || 0;
            const inputJumlah = row.querySelector('.input-jumlah-diserahkan');
            const jumlahDiserahkan = parseInt(inputJumlah.value) || 0;
            
            const kekurangan = jumlahAwal - jumlahDiserahkan;
            
            if (kekurangan > 0) {
                hasKekurangan = true;
                const tr = document.createElement('tr');
                const currentStatus = inputJumlah.dataset.statusKekurangan || '';
                const currentKeterangan = inputJumlah.dataset.keteranganKekurangan || '';
                
                // ✅ PENTING: Nama input harus menggunakan array dengan key detail_id
                tr.innerHTML = `
                    <td><strong>${namaLinen}</strong></td>
                    <td class="text-center text-danger fw-bold">${kekurangan}</td>
                    <td>
                        <select name="status_kekurangan[${detailId}]" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="rusak" ${currentStatus === 'rusak' ? 'selected' : ''}>🔥 Rusak (Tidak muncul di penyerahan berikutnya)</option>
                            <option value="belum_terkirim" ${currentStatus === 'belum_terkirim' ? 'selected' : ''}>📦 Belum Terkirim (Muncul di penyerahan berikutnya)</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="keterangan_kekurangan[${detailId}]" class="form-control form-control-sm" placeholder="Alasan / Catatan" value="${currentKeterangan}">
                    </td>
                `;
                tbody.appendChild(tr);
            }
        });

        const cardKekurangan = document.getElementById('card_kekurangan');
        if (cardKekurangan) {
            cardKekurangan.style.display = hasKekurangan ? 'block' : 'none';
        }
    }

    // Pasang event listener
    document.querySelectorAll('.input-jumlah-diserahkan').forEach(input => {
        input.addEventListener('change', updateKekuranganTable);
        input.addEventListener('keyup', updateKekuranganTable);
    });

    // Jalankan sekali saat halaman dimuat
    updateKekuranganTable();
});
</script>