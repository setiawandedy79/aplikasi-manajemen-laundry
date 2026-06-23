<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-clock me-2"></i> Laporan Pemakaian Chemical Per Shift</h5>
    </div>
    <div class="content-area">
        <div class="card">
            <div class="card-header">
                <form method="get" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control" value="<?= $dari ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="<?= $sampai ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-search me-1"></i> Filter</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" onclick="window.print()" class="btn btn-secondary btn-sm w-100"><i class="fas fa-print me-1"></i> Print</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <h6 class="text-center mb-3">LAPORAN PEMAKAIAN CHEMICAL PER SHIFT</h6>
                <p class="text-center text-muted small">Periode: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?></p>
                
                <?php 
                //  Hitung total dinamis per Shift & per Satuan
                $totals = [];
                if (!empty($data)) {
                    foreach ($data as $row) {
                        $key = $row->shift . '|' . $row->nama_satuan;
                        if (!isset($totals[$key])) {
                            $totals[$key] = ['shift' => $row->shift, 'satuan' => $row->nama_satuan, 'total' => 0];
                        }
                        $totals[$key]['total'] += $row->jumlah;
                    }
                    ksort($totals); // Urutkan: Pagi dulu, lalu Siang
                }
                ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th class="text-center" width="100">Tanggal</th>
                                <th class="text-center">Nama Chemical</th>
                                <th class="text-center" width="80">Jumlah</th>
                                <th class="text-center" width="80">Satuan</th>
                                <th class="text-center" width="80">Shift</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center" width="100">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1; 
                            if (!empty($data)): 
                                foreach ($data as $row): 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td class="text-left"><strong><?= $row->nama_sabun ?></strong></td>
                                <td class="text-right"><?= $row->jumlah ?></td>
                                <td class="text-center"><?= $row->nama_satuan ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $row->shift == 'pagi' ? 'badge-shift-pagi' : 'badge-shift-siang' ?>"><?= ucfirst($row->shift) ?></span>
                                </td>
                                <td class="text-center"><?= $row->keterangan ?: '-' ?></td>
                                <td class="text-center"><?= $row->nama_lengkap ?: '-' ?></td>
                            </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                            <tr><td colspan="8" class="text-center text-muted py-3">Tidak ada data</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <?php if (!empty($totals)): foreach ($totals as $t): ?>
                            <tr class="<?= $t['shift'] == 'pagi' ? 'table-warning' : 'table-primary' ?>">
                                <td colspan="3" class="text-end fw-bold">TOTAL SHIFT <?= strtoupper($t['shift']) ?></td>
                                <td class="text-center fw-bold"><?= $t['total'] ?></td>
                                <td class="text-center fw-bold"><?= $t['satuan'] ?></td>
                                <td colspan="3"></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="8" class="text-center text-muted py-2">Belum ada data untuk dihitung</td></tr>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>