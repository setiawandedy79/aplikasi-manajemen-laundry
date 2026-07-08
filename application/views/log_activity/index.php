<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-history me-2"></i> Log Aktivitas Sistem</h5>
        <a href="<?= base_url('log_activity/cleanup') ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin ingin menghapus log yang berumur lebih dari 1 tahun?')">
            <i class="fas fa-broom me-1"></i> Hapus Log Lama (> 1 Tahun)
        </a>
    </div>
    <div class="content-area">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('info')): ?>
            <div class="alert alert-info alert-dismissible fade show">
                <i class="fas fa-info-circle me-2"></i><?= $this->session->flashdata('info') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-list me-2"></i> Riwayat Aktivitas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th width="150">Waktu</th>
                                <th width="200">User</th>
                                <th width="120">Module</th>
                                <th width="100">Aksi</th>
                                <th width="120">Record ID</th>
                                <th width="120">Detail Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = isset($no) ? $no : 1;
                            if (!empty($logs)):
                                foreach ($logs as $log):
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= date('d/m/Y H:i:s', strtotime($log->created_at)) ?></td>
                                
                                <!-- ✅ KOLOM USER: Nama Lengkap + Username + IP Address -->
                                <td>
                                    <strong><?= isset($log->user_nama) && $log->user_nama ? $log->user_nama : '<span class="text-muted">-</span>' ?></strong>
                                    <?php if (!empty($log->user_username)): ?>
                                        <!-- <br><small class="text-muted">@<?= $log->user_username ?></small> -->
                                    <?php endif; ?>
                                    <?php if (!empty($log->ip_address)): ?>
                                        <br><small class="text-muted"><i></i><?= $log->ip_address ?></small>
                                        <!-- <small class="text-muted"><i class="fas fa-network-wired me-1"></i><?= $log->ip_address ?></small> -->
                                    <?php endif; ?>
                                </td>
                                
                                <!-- ✅ KOLOM MODULE: Nama module (transaksi, penyerahan, dll) -->
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?= strtoupper($log->module) ?></span>
                                </td>
                                
                                <!-- ✅ KOLOM AKSI: INSERT/UPDATE/DELETE dengan warna -->
                                <td class="text-center">
                                    <?php
                                    $badge_class = 'bg-secondary';
                                    if ($log->action == 'INSERT') $badge_class = 'bg-success';
                                    elseif ($log->action == 'UPDATE') $badge_class = 'bg-warning text-dark';
                                    elseif ($log->action == 'DELETE') $badge_class = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= $log->action ?></span>
                                </td>
                                
                                <td class="text-center"><?= $log->record_id ?: '-' ?></td>
                                
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $log->id ?>">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Modal Detail Data -->
                            <div class="modal fade" id="modal<?= $log->id ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-file-code me-2"></i>Detail Log #<?= $log->id ?>
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Module:</strong> <?= strtoupper($log->module) ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Aksi:</strong> 
                                                    <span class="badge bg-warning text-dark"><?= $log->action ?></span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>User:</strong> <?= $log->user_nama ?: '-' ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>IP Address:</strong> <?= $log->ip_address ?: '-' ?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Waktu:</strong> <?= date('d/m/Y H:i:s', strtotime($log->created_at)) ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Record ID:</strong> <?= $log->record_id ?: '-' ?>
                                                </div>
                                            </div>
                                            
                                            <?php if (!empty($log->old_data)): ?>
                                                <h6 class="fw-bold text-danger mt-3"><i class="fas fa-arrow-left me-1"></i>Data Sebelum (Old Data):</h6>
                                                <pre class="bg-light p-3 rounded border" style="max-height: 200px; overflow-y: auto;"><?= json_encode(json_decode($log->old_data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></pre>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($log->new_data)): ?>
                                                <h6 class="fw-bold text-success mt-3"><i class="fas fa-arrow-right me-1"></i>Data Sesudah (New Data):</h6>
                                                <pre class="bg-light p-3 rounded border" style="max-height: 200px; overflow-y: auto;"><?= json_encode(json_decode($log->new_data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></pre>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox me-2"></i> Belum ada log aktivitas
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination Links -->
        <?php if (!empty($links)): ?>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Menampilkan maksimal 50 log per halaman</small>
                <?= $links ?>
            </div>
        <?php endif; ?>

    </div>
</div>