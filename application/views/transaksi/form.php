<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-receipt me-2"></i> Tambah Transaksi Laundry</h5>
    </div>
    <div class="content-area">
        <!-- SATU FORM UTAMA UNTUK SEMUA INPUT -->
        <!-- <form action="<?= base_url('transaksi/save') ?>" method="post"> -->
            <form action="<?= base_url(isset($is_edit) && $is_edit ? 'transaksi/update/'.$transaksi_id : 'transaksi/save') ?>" method="post" onsubmit="return lockButton()>  

            <!-- Bagian Header -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Informasi Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">No Transaksi</label>
                                <input type="text" name="no_transaksi" class="form-control" value="<?= isset($no_transaksi) ? $no_transaksi : '' ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <!-- <label class="form-label fw-500">No Transaksi</label>
                                    <input type="text" name="no_transaksi" class="form-control" value="<?= isset($no_transaksi) ? $no_transaksi : '' ?>" readonly> -->
                                    <!-- <small class="text-muted">
                                        Status: 
                                        <?php $status = isset($header->status_serah) ? $header->status_serah : 'belum'; ?>
                                        <?= $status == 'diserahkan' ? '<span class="text-success fw-semibold">Sudah Diserahkan</span>' : '<span class="text-warning fw-semibold">Belum Diserahkan</span>' ?>
                                    </small> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="<?= isset($header) && $header->tanggal ? $header->tanggal : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">Shift <span class="text-danger">*</span></label>
                                <select name="shift" class="form-select" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="pagi" <?= (isset($header) && $header->shift == 'pagi') ? 'selected' : '' ?>>Pagi (09.00 - 09.30)</option>
                                    <option value="siang" <?= (isset($header) && $header->shift == 'siang') ? 'selected' : '' ?>>Siang (15.00 - 15.30)</option>
                                    <option value="Malam" <?= (isset($header->shift) && strtolower($header->shift) == 'malam') ? 'selected' : '' ?>>Malam (05.00 - 05.30)</option>
                                </select>
                            </div>
                           
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Unit / Ruangan <span class="text-danger">*</span></label>
                                
                                <?php if (!empty($user_pelanggan_id)): ?>
                                    <!-- ✅ KONDISI 1: User terikat unit (Kasir/Operator) -->
                                    <!-- Tampilkan nama unit sebagai teks biasa agar tidak bisa diganti -->
                                    <input type="text" class="form-control bg-light" value="<?= $user_pelanggan_nama ?>" readonly>
                                    
                                    <!-- Kirim ID unit secara tersembunyi -->
                                    <input type="hidden" name="pelanggan_id" value="<?= $user_pelanggan_id ?>">
                                    <small class="text-muted"><i class="fas fa-lock me-1"></i>Unit terkunci otomatis sesuai akun login Anda.</small>
                                    
                                <?php else: ?>
                                    <!-- ✅ KONDISI 2: Admin (Bebas memilih unit) -->
                                    <select name="pelanggan_id" class="form-select" required>
                                        <option value="">-- Pilih Unit / Ruangan --</option>
                                        <?php if (!empty($pelanggan)): ?>
                                            <?php foreach ($pelanggan as $p): ?>
                                                <!-- ✅ PRE-SELECT: Otomatis pilih unit yang sesuai dengan transaksi yang sedang diedit -->
                                                <option value="<?= $p->id ?>" 
                                                    <?= (isset($header) && $header->pelanggan_id == $p->id) ? 'selected' : '' ?>>
                                                    <?= $p->nama ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Nama Pengirim <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pengirim" class="form-control" value="<?= isset($header) ? $header->nama_pengirim : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" name="nama_penerima" class="form-control" value="<?= isset($header) ? $header->nama_penerima : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">Jenis Laundry <span class="text-danger">*</span></label>
                                <select name="jenis_laundry" class="form-select" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="Infeksius" <?= (isset($header) && $header->jenis_laundry == 'Infeksius') ? 'selected' : '' ?>>
                                        🦠 Infeksius
                                    </option>
                                    <option value="Non Infeksius" <?= (isset($header) && ($header->jenis_laundry == 'Non Infeksius' || empty($header->jenis_laundry))) ? 'selected' : '' ?>>
                                        🛡️ Non Infeksius
                                    </option>
                                </select>
                                <small class="text-muted">Pilih kategori risiko linen</small>
                            </div>
                            <!-- ✅ TAMBAHKAN KODE PENCARIAN LINEN DI SINI -->
                            <!-- ✅ GANTI TEKS "Cari Nama Linen" DENGAN INPUT INI -->
                            <div class="mb-3">
                                <label class="form-label fw-bold"><i class="fas fa-search me-1"></i> Cari Nama Linen</label>
                                <input type="text" id="searchLinen" class="form-control" placeholder="Ketik nama linen ">
                                <small class="text-muted" id="infoLinen">Menampilkan semua linen</small>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Bagian Detail Barang -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-tshirt me-2 text-primary"></i>Daftar Linen</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="tabelLinen">
                            <thead class="table-dark">
                                <tr>
                                    <th width="60" class="text-center">No</th>
                                    <th class="text-center">Nama Linen</th>
                                    <th class="text-center">Kategori</th>
                                    <th width="80" class="text-center">Ceklis</th>
                                    <th width="100" class="text-center">Jumlah</th>
                                    <th width="100" class="text-center">Berat (Kg)</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pakaian as $key => $p): ?>
    
                                <?php 
                                // 1. Inisialisasi default
                                $checked    = false;
                                $jumlah_val = 0;
                                $kg_val     = 0.00;
                                $ket_val    = '';

                                // 2. ✅ COCOKKAN BERDASARKAN pakaian_id (BUKAN index $key)
                                if (isset($detail) && is_array($detail)) {
                                    foreach ($detail as $d) {
                                        if ($d->pakaian_id == $p->id) {
                                            // ✅ Hanya centang jika ceklIS == 1 DAN jumlah > 0
                                            $checked    = ($d->ceklis == 1 && $d->jumlah > 0);
                                            $jumlah_val = $d->jumlah;
                                            $kg_val     = isset($d->jumlah_kg) ? $d->jumlah_kg : 0.00;
                                            $ket_val    = $d->keterangan;
                                            break;
                                        }
                                    }
                                }
                                ?>

                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td class="text-left"><?= $p->nama_pakaian ?></td>
                                    <td><?= $p->kategori ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" name="ceklis[<?= $key ?>]" value="1" <?= $checked ? 'checked' : '' ?>>
                                    </td>
                                    <td>
                                        <input type="hidden" name="pakaian_id[<?= $key ?>]" value="<?= $p->id ?>">
                                        <input type="number" name="jumlah[<?= $key ?>]" class="form-control form-control-sm" value="<?= $jumlah_val ?>">
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah_kg[<?= $key ?>]" class="form-control form-control-sm" step="0.01" value="<?= $kg_val ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="keterangan[<?= $key ?>]" class="form-control form-control-sm" value="<?= $ket_val ?>">
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                                <!-- <?php $i++; ?> -->
                                <!-- <?php 
                                $i = 0; 
                                if (!empty($pakaian)):
                                    foreach ($pakaian as $p): 
                                ?>
                                
                                <?php 
                                        $i++; 
                                    endforeach; 
                                else: 
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data linen. <a href="<?= base_url('pakaian/add') ?>">Tambah data</a> terlebih dahulu.
                                    </td>
                                </tr>
                                <?php endif; ?> -->
                                <script>
                                (function() {
                                    var searchInput = document.getElementById('searchLinen');
                                    var tableRows = document.querySelectorAll('#tabelLinen tbody tr');
                                    var infoText = document.getElementById('infoLinen');

                                    if (searchInput && tableRows.length > 0 && infoText) {
                                        searchInput.addEventListener('keyup', function() {
                                            var filter = this.value.toLowerCase().trim();
                                            var visibleCount = 0;

                                            tableRows.forEach(function(row) {
                                                var cell = row.cells[1]; // Kolom ke-2 = Nama Linen
                                                if (cell) {
                                                    var namaLinen = cell.textContent.toLowerCase().trim();
                                                    if (namaLinen.includes(filter)) {
                                                        row.style.display = '';
                                                        visibleCount++;
                                                    } else {
                                                        row.style.display = 'none';
                                                    }
                                                }
                                            });

                                            if (filter === '') {
                                                infoText.textContent = 'Menampilkan semua linen';
                                                infoText.className = 'text-muted';
                                            } else {
                                                infoText.textContent = 'Ditemukan ' + visibleCount + ' linen yang cocok';
                                                infoText.className = visibleCount > 0 ? 'text-success fw-bold' : 'text-danger fw-bold';
                                            }
                                        });
                                    }
                                })();
                                </script>
                            </tbody>
                        </table>
                            <!-- ✅ LETAKKAN SCRIPT PENCARIAN DI SINI (Tepat setelah tabel ditutup) -->
                            <script>
                            (function() {
                                var searchInput = document.getElementById('searchLinen');
                                var tableRows = document.querySelectorAll('#tabelLinen tbody tr');
                                var infoText = document.getElementById('infoLinen');

                                // Cek apakah elemen ada sebelum menjalankan script
                                if (searchInput && tableRows.length > 0 && infoText) {
                                    searchInput.addEventListener('keyup', function() {
                                        var filter = this.value.toLowerCase().trim();
                                        var visibleCount = 0;

                                        tableRows.forEach(function(row) {
                                            // Ambil teks dari kolom ke-2 (Nama Linen) -> Index 1
                                            var cell = row.cells[1];
                                            if (cell) {
                                                var namaLinen = cell.textContent.toLowerCase().trim();
                                                
                                                if (namaLinen.includes(filter)) {
                                                    row.style.display = ''; // Tampilkan baris
                                                    visibleCount++;
                                                } else {
                                                    row.style.display = 'none'; // Sembunyikan baris
                                                }
                                            }
                                        });

                                        // Update teks informasi
                                        if (filter === '') {
                                            infoText.textContent = 'Menampilkan semua linen';
                                            infoText.className = 'text-muted';
                                        } else {
                                            infoText.textContent = 'Ditemukan ' + visibleCount + ' linen yang cocok';
                                            infoText.className = visibleCount > 0 ? 'text-success fw-bold' : 'text-danger fw-bold';
                                        }
                                    });
                                } else {
                                    console.log('⚠️ Elemen pencarian tidak ditemukan. Pastikan ID searchLinen, tabelLinen, dan infoLinen benar.');
                                }
                            })();
                            </script>

        <!-- Tombol Simpan & Kembali (Biarkan tetap di sini) -->
        <!-- <div class="mt-3 d-flex gap-2">
            ...
                    </div>
                </div>
            </div>
 -->
            <!-- Tombol Simpan (Di dalam form yang sama) -->
            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> <?= isset($is_edit) && $is_edit ? 'Update Transaksi' : 'Simpan Transaksi' ?>
                </button>
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <script>
                    function lockButton() {
                        var btn = document.getElementById('btnSimpan');
                        btn.disabled = true; 
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...'; 
                        return true; 
                    }
                    </script>
            </div>
            <!-- <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Transaksi
                </button>
                <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div> -->
        </form> <!-- Tutup form utama di sini -->
    </div>
</div>