<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-flask me-2"></i> <?= isset($title) ? $title : 'Pemakaian Sabun' ?></h5>
        <a href="<?= base_url('pemakaian/add') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Input Pemakaian
        </a>
    </div>
    <div class="content-area">
        
        <!-- Alert Success -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Alert Error -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-history me-2"></i> Riwayat Pemakaian
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th>Tanggal</th>
                                <th>Chemical</th>
                                <th width="120">Jumlah</th>
                                <th width="100">Shift</th>
                                <th>Keterangan</th>
                                <th>User</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // ✅ FIX 1: Penomoran otomatis berlanjut (51, 52, dst) saat pindah halaman
                            $no = isset($no) ? $no : 1; 
                            
                            // ✅ FIX 2: Memastikan semua blok if dan foreach ditutup dengan benar
                            if (!empty($pemakaian)): 
                                foreach ($pemakaian as $row): 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td class="text-left"><?= $row->nama_sabun ?></td>
                                <td class="text-center"><?= $row->jumlah ?> <?= $row->nama_satuan ?></td>
                                <td class="text-center">
                                    <?php 
                                        $shift_val = isset($row->shift) ? trim(strtolower($row->shift)) : '';
                                        $shift_badge = 'bg-secondary';
                                        if ($shift_val == 'pagi') $shift_badge = 'bg-warning text-dark';
                                        elseif ($shift_val == 'siang') $shift_badge = 'bg-info';
                                        elseif ($shift_val == 'sore') $shift_badge = 'bg-secondary';
                                        elseif ($shift_val == 'malam') $shift_badge = 'bg-dark text-white';
                                    ?>
                                    <span class="badge <?= $shift_badge ?>"><?= ucfirst($shift_val ?: '-') ?></span>
                                </td>
                                <td><?= isset($row->keterangan) ? $row->keterangan : '-' ?></td>
                                <td><?= isset($row->nama_lengkap) ? $row->nama_lengkap : '-' ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('pemakaian/edit/'.$row->id) ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('pemakaian/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox me-2"></i> Belum ada data pemakaian
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ✅ FIX 3: Menampilkan Link Pagination di bawah tabel -->
        <?php if (!empty($links)): ?>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Menampilkan maksimal 50 data per halaman</small>
                <?= $links ?>
            </div>
        <?php endif; ?>

    </div>
</div>