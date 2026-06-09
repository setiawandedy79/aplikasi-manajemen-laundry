<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengambilan Linen</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        body { font-family: Arial, sans-serif; font-size: 9px; color: #000; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 2px 3px; text-align: center; vertical-align: middle; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-start { text-align: left; padding-left: 4px !important; }
        .text-end { text-align: right; padding-right: 4px !important; }
        .title { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 2px; }
        .subtitle { text-align: center; font-size: 11px; font-weight: bold; margin-bottom: 10px; }
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
                <th rowspan="2" style="width: 160px;">NAMA LINEN</th>
                <th colspan="31">PENGAMBILAN LINEN KOTOR</th>
                <th rowspan="2" width="45">JUMLAH</th>
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

                if (!empty($linen_list)):
                    foreach ($linen_list as $linen): 
                        $pid = $linen->id; 
                        $row_total = 0;
                        
                        // Hitung total per baris
                        if(isset($data_transaksi[$pid])) {
                            foreach($data_transaksi[$pid] as $jml) $row_total += $jml;
                        }
                        
                        $grand_total += $row_total;
                        
                        // Hitung total per hari untuk baris total bawah
                        if(isset($data_transaksi[$pid])) {
                            foreach($data_transaksi[$pid] as $hari => $jml) {
                                $total_per_hari[$hari] += $jml;
                            }
                        }

                        // ✅ FILTER: Hanya tampilkan baris jika total > 0
                        if ($row_total > 0): 
                ?>
                <tr>
                    <td><?= $no++ ?></td> <!-- Penomoran di dalam if agar urut -->
                    <td class="text-start"><?= isset($linen->nama_pakaian) ? $linen->nama_pakaian : '-' ?></td>
                    <?php for($h=1; $h<=31; $h++): 
                        $val = isset($data_transaksi[$pid][$h]) ? $data_transaksi[$pid][$h] : 0;
                    ?>
                        <td><?= $val > 0 ? $val : '' ?></td>
                    <?php endfor; ?>
                    <td style="font-weight:bold;"><?= $row_total ?></td>
                </tr>
                <?php 
                        endif; // Tutup if row_total > 0
                    endforeach; 
                endif; 
                ?>
                
                <!-- Baris Total Bawah (Tetap ditampilkan) -->
                <tr style="background-color: #ffffcc;">
                    <td colspan="2" class="text-end" style="font-weight:bold;">TOTAL</td>
                    <?php for($h=1; $h<=31; $h++): ?>
                        <td style="font-weight:bold;"><?= $total_per_hari[$h] > 0 ? $total_per_hari[$h] : '' ?></td>
                    <?php endfor; ?>
                    <td style="font-weight:bold;"><?= $grand_total ?></td>
                </tr>
        </tbody>
    </table>
</body>
</html>