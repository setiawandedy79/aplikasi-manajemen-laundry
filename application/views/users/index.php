<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-user-cog me-2"></i> Master User</h5>
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
                <h6 class="mb-0 fw-bold">Data User</h6>
                <a href="<?= base_url('users/add') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah User
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Role</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($users as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $row->username ?></strong></td>
                                <td><?= $row->nama_lengkap ?></td>
                                <td><span class="badge <?= $row->role == 'admin' ? 'bg-danger' : 'bg-primary' ?>"><?= ucfirst($row->role) ?></span></td>
                                <td class="text-center">
                                    <a href="<?= base_url('users/edit/'.$row->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('users/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')"><i class="fas fa-trash"></i></a>
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