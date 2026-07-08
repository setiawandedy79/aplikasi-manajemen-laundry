<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-chart-bar me-2"></i> <?= $title ?></h5>
        <a href="<?= base_url('laporan/print_rekapitulasi_pencucian_pcs?tahun='.$tahun) ?>" target="_blank" class="btn btn-success">
            <i class="fas fa-print me-1"></i> Cetak Laporan
        </a>
    </div>
    <div class="content-area">

        <!-- Filter Tahun -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body py-3">
                <form method="get" action="<?= base_url('laporan/rekapitulasi_pencucian_pcs') ?>" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Tahun</label>
                        <select name="tahun" class="form-select form-select-sm" required>
                            <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                                <option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-filter me-1"></i> Tampilkan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Rekapitulasi -->
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold text-center">
                REKAPITULASI JUMLAH LINEN DICUCI (PCS)<br>
                <small>TAHUN <?= $tahun ?></small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="40" rowspan="2">NO</th>
                                <th width="200" rowspan="2">NAMA UNIT</th>
                                <th colspan="12">JUMLAH LINEN (PCS) PER BULAN</th>
                                <th width="100" rowspan="2">TOTAL (Pcs)</th>
                            </tr>
                            <tr>
                                <th>JAN</th><th>FEB</th><th>MAR</th><th>APR</th>
                                <th>MEI</th><th>JUN</th><th>JUL</th><th>AGU</th>
                                <th>SEP</th><th>OKT</th><th>NOV</th><th>DES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $grand_total_per_bulan = array_fill(1, 12, 0);
                            $grand_total_tahun = 0;
                            
                            if (!empty($units)):
                                foreach ($units as $unit): 
                                    $uid = $unit->id;
                                    $row_total = 0;
                                    
                                    // Hitung total per baris
                                    if (isset($data_pcs[$uid])) {
                                        foreach ($data_pcs[$uid] as $jml) $row_total += $jml;
                                    }
                                    $grand_total_tahun += $row_total;
                                    
                                    // Akumulasi total per bulan
                                    if (isset($data_pcs[$uid])) {
                                        foreach ($data_pcs[$uid] as $bln => $jml) {
                                            $grand_total_per_bulan[$bln] += $jml;
                                        }
                                    }
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-left fw-bold"><?= strtoupper($unit->nama) ?></td>
                                <?php for ($b = 1; $b <= 12; $b++): 
                                    $val = isset($data_pcs[$uid][$b]) ? $data_pcs[$uid][$b] : 0;
                                ?>
                                    <td class="text-end"><?= $val > 0 ? number_format($val) : '-' ?></td>
                                <?php endfor; ?>
                                <td class="text-end fw-bold"><?= $row_total > 0 ? number_format($row_total) : '-' ?></td>
                            </tr>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <tr>
                                <td colspan="15" class="text-center text-muted py-4">Tidak ada data unit</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-warning fw-bold">
                            <tr>
                                <td colspan="2" class="text-center">TOTAL KESELURUHAN</td>
                                <?php for ($b = 1; $b <= 12; $b++): ?>
                                    <td class="text-end"><?= $grand_total_per_bulan[$b] > 0 ? number_format($grand_total_per_bulan[$b]) : '-' ?></td>
                                <?php endfor; ?>
                                <td class="text-end"><?= number_format($grand_total_tahun) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>