<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengembalian Linen</title>
    <style>
        @page { size: A4 landscape; margin: 8mm; }
        body { font-family: Arial, sans-serif; font-size: 8px; color: #000; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 2px; text-align: center; vertical-align: middle; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-start { text-align: left; padding-left: 3px !important; }
        .text-end { text-align: right; padding-right: 3px !important; }
        .title { text-align: center; font-size: 13px; font-weight: bold; margin-bottom: 2px; }
        .subtitle { text-align: center; font-size: 11px; font-weight: bold; margin-bottom: 8px; }
    </style>
</head>
<body onload="window.print()">
    <div class="title">LAPORAN LINEN LAUNDRY RSPM</div>
    <div class="subtitle">
        RUANGAN: <?= isset($ruangan) ? strtoupper($ruangan) : 'RUANG OK' ?> <br>
        BULAN <?= isset($nama_bulan) ? $nama_bulan : '' ?> <?= isset($tahun) ? $tahun : date('Y') ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th rowspan="2" width="25">NO</th>
                <th rowspan="2" style="width: 150px;">NAMA LINEN</th>
                <th rowspan="2" width="60">BERAT (kg)</th>
                <th colspan="31">PENGEMBALIAN LINEN BERSIH</th>
                <th rowspan="2" width="45">JUMLAH</th>
                <th rowspan="2" width="70">TOTAL BERAT (kg)</th>
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
            $grand_total_qty = 0;
            $grand_total_berat = 0;
            $total_per_hari = array_fill(1, 31, 0);

            if (!empty($linen_list)):
                foreach ($linen_list as $linen): 
                    $pid = $linen->id;
                    $berat_satuan = isset($linen->berat_bersih) ? (float)$linen->berat_bersih : 0;
                    $row_total_qty = 0;
                    
                    if(isset($data_transaksi[$pid])) {
                        foreach($data_transaksi[$pid] as $jml) $row_total_qty += $jml;
                    }
                    
                    $row_total_berat = $row_total_qty * $berat_satuan;
                    $grand_total_qty += $row_total_qty;
                    $grand_total_berat += $row_total_berat;
                    
                    if(isset($data_transaksi[$pid])) {
                        foreach($data_transaksi[$pid] as $hari => $jml) {
                            $total_per_hari[$hari] += $jml;
                        }
                    }

                    // ✅ FILTER: Hanya tampilkan jika ada qty yang dikembalikan
                    if ($row_total_qty > 0): 
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td class="text-start"><?= isset($linen->nama_pakaian) ? $linen->nama_pakaian : '-' ?></td>
                <td><?= number_format($berat_satuan, 2) ?></td>
                <?php for($h=1; $h<=31; $h++): 
                    $val = isset($data_transaksi[$pid][$h]) ? $data_transaksi[$pid][$h] : 0;
                ?>
                    <td><?= $val > 0 ? $val : '' ?></td>
                <?php endfor; ?>
                <td style="font-weight:bold;"><?= $row_total_qty ?></td>
                <td style="font-weight:bold;"><?= number_format($row_total_berat, 2) ?></td>
            </tr>
            <?php 
                    endif; 
                endforeach; 
            endif; 
            ?>
            
            <tr style="background-color: #ffffcc;">
                <td colspan="3" class="text-end" style="font-weight:bold;">TOTAL</td>
                <?php for($h=1; $h<=31; $h++): ?>
                    <td style="font-weight:bold;"><?= $total_per_hari[$h] > 0 ? $total_per_hari[$h] : '' ?></td>
                <?php endfor; ?>
                <td style="font-weight:bold;"><?= $grand_total_qty ?></td>
                <td style="font-weight:bold;"><?= number_format($grand_total_berat, 2) ?></td>
            </tr>
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 9px;">
        <table style="width: 100%; border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 33%; text-align: center;">
                    Operator Input Data<br><br><br>
                    _______________________
                </td>
                <td style="border: none; width: 33%; text-align: center;">
                    Mengetahui<br><br><br>
                    _______________________
                </td>
                <td style="border: none; width: 33%; text-align: center;">
                    Total KG: <?= number_format($grand_total_berat, 2) ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>