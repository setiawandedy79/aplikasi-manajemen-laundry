<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Opname Chemical</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 5px 0; text-transform: uppercase; }
        .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature { text-align: center; width: 200px; }
        .signature-line { margin-top: 60px; border-top: 1px solid #000; padding-top: 5px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: right; margin-bottom: 10px;">
        <button onclick="window.print()" style="padding: 8px 15px; cursor: pointer;">🖨️ Cetak Halaman</button>
        <button onclick="window.close()" style="padding: 8px 15px; cursor: pointer;"> Tutup</button>
    </div>

    <div class="header">
        <h2>Laporan Stok Opname Chemical</h2>
        <p>Periode: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="40" class="text-center">No</th>
                <th width="90" class="text-center">Tanggal</th>
                <th>Nama Chemical</th>
                <th width="90" class="text-center">Stok Sistem</th>
                <th width="90" class="text-center">Stok Fisik</th>
                <th width="90" class="text-center">Selisih</th>
                <th>Keterangan</th>
                <th width="120">Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total_selisih = 0;
            if (!empty($opname)):
                foreach ($opname as $row):
                    $total_selisih += $row->selisih;
                    $selisih_text = $row->selisih > 0 ? '+' . number_format($row->selisih, 2) : number_format($row->selisih, 2);
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                <td><strong><?= $row->nama_sabun ?></strong> <br><small>(<?= $row->nama_satuan ?>)</small></td>
                <td class="text-right"><?= number_format($row->stok_sistem, 2) ?></td>
                <td class="text-right"><?= number_format($row->stok_fisik, 2) ?></td>
                <td class="text-center" style="font-weight: bold;"><?= $selisih_text ?></td>
                <td><?= $row->keterangan ?: '-' ?></td>
                <td><?= $row->nama_lengkap ?></td>
            </tr>
            <?php 
                endforeach;
            else:
            ?>
            <tr>
                <td colspan="8" class="text-center">Tidak ada data opname pada periode ini</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div></div>
        <div class="signature">
            <p>Diketahui oleh,</p>
            <div class="signature-line">
                <strong>( ........................... )</strong><br>
                Kepala Gudang / Supervisor
            </div>
        </div>
    </div>

    <script>
        // Otomatis print saat halaman dibuka (opsional, bisa dihapus jika tidak mau)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>