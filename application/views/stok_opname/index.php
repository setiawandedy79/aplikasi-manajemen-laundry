<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-clipboard-check me-2"></i> Stok Opname Chemical</h5>
        <a href="<?= base_url('stok_opname/add') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Opname Baru
        </a>
    </div>
    <div class="content-area">

        <!-- ✅ Form Filter & Tombol Print -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body py-3">
                <form method="get" action="<?= base_url('stok_opname/index') ?>" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control form-control-sm" value="<?= $dari ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control form-control-sm" value="<?= $sampai ?>" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <!-- ✅ Tombol Print (Membuka Tab Baru) -->
                        <a href="<?= base_url('stok_opname/print_opname?dari='.$dari.'&sampai='.$sampai) ?>" target="_blank" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-print me-1"></i> Print Laporan
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('stok_opname') ?>" class="btn btn-secondary btn-sm w-100">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alert Success (Kode lama Anda tetap di sini) -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-history me-2"></i> Riwayat Stok Opname
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th width="120">Tanggal</th>
                                <th>Nama Chemical</th>
                                <th width="120">Stok Sistem</th>
                                <th width="120">Stok Fisik</th>
                                <th width="120">Selisih</th>
                                <th>Keterangan</th>
                                <th>User</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = isset($no) ? $no : 1;
                            if (!empty($opname)):
                                foreach ($opname as $row):
                                    // Warna selisih
                                    if ($row->selisih > 0) {
                                        $selisih_class = 'text-success fw-bold';
                                        $selisih_icon  = '▲';
                                    } elseif ($row->selisih < 0) {
                                        $selisih_class = 'text-danger fw-bold';
                                        $selisih_icon  = '▼';
                                    } else {
                                        $selisih_class = 'text-secondary';
                                        $selisih_icon  = '=';
                                    }
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td class="fw-bold"><?= $row->nama_sabun ?></td>
                                <td class="text-center"><?= number_format($row->stok_sistem, 2) ?></td>
                                <td class="text-center"><?= number_format($row->stok_fisik, 2) ?></td>
                                <td class="text-center <?= $selisih_class ?>">
                                    <?= $selisih_icon ?> <?= number_format(abs($row->selisih), 2) ?>
                                </td>
                                <td><?= $row->keterangan ?: '-' ?></td>
                                <td><?= $row->nama_lengkap ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('stok_opname/delete/'.$row->id) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin hapus? Stok akan dikembalikan ke nilai sebelum opname.')"
                                       title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            else: 
                            ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox me-2"></i> Belum ada data stok opname
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if (!empty($links)): ?>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Menampilkan maksimal 50 data per halaman</small>
                <?= $links ?>
            </div>
        <?php endif; ?>

    </div>
</div>