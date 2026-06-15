<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-users me-2"></i> Master User</h5>
        <?php if (can_add('users')): ?>
            <a href="<?= base_url('users/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah User
            </a>
        <?php endif; ?>
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Unit</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($users as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-semibold"><?= isset($row->nama_lengkap) ? $row->nama_lengkap : '-' ?></td>
                                <td><?= isset($row->username) ? $row->username : '-' ?></td>
                                <td><span class="badge bg-info"><?= isset($row->role) ? ucfirst($row->role) : '-' ?></span></td>
                                <td>
                                    <?= isset($row->nama_pelanggan) ? '<span class="badge bg-secondary">'.$row->nama_pelanggan.'</span>' : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td class="text-center">
                                    <?php if (can_edit('users')): ?>
                                        <a href="<?= base_url('users/edit/'.$row->id) ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (can_delete('users') && $row->id != $this->session->userdata('user_id')): ?>
                                        <a href="<?= base_url('users/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus user ini?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data user</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>