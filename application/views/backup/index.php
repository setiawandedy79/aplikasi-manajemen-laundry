<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-database me-2"></i> Backup Database</h5>
    </div>
    <div class="content-area">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Info Database -->
        <div class="row">
            <div class="col-md-4">
                <div class="card border-primary mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-database fa-3x text-primary mb-3"></i>
                        <h6 class="text-muted">Nama Database</h6>
                        <h4 class="fw-bold"><?= $db_info->db_name ?? '-' ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-hdd fa-3x text-success mb-3"></i>
                        <h6 class="text-muted">Ukuran Database</h6>
                        <h4 class="fw-bold"><?= $db_info->size_mb ?? 0 ?> MB</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-info mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-table fa-3x text-info mb-3"></i>
                        <h6 class="text-muted">Total Tabel</h6>
                        <h4 class="fw-bold"><?= $db_info->total_tabel ?? 0 ?> Tabel</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Backup -->
        <div class="card mb-3">
            <div class="card-body text-center py-4">
                <h5 class="mb-3">Buat Backup Database Sekarang</h5>
                <p class="text-muted mb-4">
                    File akan dikompresi dengan format <strong>.sql.gz</strong> (5-10x lebih kecil dari .sql biasa).
                    <br>Estimasi waktu: <strong><?= ceil(($db_info->size_mb ?? 10) / 5) ?> - <?= ceil(($db_info->size_mb ?? 10) / 2) ?> detik</strong>
                </p>
                
                <form action="<?= base_url('backup/proses') ?>" method="post" id="formBackup">
                    <button type="submit" class="btn btn-primary btn-lg px-5" id="btnBackup" onclick="showLoading()">
                        <i class="fas fa-download me-2"></i> Backup Database Sekarang
                    </button>
                </form>
            </div>
        </div>

        <!-- Riwayat Backup -->
        <div class="card">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-history me-2"></i> Riwayat Backup
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Tanggal Dibuat</th>
                                <th width="180" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($backup_files)): ?>
                                <?php $no = 1; foreach ($backup_files as $file): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <i class="fas fa-file-archive text-warning me-2"></i>
                                        <strong><?= $file['name'] ?></strong>
                                    </td>
                                    <td><?= $file['size'] ?></td>
                                    <td><?= $file['date'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('backup/download/'.$file['name']) ?>" class="btn btn-success btn-sm">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <a href="<?= base_url('backup/hapus/'.$file['name']) ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus file backup ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox me-2"></i> Belum ada file backup
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

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:9999; justify-content:center; align-items:center;">
    <div class="text-center text-white">
        <div class="spinner-border text-light" style="width: 4rem; height: 4rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h4 class="mt-3">⏳ Sedang Membackup Database...</h4>
        <p class="text-muted">Mohon tunggu, jangan tutup halaman ini</p>
        <div id="timer" class="fs-5">00:00</div>
    </div>
</div>

<script>
let seconds = 0;
let timerInterval;

function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
    document.getElementById('btnBackup').disabled = true;
    
    // Timer
    seconds = 0;
    timerInterval = setInterval(function() {
        seconds++;
        const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
        const secs = String(seconds % 60).padStart(2, '0');
        document.getElementById('timer').textContent = mins + ':' + secs;
    }, 1000);
}

// Auto-hide loading jika halaman selesai load (saat kembali dari proses)
window.addEventListener('load', function() {
    clearInterval(timerInterval);
    document.getElementById('loadingOverlay').style.display = 'none';
});
</script>