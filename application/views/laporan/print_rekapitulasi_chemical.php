<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Penggunaan Chemical <?= $tahun ?></title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #000; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px 3px; text-align: center; vertical-align: middle; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-start { text-align: left; padding-left: 5px !important; }
        .text-end { text-align: right; padding-right: 5px !important; }
        .title { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 2px; }
        .subtitle { text-align: center; font-size: 12px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body onload="window.print()">
    <div class="title">REKAPITULASI LAPORAN PENGGUNAAN CHEMICAL LAUNDRY RSPM</div>
    <div class="subtitle">TAHUN <?= $tahun ?></div>
    
    <table>
        <thead>
            <tr>
                <th rowspan="2" width="30">NO</th>
                <th rowspan="2" style="width: 180px;">NAMA CHEMICAL</th>
                <th colspan="12">TOTAL PENGGUNAAN PER BULAN</th>
                <th rowspan="2" width="80">TOTAL TAHUNAN</th>
            </tr>
            <tr>
                <th width="50">JAN</th><th width="50">FEB</th><th width="50">MAR</th>
                <th width="50">APR</th><th width="50">MEI</th><th width="50">JUN</th>
                <th width="50">JUL</th><th width="50">AGU</th><th width="50">SEP</th>
                <th width="50">OKT</th><th width="50">NOV</th><th width="50">DES</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_total_per_bulan = array_fill(1, 12, 0);
            $grand_total_tahun = 0;

            if (!empty($chemical_list)):
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
                <td class="text-start"><?= $nama ?></td>
                <?php for($b=1; $b<=12; $b++): 
                    $val = isset($data_transaksi[$nama][$b]) ? $data_transaksi[$nama][$b] : 0;
                ?>
                    <td><?= $val > 0 ? number_format($val, 2) : '' ?></td>
                <?php endfor; ?>
                <td style="font-weight:bold;"><?= $row_total > 0 ? number_format($row_total, 2) . ' ' . $satuan : '' ?></td>
            </tr>
            <?php 
                endforeach; 
            endif; 
            ?>
            
            <tr style="background-color: #ffffcc;">
                <td colspan="2" class="text-end" style="font-weight:bold;">TOTAL</td>
                <?php for($b=1; $b<=12; $b++): ?>
                    <td style="font-weight:bold;"><?= $grand_total_per_bulan[$b] > 0 ? number_format($grand_total_per_bulan[$b], 2) : '' ?></td>
                <?php endfor; ?>
                <td style="font-weight:bold;"><?= number_format($grand_total_tahun, 2) ?></td>
            </tr>
        </tbody>
    </table>
    
    <div style="margin-top: 30px; font-size: 10px;">
        <table style="width: 100%; border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: left;">
                    Operator Input Data<br><br><br><br>
                    ( _______________________ )
                </td>
                <td style="border: none; width: 50%; text-align: right;">
                    Total Keseluruhan Tahunan:<br>
                    <strong style="font-size: 14px;"><?= number_format($grand_total_tahun, 2) ?></strong><br>
                    <small>(Akumulasi semua satuan)</small>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>