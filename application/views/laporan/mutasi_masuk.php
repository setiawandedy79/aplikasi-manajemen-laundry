<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-truck-loading me-2"></i> Laporan Mutasi Masuk Sabun</h5>
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
                <h6 class="text-center mb-3">LAPORAN REKAPITULASI MUTASI MASUK SABUN</h6>
                <p class="text-center text-muted small">Periode: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?></p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th class="text-center" width="50">Tanggal</th>
                                <th class="text-center" width="250">Nama Sabun</th>
                                <th class="text-center" width="50">Jumlah</th>
                                <th class="text-center" width="50">Satuan</th>
                                <th class="text-center" width="50">Keterangan</th>
                                <th class="text-center" width="50">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; $no = 1; foreach ($data as $row): $total += $row->jumlah; ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td><strong><?= $row->nama_sabun ?></strong></td>
                                <td class="text-center"><?= $row->jumlah ?></td>
                                <td><?= $row->nama_satuan ?></td>
                                <td><?= $row->keterangan ?: '-' ?></td>
                                <td><?= $row->nama_lengkap ?: '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($data)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-3">Tidak ada data</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <td colspan="3" class="text-end fw-bold">TOTAL</td>
                                <td class="text-center fw-bold"><?= $total ?></td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>