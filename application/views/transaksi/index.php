<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-file-invoice me-2"></i> Transaksi Laundry</h5>
        <a href="<?= base_url('transaksi/add') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Transaksi Baru
        </a>
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
                <form method="get" action="<?= base_url('transaksi') ?>" id="formCari" class="row g-2 align-items-center">
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
                        <a href="<?= base_url('transaksi') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-list me-2"></i> Data Transaksi
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
                                <th>Pengirim</th>
                                <th>Penerima</th>
                                <th width="100">Shift</th>
                                <th width="120">Jenis</th>
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
                                <td><?= isset($row->nama_pengirim) ? $row->nama_pengirim : '-' ?></td>
                                <td><?= isset($row->nama_penerima) ? $row->nama_penerima : '-' ?></td>
                                <td class="text-center">
                                    <?php 
                                        $shift_val = isset($row->shift) ? trim(strtolower($row->shift)) : '';
                                        $shift_badge = 'bg-secondary';
                                        $shift_display = '-';
                                        
                                        if ($shift_val == 'pagi') {
                                            $shift_badge = 'bg-warning text-dark';
                                            $shift_display = 'Pagi';
                                        } elseif ($shift_val == 'siang') {
                                            $shift_badge = 'bg-info';
                                            $shift_display = 'Siang';
                                        } elseif ($shift_val == 'sore') {
                                            $shift_badge = 'bg-secondary';
                                            $shift_display = 'Sore';
                                        } elseif ($shift_val == 'malam') {
                                            $shift_badge = 'bg-dark text-white';
                                            $shift_display = 'Malam';
                                        } elseif (!empty($shift_val)) {
                                            $shift_display = ucfirst($shift_val);
                                        }
                                    ?>
                                    <span class="badge <?= $shift_badge ?>"><?= $shift_display ?></span>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $j = isset($row->jenis_laundry) ? $row->jenis_laundry : 'Non Infeksius';
                                        $cls = ($j == 'Infeksius') ? 'bg-danger' : 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $cls ?>"><?= $j ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('transaksi/detail/'.$row->id) ?>" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
                                    <a href="<?= base_url('transaksi/edit/'.$row->id) ?>" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('transaksi/print/'.$row->id) ?>" class="btn btn-success btn-sm" title="Print" target="_blank"><i class="fas fa-print"></i></a>
                                    <a href="<?= base_url('transaksi/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus transaksi ini?')" title="Delete"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox me-2"></i> 
                                    <?= !empty($keyword) ? 'Data tidak ditemukan untuk kata kunci: <strong>'.$keyword.'</strong>' : 'Belum ada transaksi' ?>
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