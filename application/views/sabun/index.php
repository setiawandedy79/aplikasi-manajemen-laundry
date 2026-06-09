<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-soap me-2"></i> Master Sabun</h5>
        <span class="text-muted"><?= $this->session->userdata('nama_lengkap') ?></span>
    </div>
    <div class="content-area">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Data Sabun</h6>
                <a href="<?= base_url('sabun/add') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Sabun</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Supplier</th> <!-- ✅ TAMBAH -->
                                <th class="text-center">Stok Awal</th>
                                <th class="text-center">Stok Akhir</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($sabun as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-left"><strong><?= $row->nama_sabun ?></strong></td>
                                <td><?= $row->nama_satuan ?></td>
                                <td><?= isset($row->nama_supplier) ? $row->nama_supplier : '<span class="text-muted">-</span>' ?></td> <!-- ✅ TAMBAH -->
                                <td class="text-center"><?= $row->stok_awal ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $row->stok_akhir <= 0 ? 'bg-danger' : ($row->stok_akhir <= 5 ? 'bg-warning' : 'bg-success') ?>">
                                        <?= $row->stok_akhir ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('sabun/edit/'.$row->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('sabun/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($sabun)): ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>