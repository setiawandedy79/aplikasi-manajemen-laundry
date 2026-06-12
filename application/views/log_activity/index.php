<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-history me-2"></i> Log Aktivitas Sistem</h5>
           
        <!-- ✅ TOMBOL HAPUS LOG LAMA -->
        <a href="<?= base_url('log_activity/cleanup') ?>" 
           class="btn btn-danger btn-sm" 
           onclick="return confirm('PERINGATAN: Anda akan menghapus semua data log yang berumur lebih dari 1 tahun. Tindakan ini tidak dapat dibatalkan. Lanjutkan?')">
            <i class="fas fa-trash-alt me-1"></i> Hapus Log > 1 Tahun
        </a>
    </div>
    <div class="content-area">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center"width="50">No</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">User</th>
                                <th class="text-center">Module</th>
                                <th class="text-center">Aksi</th>
                                <th class="text-center">Record ID</th>
                                <th class="text-center">Detail Data (JSON)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($logs as $log): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($log->created_at)) ?></td>
                                <td>
                                    <strong><?= isset($log->nama_user) ? $log->nama_user : 'System' ?></strong><br>
                                    <small class="text-muted"><?= isset($log->ip_address) ? $log->ip_address : '-' ?></small>
                                </td>
                                <td><span class="badge bg-secondary"><?= strtoupper($log->module) ?></span></td>
                                <td>
                                    <?php if ($log->action == 'UPDATE'): ?>
                                        <span class="badge bg-warning text-dark">EDIT</span>
                                    <?php elseif ($log->action == 'DELETE'): ?>
                                        <span class="badge bg-danger">HAPUS</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">TAMBAH</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= $log->record_id ?></td>
                                <td>
                                    <!-- Tombol Modal untuk melihat detail JSON -->
                                    <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalLog<?= $log->id ?>">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </button>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="modalLog<?= $log->id ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Log #<?= $log->id ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php if ($log->old_data): ?>
                                                        <h6>Data Lama (Before):</h6>
                                                        <pre class="bg-light p-2 border rounded" style="max-height: 200px; overflow-y: auto;"><?= htmlspecialchars($log->old_data) ?></pre>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($log->new_data): ?>
                                                        <h6 class="mt-3">Data Baru (After):</h6>
                                                        <pre class="bg-light p-2 border rounded" style="max-height: 200px; overflow-y: auto;"><?= htmlspecialchars($log->new_data) ?></pre>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>