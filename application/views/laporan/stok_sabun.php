<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-boxes me-2"></i> Laporan Stok Chemical</h5>
    </div>
    <div class="content-area">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Stok Awal, Pemakaian & Stok Akhir Chemical</h6>
                <button onclick="window.print()" class="btn btn-secondary btn-sm"><i class="fas fa-print me-1"></i> Print</button>
            </div>
            <div class="card-body">
                <h6 class="text-center mb-3">LAPORAN STOK CHEMICAL</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th class="text-center">Nama Chemical</th>
                                <th class="text-center">Stok Awal</th>
                                <th class="text-center">Total Masuk</th>
                                <th class="text-center">Total Pemakaian</th>
                                <th class="text-center">Stok Akhir</th>
                                <th>Satuan</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($sabun as $row): ?>
                            <?php
                            $masuk = $this->db->select('COALESCE(SUM(jumlah),0) as total')
                                ->where('sabun_id', $row->id)
                                ->get('mutasi_sabun_masuk')->row()->total;
                            $pemakaian = $this->db->select('COALESCE(SUM(jumlah),0) as total')
                                ->where('sabun_id', $row->id)
                                ->get('pemakaian_sabun')->row()->total;
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-left"><strong><?= $row->nama_sabun ?></strong></td>
                                <td class="text-center"><?= $row->stok_awal ?></td>
                                <td class="text-center text-success">+ <?= $masuk ?></td>
                                <td class="text-center text-danger">- <?= $pemakaian ?></td>
                                <td class="text-center fw-bold"><?= $row->stok_akhir ?></td>
                                <td><?= $row->nama_satuan ?></td>
                                <td class="text-center">
                                    <?php if ($row->stok_akhir <= 0): ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php elseif ($row->stok_akhir <= 5): ?>
                                        <span class="badge bg-warning text-dark">Menipis</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($sabun)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-3">Tidak ada data</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>