<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-chart-bar me-2"></i> Rekapitulasi Penggunaan Chemical</h5>
    </div>
    <div class="content-area">
        
        <!-- Filter Tahun -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="get" action="<?= base_url('laporan/rekapitulasi_chemical') ?>" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            <?php for($y = date('Y')-2; $y <= date('Y')+1; $y++): ?>
                                <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-9">
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Tampilkan</button>
                        <a href="<?= base_url('laporan/print_rekapitulasi_chemical?tahun='.$tahun) ?>" target="_blank" class="btn btn-success">
                            <i class="fas fa-print me-1"></i> Cetak Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <div class="card">
            <div class="card-body">
                <h5 class="text-center fw-bold mb-1">REKAPITULASI LAPORAN PENGGUNAAN CHEMICAL LAUNDRY RSPM</h5>
                <p class="text-center text-muted mb-3">TAHUN <?= $tahun ?></p>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 0.85rem;">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" width="40">NO</th>
                                <th rowspan="2" style="min-width: 180px;">NAMA CHEMICAL</th>
                                <th colspan="12">TOTAL PENGGUNAAN PER BULAN</th>
                                <th rowspan="2" width="100">TOTAL TAHUNAN</th>
                            </tr>
                            <tr>
                                <th width="70">JAN</th><th width="70">FEB</th><th width="70">MAR</th>
                                <th width="70">APR</th><th width="70">MEI</th><th width="70">JUN</th>
                                <th width="70">JUL</th><th width="70">AGU</th><th width="70">SEP</th>
                                <th width="70">OKT</th><th width="70">NOV</th><th width="70">DES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1; 
                            $grand_total_per_bulan = array_fill(1, 12, 0);
                            $grand_total_tahun = 0;

                            foreach ($chemical_list as $chem): 
                                $nama = $chem->nama_sabun;
                                $satuan = isset($satuan_chemical[$nama]) ? $satuan_chemical[$nama] : '';
                                $row_total = 0;
                                
                                if(isset($data_transaksi[$nama])) {
                                    foreach($data_transaksi[$nama] as $jml) $row_total += $jml;
                                }
                                $grand_total_tahun += $row_total;
                                
                                if(isset($data_transaksi[$nama])) {
                                    foreach($data_transaksi[$nama] as $bln => $jml) {
                                        $grand_total_per_bulan[$bln] += $jml;
                                    }
                                }
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-start fw-semibold"><?= $nama ?></td>
                                <?php for($b=1; $b<=12; $b++): 
                                    $val = isset($data_transaksi[$nama][$b]) ? $data_transaksi[$nama][$b] : 0;
                                ?>
                                    <td><?= $val > 0 ? number_format($val, 2) : '-' ?></td>
                                <?php endfor; ?>
                                <td class="fw-bold"><?= $row_total > 0 ? number_format($row_total, 2) . ' ' . $satuan : '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- Baris Total -->
                            <tr class="table-warning fw-bold">
                                <td colspan="2" class="text-end">TOTAL</td>
                                <?php for($b=1; $b<=12; $b++): ?>
                                    <td><?= $grand_total_per_bulan[$b] > 0 ? number_format($grand_total_per_bulan[$b], 2) : '-' ?></td>
                                <?php endfor; ?>
                                <td><?= number_format($grand_total_tahun, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>