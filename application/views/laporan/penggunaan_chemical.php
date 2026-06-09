<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-flask me-2"></i> Laporan Penggunaan Chemical</h5>
    </div>
    <div class="content-area">
        
        <!-- Filter -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="get" action="<?= base_url('laporan/penggunaan_chemical') ?>" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            <?php 
                            $b_arr = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                            foreach($b_arr as $v => $n): ?>
                                <option value="<?= $v ?>" <?= ($bulan == $v) ? 'selected' : '' ?>><?= $n ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            <?php for($y = date('Y')-2; $y <= date('Y')+1; $y++): ?>
                                <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search me-1"></i> Tampilkan</button>
                        <a href="<?= base_url('laporan/print_penggunaan_chemical?bulan='.$bulan.'&tahun='.$tahun) ?>" target="_blank" class="btn btn-success">
                            <i class="fas fa-print me-1"></i> Cetak Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <div class="card">
            <div class="card-body">
                <h5 class="text-center fw-bold mb-1">LAPORAN PENGGUNAAN CHEMICAL LAUNDRY RSPM</h5>
                <p class="text-center text-muted mb-3">BULAN <?= $nama_bulan ?> <?= $tahun ?></p>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 0.8rem;">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" width="40">NO</th>
                                <th rowspan="2" style="min-width: 150px;">NAMA CHEMICAL</th>
                                <th colspan="31">TANGGAL</th>
                                <th rowspan="2" width="100">TOTAL</th>
                            </tr>
                            <tr>
                                <?php for($h=1; $h<=31; $h++): ?>
                                    <th width="25"><?= $h ?></th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1; 
                            $grand_total = 0;
                            $total_per_hari = array_fill(1, 31, 0);

                            foreach ($chemical_list as $chem): 
                                $nama = $chem->nama_sabun;
                                $satuan = isset($satuan_chemical[$nama]) ? $satuan_chemical[$nama] : '';
                                $row_total = 0;
                                
                                if(isset($data_transaksi[$nama])) {
                                    foreach($data_transaksi[$nama] as $jml) $row_total += $jml;
                                }
                                $grand_total += $row_total;
                                
                                if(isset($data_transaksi[$nama])) {
                                    foreach($data_transaksi[$nama] as $hari => $jml) {
                                        $total_per_hari[$hari] += $jml;
                                    }
                                }
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-start fw-semibold"><?= $nama ?></td>
                                <?php for($h=1; $h<=31; $h++): 
                                    $val = isset($data_transaksi[$nama][$h]) ? $data_transaksi[$nama][$h] : 0;
                                ?>
                                    <td><?= $val > 0 ? $val : '' ?></td>
                                <?php endfor; ?>
                                <td class="fw-bold"><?= $row_total > 0 ? number_format($row_total, 2) . ' ' . $satuan : '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- Baris Total -->
                            <tr class="table-warning fw-bold">
                                <td colspan="2" class="text-end">TOTAL KESELURUHAN</td>
                                <?php for($h=1; $h<=31; $h++): ?>
                                    <td><?= $total_per_hari[$h] > 0 ? number_format($total_per_hari[$h], 2) : '' ?></td>
                                <?php endfor; ?>
                                <td><?= number_format($grand_total, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>