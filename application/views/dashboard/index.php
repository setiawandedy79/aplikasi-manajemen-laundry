<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-home me-2"></i> Dashboard</h5>
        <div>
            <span class="text-muted me-3"><i class="fas fa-user me-1"></i> <?= $this->session->userdata('nama_lengkap') ?></span>
            <span class="badge bg-primary"><?= ucfirst($this->session->userdata('role')) ?></span>
        </div>
    </div>
    <div class="content-area">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card bg-gradient-primary">
                    <i class="fas fa-receipt stat-icon"></i>
                    <h3><?= $total_transaksi ?></h3>
                    <p>Total Transaksi</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-gradient-success">
                    <i class="fas fa-users stat-icon"></i>
                    <h3><?= $total_pelanggan ?></h3>
                    <p>Total Pelanggan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-gradient-warning">
                    <i class="fas fa-soap stat-icon"></i>
                    <h3><?= $total_sabun ?></h3>
                    <p>Jenis Sabun</p>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-clock me-2 text-primary"></i>Transaksi Terbaru</h6>
                        <a href="<?= base_url('transaksi/add') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Transaksi Baru
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-clock me-2 text-primary"></i>Transaksi Penyerahan</h6>
                        <a href="<?= base_url('penyerahan') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Transaksi Penyerahan
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                               <!--  <thead>
                                    <tr>
                                        <th class="text-center">No Transaksi</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Pengirim</th>
                                        <th class="text-center">Penerima</th>
                                        <th class="text-center">Shift</th>
                                    </tr>
                                </thead> -->
                                <!-- <tbody>
                                    <?php foreach ($transaksi_terbaru as $t): ?>
                                    <tr>
                                        <td><strong><?= $t->no_transaksi ?></strong></td>
                                        <td><?= date('d/m/Y', strtotime($t->tanggal)) ?></td>
                                        <td><?= $t->nama_pengirim ?></td>
                                        <td><?= $t->nama_penerima ?></td>
                                        <td>
                                            <span class="badge <?= $t->shift == 'pagi' ? 'badge-shift-pagi' : 'badge-shift-siang' ?>">
                                                <?= ucfirst($t->shift) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($transaksi_terbaru)): ?>
                                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                                    <?php endif; ?>
                                </tbody> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>