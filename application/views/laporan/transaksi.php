<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-file-invoice me-2"></i> Laporan Transaksi Laundry</h5>
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
                <h6 class="text-center mb-3">LAPORAN TRANSAKSI LAUNDRY</h6>
                <p class="text-center text-muted small">Periode: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?></p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="50">No</th>
                                <th class="text-center"> No Transaksi</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center"> Pelanggan</th>
                                <th class="text-center"> Pengirim</th>
                                <th class="text-center"> Penerima</th>
                                <th class="text-center"> Shift</th>
                                <th class="text-center"> User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><strong class="text-primary"><?= $row->no_transaksi ?></strong></td>
                                <td class="text-center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td><?= $row->nama_pelanggan ?? '-' ?></td>
                                <td><?= $row->nama_pengirim ?></td>
                                <td><?= $row->nama_penerima ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $row->shift == 'pagi' ? 'badge-shift-pagi' : 'badge-shift-siang' ?>"><?= ucfirst($row->shift) ?></span>
                                </td>
                                <td><?= $row->nama_lengkap ?: '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($data)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-3">Tidak ada data</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <td colspan="2" class="text-end fw-bold">TOTAL TRANSAKSI</td>
                                <td colspan="6" class="fw-bold"><?= count($data) ?> Transaksi</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>