<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-flask me-2"></i> Laporan Stok Chemical</h5>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print me-1"></i> Print
        </button>
    </div>
    <div class="content-area">
        
        <!-- Form Filter Tanggal -->
        <div class="card mb-3 border-0 shadow-sm no-print">
            <div class="card-body py-3">
                <form method="get" action="<?= base_url('laporan/stok_sabun') ?>" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control" value="<?= $dari ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="<?= $sampai ?>" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Tampilkan
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('laporan/stok_sabun') ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Stok Chemical Periode: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="40">No</th>
                                <th width="310">Nama Chemical</th>
                                <th width="110">Stok Awal<br><small class="fw-normal">(Periode)</small></th>
                                <th width="110">Mutasi Masuk</th>
                                <th width="110">Pemakaian</th>
                                <th width="110">Stok Akhir<br><small class="fw-normal">(Periode)</small></th>
                                <th width="80">Satuan</th>
                                <th width="100">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (!empty($sabun)): 
                                foreach ($sabun as $row): 
                                    
                                    // 1. Hitung Stok Sebelum Periode (Untuk menentukan Stok Awal Periode)
                                    $mutasi_sebelum = $this->db->select('COALESCE(SUM(jumlah), 0) as total')
                                        ->where('sabun_id', $row->id)
                                        ->where('tanggal <', $dari)
                                        ->get('mutasi_sabun_masuk')->row()->total;

                                    $pakai_sebelum = $this->db->select('COALESCE(SUM(jumlah), 0) as total')
                                        ->where('sabun_id', $row->id)
                                        ->where('tanggal <', $dari)
                                        ->get('pemakaian_sabun')->row()->total;

                                    $stok_awal_periode = $row->stok_awal + $mutasi_sebelum - $pakai_sebelum;

                                    // 2. Hitung Mutasi & Pemakaian DALAM Periode (Dari - Sampai)
                                    $mutasi_masuk = $this->db->select('COALESCE(SUM(jumlah), 0) as total')
                                        ->where('sabun_id', $row->id)
                                        ->where('tanggal >=', $dari)
                                        ->where('tanggal <=', $sampai)
                                        ->get('mutasi_sabun_masuk')->row()->total;

                                    $total_pemakaian = $this->db->select('COALESCE(SUM(jumlah), 0) as total')
                                        ->where('sabun_id', $row->id)
                                        ->where('tanggal >=', $dari)
                                        ->where('tanggal <=', $sampai)
                                        ->get('pemakaian_sabun')->row()->total;

                                    // 3. Hitung Stok Akhir Periode
                                    $stok_akhir_periode = $stok_awal_periode + $mutasi_masuk - $total_pemakaian;
                                    
                                    // Tentukan status stok
                                    if ($stok_akhir_periode <= 0) {
                                        $status = '<span class="badge bg-danger">Habis</span>';
                                    } elseif ($stok_akhir_periode < 1000) {
                                        $status = '<span class="badge bg-warning text-dark">Menipis</span>';
                                    } else {
                                        $status = '<span class="badge bg-success">Tersedia</span>';
                                    }
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-left"><?= $row->nama_sabun ?></td>
                                <td class="text-center"><?= number_format($stok_awal_periode, 2) ?></td>
                                <td class="text-center text-success">+ <?= number_format($mutasi_masuk, 2) ?></td>
                                <td class="text-center text-danger">- <?= number_format($total_pemakaian, 2) ?></td>
                                <td class="text-center fw-bold"><?= number_format($stok_akhir_periode, 2) ?></td>
                                <td class="text-center"><?= $row->nama_satuan ?? 'ML' ?></td>
                                <td class="text-center"><?= $status ?></td>
                            </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox me-2"></i>Tidak ada data chemical
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .topbar, .sidebar, .btn, .no-print { display: none !important; }
    .main-content { margin: 0 !important; padding: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>