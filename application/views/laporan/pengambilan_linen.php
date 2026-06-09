<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-file-alt me-2"></i> Laporan Pengambilan Linen</h5>
    </div>
    <div class="content-area">
        
        <!-- Filter Bulan & Tahun -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="get" action="<?= base_url('laporan/pengambilan_linen') ?>" class="row g-3 align-items-end">
                    <!-- TAMBAHAN: Dropdown Ruangan -->
                    <div class="col-md-3">
                        <label class="form-label">Ruangan / Pelanggan</label>
                        <select name="ruangan" class="form-select">
                            <option value="">-- Semua Ruangan --</option>
                            <?php foreach ($daftar_ruangan as $r): ?>
                                <option value="<?= $r->nama ?>" <?= ($ruangan == $r->nama) ? 'selected' : '' ?>>
                                    <?= $r->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
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
                        <!-- Tambahkan &ruangan=<?= $ruangan ?> di URL print -->
                        <a href="<?= base_url('laporan/print_pengambilan_linen?bulan='.$bulan.'&tahun='.$tahun.'&ruangan='.$ruangan) ?>" target="_blank" class="btn btn-success">
                                <i class="fas fa-print me-1"></i> Cetak Laporan
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle" style="font-size: 0.85rem;">
                        <thead class="table-dark">
                            <tr>
                                <th rowspan="2" width="40">NO</th>
                                <th rowspan="2" style="min-width: 200px;">NAMA LINEN</th>
                                <th colspan="31">PENGAMBILAN LINEN KOTOR</th>
                                <th rowspan="2" width="60">JUMLAH</th>
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

                            foreach ($linen_list as $linen): 
                                $pid = $linen->id;
                                $row_total = 0;
                                
                                // Hitung total per baris
                                if(isset($data_transaksi[$pid])) {
                                    foreach($data_transaksi[$pid] as $jml) $row_total += $jml;
                                }
                                $grand_total += $row_total;
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="text-left"><?= $linen->nama_pakaian ?></td>
                                <?php for($h=1; $h<=31; $h++): 
                                    $val = isset($data_transaksi[$pid][$h]) ? $data_transaksi[$pid][$h] : 0;
                                    if($val > 0) $total_per_hari[$h] += $val;
                                ?>
                                    <td><?= $val > 0 ? $val : '' ?></td>
                                <?php endfor; ?>
                                <td class="fw-bold"><?= $row_total > 0 ? $row_total : '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- Baris Total Bawah -->
                            <tr class="table-warning fw-bold">
                                <td colspan="2" class="text-end">TOTAL</td>
                                <?php for($h=1; $h<=31; $h++): ?>
                                    <td><?= $total_per_hari[$h] > 0 ? $total_per_hari[$h] : '' ?></td>
                                <?php endfor; ?>
                                <td><?= $grand_total ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>