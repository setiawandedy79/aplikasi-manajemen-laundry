<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-truck me-2"></i> Master Supplier</h5>
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
                <h6 class="mb-0 fw-bold">Data Supplier</h6>
                <a href="<?= base_url('supplier/add') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Tambah Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Kontak</th>
                                <th>Telepon</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($supplier as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= isset($row->nama_supplier) ? $row->nama_supplier : '' ?></strong></td>
                                <td><?= isset($row->kontak) ? $row->kontak : '-' ?></td>
                                <td><?= isset($row->telepon) ? $row->telepon : '-' ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('supplier/edit/'.$row->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('supplier/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($supplier)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data supplier</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>