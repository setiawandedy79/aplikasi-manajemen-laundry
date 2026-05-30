<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-clock me-2"></i> Pemakaian Sabun Per Shift</h5>
        <span class="text-muted"><?= $this->session->userdata('nama_lengkap') ?></span>
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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Riwayat Pemakaian</h6>
                <a href="<?= base_url('pemakaian/add') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Input Pemakaian
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Sabun</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Shift</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">User</th>
                                <th class="text-center" width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pemakaian as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td><strong><?= $row->nama_sabun ?></strong></td>
                                <td class="text-center"><?= $row->jumlah ?> <?= $row->nama_satuan ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $row->shift == 'pagi' ? 'badge-shift-pagi' : 'badge-shift-siang' ?>"><?= ucfirst($row->shift) ?></span>
                                </td>
                                <td><?= $row->keterangan ?: '-' ?></td>
                                <td><?= $row->nama_lengkap ?: '-' ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('pemakaian/edit/'.$row->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('pemakaian/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data? Stok akan dikembalikan.')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($pemakaian)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data pemakaian</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>