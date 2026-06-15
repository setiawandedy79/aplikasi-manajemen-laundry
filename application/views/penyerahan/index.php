<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-hand-holding me-2"></i> Penyerahan Laundry</h5>
    </div>
    <div class="content-area">
        
        <!-- 🔍 FORM PENCARIAN -->
                <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body py-3">
                    <form method="get" action="<?= base_url('penyerahan') ?>" id="formCari" class="row g-2 align-items-center">
                        <div class="col-md-6 col-12">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="keyword" id="searchInput" class="form-control" 
                                       placeholder="Ketik min. 3 karakter (No. Transaksi, Pengirim, Unit...)" 
                                       value="<?= isset($keyword) ? $keyword : '' ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                            <a href="<?= base_url('penyerahan') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        <!-- Script untuk Live Search (Otomatis cari saat 3 karakter) -->
        <script>
        $(document).ready(function() {
            var searchTimeout;
            
            $('#searchInput').on('keyup', function() {
                var val = $(this).val();
                
                // Jika karakter >= 3, otomatis submit form
                if (val.length >= 3) {
                    clearTimeout(searchTimeout); // Hapus timer sebelumnya agar tidak spam
                    
                    // Beri jeda 600ms (debounce) sebelum submit, agar server tidak berat
                    searchTimeout = setTimeout(function() {
                        $('#formCari').submit();
                    }, 600); 
                }
            });
        });
        </script>>

        <!-- Pesan Sukses -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Transaksi</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Unit</th>
                                <!-- <th>Penerima</th> -->
                                <th class="text-center" width="100">Jumlah Awal</th>
                                <th class="text-center" width="130">Jumlah Diserahkan</th>
                                <th class="text-center">Status Serah</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($transaksi as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong class="text-primary"><?= $row->no_transaksi ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td><?= $row->nama_pelanggan ?></td>
                                <!-- <td><?= $row->nama_penerima ?></td> -->
                                <td class="text-center fw-bold"><?= isset($row->total_jumlah_awal) ? $row->total_jumlah_awal : 0 ?></td>
                                <td class="text-center fw-bold text-primary"><?= isset($row->total_jumlah_diserahkan) ? $row->total_jumlah_diserahkan : 0 ?></td>
                                <td>
                                    <?php if ($row->status_serah == 'diserahkan'): ?>
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Diserahkan</span>
                                        <br><small class="text-muted">Oleh: <?= isset($row->nama_pengambil) ? $row->nama_pengambil : '-' ?></small>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                        <!-- <a href="<?= base_url('penyerahan/form/'.$row->id) ?>" class="btn btn-warning btn-sm me-1" title="Edit Jumlah Diserahkan">
                                            <i class="fas fa-edit"></i>
                                        </a> -->
                                    <?php if ($row->status_serah == 'belum'): ?>
                                        <a href="<?= base_url('penyerahan/form/'.$row->id) ?>" class="btn btn-warning btn-sm me-1" title="Edit Jumlah Diserahkan">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('penyerahan/form/'.$row->id) ?>" class="btn btn-primary btn-sm" title="Proses Serahkan">
                                            <i class="fas fa-hand-holding"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('penyerahan/rincian/'.$row->id) ?>" class="btn btn-info btn-sm text-white">
                                            <i class="fas fa-list-alt me-1"></i> Rincian Linen
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- Jika Data Kosong -->
                            <?php if (empty($transaksi)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <?php if (!empty($keyword)): ?>
                                        Data tidak ditemukan untuk kata kunci: <strong><?= $keyword ?></strong>
                                    <?php else: ?>
                                        Belum ada data transaksi yang perlu diserahterimakan
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>