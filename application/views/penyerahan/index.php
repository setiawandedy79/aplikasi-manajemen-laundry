<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-hand-holding me-2"></i> Penyerahan Laundry</h5>
    </div>
    <div class="content-area">
        
        <!-- Alert Success -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Form Pencarian dengan Live Search -->
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

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-list me-2"></i> Data Penyerahan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th>No Transaksi</th>
                                <th width="120">Tanggal</th>
                                <th>Unit</th>
                                <th width="100">Jml Awal</th>
                                <th width="100">Jml Diserahkan</th>
                                <th width="180">Status Serah</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // ✅ FIX 1: Penomoran otomatis berlanjut (51, 52, dst) saat pindah halaman
                            $no = isset($no) ? $no : 1; 
                            
                            // ✅ FIX 2: Memastikan semua blok if dan foreach ditutup dengan benar
                            if (!empty($transaksi)): 
                                foreach ($transaksi as $row): 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="fw-bold"><?= $row->no_transaksi ?></td>
                                <td class="text-center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td class="text-left"><?= isset($row->nama_pelanggan) ? $row->nama_pelanggan : '-' ?></td>
                                <td class="text-center"><?= $row->total_jumlah_awal ? $row->total_jumlah_awal : 0 ?></td>
                                <td class="text-center"><?= $row->total_jumlah_diserahkan ? $row->total_jumlah_diserahkan : 0 ?></td>
                                <td class="text-center">
                                    <?php if ($row->status_serah == 'diserahkan'): ?>
                                        <span class="badge bg-success">Diserahkan</span>
                                        <br><small class="text-muted">Oleh: <?= $row->nama_pengambil ? $row->nama_pengambil : '-' ?></small>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row->status_serah == 'belum'): ?>
                                        <a href="<?= base_url('penyerahan/form/'.$row->id) ?>" class="btn btn-primary btn-sm" title="Serahkan">
                                            <i class="fas fa-hand-holding"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('penyerahan/rincian/'.$row->id) ?>" class="btn btn-info btn-sm" title="Rincian Linen">
                                        <i class="fas fa-list"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox me-2"></i> 
                                    <?= !empty($keyword) ? 'Data tidak ditemukan untuk kata kunci: <strong>'.$keyword.'</strong>' : 'Belum ada data transaksi yang perlu diserahterimakan' ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ✅ FIX 3: Menampilkan Link Pagination di bawah tabel -->
        <?php if (!empty($links)): ?>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Menampilkan maksimal 50 data per halaman</small>
                <?= $links ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Script untuk Live Search -->
<script>
$(document).ready(function() {
    var searchTimeout;
    $('#searchInput').on('keyup', function() {
        var val = $(this).val();
        if (val.length >= 3) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                $('#formCari').submit();
            }, 600); 
        }
    });
});
</script>