<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-user-cog me-2"></i> <?= isset($row) ? 'Edit' : 'Tambah' ?> User</h5>
    </div>
    <div class="content-area">
        
        <!-- Tampilkan Error Validasi -->
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= validation_errors() ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card" style="max-width: 600px;">
            <div class="card-body">
                <form action="<?= base_url(isset($row) ? 'users/update/'.$row->id : 'users/save') ?>" method="post">
                    
                    <div class="mb-3">
                        <label class="form-label fw-500">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" 
                               value="<?= set_value('username', $row->username ?? '') ?>" 
                               placeholder="Min. 4 karakter" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500">Password 
                            <?= isset($row) ? '<small class="text-muted">(kosongkan jika tidak diubah)</small>' : '<span class="text-danger">*</span>' ?>
                        </label>
                        <input type="password" name="password" class="form-control" 
                               placeholder="<?= isset($row) ? 'Min. 6 karakter untuk mengubah' : 'Min. 6 karakter' ?>" 
                               <?= !isset($row) ? 'required' : '' ?>>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" 
                               value="<?= set_value('nama_lengkap', $row->nama_lengkap ?? '') ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-500">Hak Akses (Role) <span class="text-danger">*</span></label>
                        <select name="role" class="form-select">
                            <option value="admin" <?= (set_value('role', $row->role ?? '') == 'admin') ? 'selected' : '' ?>>
                                👑 Admin (Full Akses)
                            </option>
                            <option value="kasir" <?= (set_value('role', $row->role ?? '') == 'kasir') ? 'selected' : '' ?>>
                                💰 Kasir (Transaksi & Laporan)
                            </option>
                            <option value="operator" <?= (set_value('role', $row->role ?? '') == 'operator') ? 'selected' : '' ?>>
                                ⚙️ Operator (Pemakaian & Mutasi Chemical)
                            </option>
                        </select>
                        <small class="text-muted">
                            <ul class="mt-1 mb-0 ps-3">
                                <li><strong>Admin:</strong> Akses semua menu</li>
                                <li><strong>Kasir:</strong> Transaksi, Pelanggan, Laporan</li>
                                <li><strong>Operator:</strong> Pemakaian Chemical, Mutasi, Laporan</li>
                            </ul>
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                        <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>