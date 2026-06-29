<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-user-cog me-2"></i> <?= $title ?></h5>
    </div>
    <div class="content-area">
        <form action="<?= base_url('users/save') ?>" method="post">
            <input type="hidden" name="id" value="<?= isset($row->id) ? $row->id : '' ?>">
            
            <!-- Info Dasar User -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-user me-2"></i> Informasi User
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" 
                                   value="<?= isset($row->nama_lengkap) ? $row->nama_lengkap : '' ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" 
                                   value="<?= isset($row->username) ? $row->username : '' ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <?= $row ? '(Kosongkan jika tidak ingin mengubah)' : '<span class="text-danger">*</span>' ?></label>
                            <input type="password" name="password" class="form-control" 
                                   <?= $row ? '' : 'required' ?>>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= (isset($row->role) && $row->role == 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="kasir" <?= (isset($row->role) && $row->role == 'kasir') ? 'selected' : '' ?>>Kasir</option>
                                <option value="operator" <?= (isset($row->role) && $row->role == 'operator') ? 'selected' : '' ?>>Operator</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Unit / Ruangan (Opsional)</label>
                            <select name="pelanggan_id" class="form-select">
                                <option value="">-- Tidak Ada / Admin Pusat --</option>
                                <?php if (!empty($pelanggan_list)): ?>
                                    <?php foreach ($pelanggan_list as $p): ?>
                                        <option value="<?= $p->id ?>" <?= (isset($row->pelanggan_id) && $row->pelanggan_id == $p->id) ? 'selected' : '' ?>>
                                            <?= isset($p->nama) ? $p->nama : '' ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">Kosongkan jika user ini adalah Admin Pusat atau tidak terikat satu unit tertentu.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hak Akses Menu -->
            <div class="card mb-3">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="fas fa-shield-alt me-2"></i> Hak Akses Menu
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 200px;">Menu</th>
                                    <th class="text-center" style="width: 100px;">View</th>
                                    <th class="text-center" style="width: 100px;">Tambah</th>
                                    <th class="text-center" style="width: 100px;">Edit</th>
                                    <th class="text-center" style="width: 100px;">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $menus = array(
                                    'dashboard' => 'Dashboard',
                                    'transaksi' => 'Transaksi',
                                    'penyerahan' => 'Penyerahan',
                                    'pakaian' => 'Master Linen',
                                    'pelanggan' => 'Master Unit',
                                    'sabun' => 'Master Sabun',
                                    'pemakaian' => 'Pemakaian Sabun',
                                    'mutasi' => 'Mutasi Stok',
                                    'laporan' => 'Laporan',
                                    'user' => 'Master User'
                                );
                                
                                $actions = array('view', 'add', 'edit', 'delete');
                                
                                // Decode permissions yang sudah ada
                                $current_perms = array();
                                if (isset($row->permissions) && !empty($row->permissions)) {
                                    $current_perms = is_string($row->permissions) ? json_decode($row->permissions, true) : $row->permissions;
                                }
                                
                                foreach ($menus as $menu_key => $menu_name): 
                                ?>
                                <tr>
                                    <td class="fw-semibold"><?= $menu_name ?></td>
                                    <?php foreach ($actions as $action): 
                                        $field_name = $menu_key . '_' . $action;
                                        $checked = isset($current_perms[$menu_key][$action]) && $current_perms[$menu_key][$action] == 1 ? 'checked' : '';
                                    ?>
                                    <td class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="<?= $field_name ?>" value="1" <?= $checked ?>
                                                   id="<?= $field_name ?>">
                                        </div>
                                    </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Centang hak akses yang diinginkan untuk setiap menu. User dengan role <strong>Admin</strong> otomatis memiliki semua hak akses.
                    </small>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i> Simpan
                </button>
                <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>