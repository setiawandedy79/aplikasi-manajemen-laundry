<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penggunaan Chemical <?= $nama_bulan ?> <?= $tahun ?></title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        body { font-family: Arial, sans-serif; font-size: 9px; color: #000; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 2px 3px; text-align: center; vertical-align: middle; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-start { text-align: left; padding-left: 4px !important; }
        .text-end { text-align: right; padding-right: 4px !important; }
        .title { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 2px; }
        .subtitle { text-align: center; font-size: 12px; font-weight: bold; margin-bottom: 10px; }
        .footer-sign { margin-top: 30px; font-size: 10px; }
    </style>
</head>
<body onload="window.print()">
    <div class="title">LAPORAN PENGGUNAAN CHEMICAL LAUNDRY RSPM</div>
    <div class="subtitle">BULAN <?= $nama_bulan ?> <?= $tahun ?></div>
    
    <table>
        <thead>
            <tr>
                <th rowspan="2" width="25">NO</th>
                <th rowspan="2" style="width: 150px;">NAMA CHEMICAL</th>
                <th colspan="31">TANGGAL</th>
                <th rowspan="2" width="70">TOTAL</th>
            </tr>
            <tr>
                <?php for($h=1; $h<=31; $h++): ?>
                    <th width="18"><?= $h ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_total = 0;
            $total_per_hari = array_fill(1, 31, 0);

            if (!empty($chemical_list)):
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
                <td class="text-start"><?= $nama ?></td>
                <?php for($h=1; $h<=31; $h++): 
                    $val = isset($data_transaksi[$nama][$h]) ? $data_transaksi[$nama][$h] : 0;
                ?>
                    <td><?= $val > 0 ? $val : '' ?></td>
                <?php endfor; ?>
                <td style="font-weight:bold;"><?= $row_total > 0 ? number_format($row_total, 2) . ' ' . $satuan : '' ?></td>
            </tr>
            <?php 
                endforeach; 
            endif; 
            ?>
            
            <tr style="background-color: #ffffcc;">
                <td colspan="2" class="text-end" style="font-weight:bold;">TOTAL</td>
                <?php for($h=1; $h<=31; $h++): ?>
                    <td style="font-weight:bold;"><?= $total_per_hari[$h] > 0 ? number_format($total_per_hari[$h], 2) : '' ?></td>
                <?php endfor; ?>
                <td style="font-weight:bold;"><?= number_format($grand_total, 2) ?></td>
            </tr>
        </tbody>
    </table>
    
    <!-- Footer Tanda Tangan (Sesuai Excel) -->
    <div class="footer-sign">
        <table style="width: 100%; border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: left;">
                    Operator Input Data<br><br><br><br>
                    ( _______________________ )
                </td>
                <td style="border: none; width: 50%; text-align: right;">
                    Total Keseluruhan: <strong><?= number_format($grand_total, 2) ?></strong><br>
                    <small>(Akumulasi semua satuan)</small>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>