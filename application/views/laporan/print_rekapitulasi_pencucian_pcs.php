<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Pencucian Linen (Pcs)</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; color: #000; }
        h2, h4 { text-align: center; margin: 5px 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 4px 6px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .table-warning { background-color: #fff3cd; }
        .no-print { text-align: right; margin-bottom: 10px; }
        .btn { padding: 5px 10px; background: #007bff; color: white; text-decoration: none; border-radius: 3px; cursor: pointer; border: none; }
        @media print {
            .no-print { display: none; }
            body { margin: 10px; }
            th { background-color: #ddd !important; -webkit-print-color-adjust: exact; }
            .table-warning { background-color: #fff3cd !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn">🖨️ Cetak Halaman</button>
    </div>

    <h2>REKAPITULASI JUMLAH LINEN DICUCI</h2>
    <h4>TAHUN <?= $tahun ?></h4>

    <table>
        <thead>
            <tr>
                <th width="30" rowspan="2">NO</th>
                <th width="180" rowspan="2">NAMA UNIT</th>
                <th colspan="12">JUMLAH LINEN (PCS) PER BULAN</th>
                <th width="80" rowspan="2">TOTAL (Pcs)</th>
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
                    
                    if (isset($data_pcs[$uid])) {
                        foreach ($data_pcs[$uid] as $jml) $row_total += $jml;
                    }
                    $grand_total_tahun += $row_total;
                    
                    if (isset($data_pcs[$uid])) {
                        foreach ($data_pcs[$uid] as $bln => $jml) {
                            $grand_total_per_bulan[$bln] += $jml;
                        }
                    }
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="fw-bold"><?= strtoupper($unit->nama) ?></td>
                <?php for ($b = 1; $b <= 12; $b++): 
                    $val = isset($data_pcs[$uid][$b]) ? $data_pcs[$uid][$b] : 0;
                ?>
                    <td class="text-end"><?= $val > 0 ? number_format($val) : '-' ?></td>
                <?php endfor; ?>
                <td class="text-end fw-bold"><?= $row_total > 0 ? number_format($row_total) : '-' ?></td>
            </tr>
            <?php 
                endforeach;
            endif; 
            ?>
        </tbody>
        <tfoot>
            <tr class="table-warning fw-bold">
                <td colspan="2" class="text-center">TOTAL KESELURUHAN</td>
                <?php for ($b = 1; $b <= 12; $b++): ?>
                    <td class="text-end"><?= $grand_total_per_bulan[$b] > 0 ? number_format($grand_total_per_bulan[$b]) : '-' ?></td>
                <?php endfor; ?>
                <td class="text-end"><?= number_format($grand_total_tahun) ?></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 40px; display: flex; justify-content: space-between;">
        <div style="text-align: center; width: 200px;">
            <p>Mengetahui,<br>Kepala Unit Laundry</p>
            <br><br><br>
            <p style="border-top: 1px solid #000; padding-top: 5px;">( ........................... )</p>
        </div>
        <div style="text-align: center; width: 200px;">
            <p>Dibuat oleh,<br>Operator Data</p>
            <br><br><br>
            <p style="border-top: 1px solid #000; padding-top: 5px;">( ........................... )</p>
        </div>
    </div>

    <script>window.onload = function() { window.print(); }</script>
</body>
</html>