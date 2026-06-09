<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-chart-line me-2"></i> Rekapitulasi Hasil Pencucian Linen Bersih</h5>
    </div>
    <div class="content-area">
        
        <!-- Filter Tahun -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="get" action="<?= base_url('laporan/rekapitulasi_pencucian') ?>" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            <?php 
                            //$tahun_awal = date('Y') - 2;
                            $tahun_awal = 2025;
                            $tahun_akhir = date('Y') + 1;
                            for ($y = $tahun_awal; $y <= $tahun_akhir; $y++): 
                            ?>
                                <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-9">
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Tampilkan</button>
                        <a href="<?= base_url('laporan/print_rekapitulasi_pencucian?tahun='.$tahun) ?>" target="_blank" class="btn btn-success">
                            <i class="fas fa-print me-1"></i> Cetak Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <div class="card">
            <div class="card-body">
                <h5 class="text-center fw-bold mb-1">HASIL PENCUCIAN LINEN BERSIH</h5>
                <p class="text-center text-muted mb-3">TAHUN <?= $tahun ?></p>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 0.85rem;">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" width="40">NO</th>
                                <th rowspan="2" style="min-width: 180px;">NAMA UNIT</th>
                                <th colspan="12">LINEN BERSIH (Kg)</th>
                                <th rowspan="2" width="100">TOTAL (Kg)</th>
                            </tr>
                            <tr>
                                <?php foreach ($bulan_list as $nama_bulan): ?>
                                    <th width="70"><?= $nama_bulan ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1; 
                            $grand_total_per_bulan = array_fill(1, 12, 0);
                            $grand_total_tahun = 0;

                            foreach ($unit_list as $unit): 
                                $uid = $unit->id;
                                $row_total = 0;
                                
                                if(isset($data_berat[$uid])) {
                                    foreach($data_berat[$uid] as $jml) $row_total += $jml;
                                }
                                
                                $grand_total_tahun += $row_total;
                                
                                if(isset($data_berat[$uid])) {
                                    foreach($data_berat[$uid] as $bln => $jml) {
                                        $grand_total_per_bulan[$bln] += $jml;
                                    }
                                }
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-left fw-semibold"><?= isset($unit->nama) ? strtoupper($unit->nama) : '-' ?></td>
                                <?php for($b=1; $b<=12; $b++): 
                                    $val = isset($data_berat[$uid][$b]) ? $data_berat[$uid][$b] : 0;
                                ?>
                                    <td><?= $val > 0 ? number_format($val, 2) : '-' ?></td>
                                <?php endfor; ?>
                                <td class="fw-bold"><?= $row_total > 0 ? number_format($row_total, 2) : '-' ?></td>
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