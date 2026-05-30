<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-truck-loading me-2"></i> Mutasi Masuk Sabun</h5>
        <span class="text-muted"><?= $this->session->userdata('nama_lengkap') ?></span>
    </div>
    <div class="content-area">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Riwayat Masuk Sabun</h6>
                <a href="<?= base_url('mutasi/add') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Input Mutasi Masuk
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Nama Sabun</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">User</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($mutasi as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td><strong><?= $row->nama_sabun ?></strong></td>
                                <td class="text-center fw-bold text-success">+ <?= $row->jumlah ?></td>
                                <td><?= $row->nama_satuan ?></td>
                                <td><?= $row->keterangan ?: '-' ?></td>
                                <td><?= $row->nama_lengkap ?: '-' ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('mutasi/edit/'.$row->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('mutasi/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data? Stok akan dikurangi.')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($mutasi)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data mutasi masuk</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>