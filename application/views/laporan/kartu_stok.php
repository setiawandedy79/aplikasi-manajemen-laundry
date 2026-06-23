<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-file-invoice me-2"></i> <?= $title ?></h5>
        <a href="<?= base_url('laporan/print_kartu_stok?dari='.$dari.'&sampai='.$sampai) ?>" target="_blank" class="btn btn-success">
            <i class="fas fa-print me-1"></i> Cetak Laporan
        </a>
    </div>
    <div class="content-area">

        <!-- Filter Tanggal -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body py-3">
                <form method="get" action="<?= base_url('laporan/kartu_stok') ?>" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control form-control-sm" value="<?= $dari ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control form-control-sm" value="<?= $sampai ?>" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-filter me-1"></i> Tampilkan</button>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url('laporan/kartu_stok') ?>" class="btn btn-secondary btn-sm w-100"><i class="fas fa-redo me-1"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loop untuk setiap Chemical -->
        <?php if (!empty($sabun_list)): ?>
            <?php foreach ($sabun_list as $sabun): 
                // 1. Hitung Saldo Awal Periode
                $saldo = $this->Laporan_model->hitung_saldo_awal($sabun->id, $dari);
                $saldo_awal = $saldo;
                
                // 2. Ambil Transaksi
                $transaksi = $this->Laporan_model->get_transaksi_stok($sabun->id, $dari, $sampai);
            ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <strong><i class="fas fa-flask me-2"></i> <?= $sabun->nama_sabun ?></strong>
                    <span class="badge bg-light text-dark">Satuan: <?= $sabun->nama_satuan ?? 'ML' ?></span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th class="text-center" width="100">Tanggal</th>
                                    <th class="text-center" width="200">Keterangan</th>
                                    <th class="text-center" width="120">Masuk</th>
                                    <th class="text-center" width="120">Keluar</th>
                                    <th class="text-center" width="130">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris Saldo Awal -->
                                <tr class="bg-light fw-bold">
                                    <td class="text-center">-</td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($dari)) ?></td>
                                    <td class="text-center"><i>Saldo Awal Periode</i></td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center"><?= number_format($saldo_awal, 2) ?></td>
                                </tr>

                                <!-- Baris Transaksi -->
                                <?php 
                                $no = 1;
                                if (!empty($transaksi)):
                                    foreach ($transaksi as $t):
                                        $saldo = $saldo + (float)$t->masuk - (float)$t->keluar;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($t->tanggal)) ?></td>
                                    <td class="text-left"><?= $t->keterangan ?></td>
                                    <td class="text-center text-success">
                                        <?= $t->masuk > 0 ? '+ ' . number_format($t->masuk, 2) : '-' ?>
                                    </td>
                                    <td class="text-center text-danger">
                                        <?= $t->keluar > 0 ? '- ' . number_format($t->keluar, 2) : '-' ?>
                                    </td>
                                    <td class="text-center fw-bold"><?= number_format($saldo, 2) ?></td>
                                </tr>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-2">Tidak ada transaksi pada periode ini</td>
                                </tr>
                                <?php endif; ?>

                                <!-- Baris Saldo Akhir -->
                                <tr class="table-warning fw-bold">
                                    <td colspan="4" class="text-end">Sisa Stok Akhir Periode:</td>
                                    <td colspan="2" class="text-center fs-5"><?= number_format($saldo, 2) ?> <?= $sabun->nama_satuan ?? 'ML' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning">Tidak ada data chemical.</div>
        <?php endif; ?>

    </div>
</div>