<!DOCTYPE html>
<html>
<head>
    <title>Kartu Stok Chemical</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; color: #000; }
        h2 { text-align: center; margin-bottom: 5px; text-transform: uppercase; }
        .periode { text-align: center; margin-bottom: 20px; font-weight: bold; }
        
        /* ✅ CSS UNTUK MEMBUAT HALAMAN BARU SETIAP CHEMICAL */
        .card {
            border: 1px solid #000;
            margin-bottom: 15px;
            page-break-after: always; /* Memaksa pindah halaman setelah elemen ini */
            break-after: page;        /* Standar CSS3 modern */
        }
        .card:last-child {
            page-break-after: auto;   /* Chemical terakhir tidak perlu halaman kosong di belakangnya */
            break-after: auto;
        }

        .card-header { 
            background: #f0f0f0; 
            padding: 8px; 
            font-weight: bold; 
            border-bottom: 1px solid #000; 
            display: flex; 
            justify-content: space-between; 
            font-size: 13px;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #f9f9f9; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-light { background-color: #f9f9f9; font-weight: bold; }
        .table-warning { background-color: #fff3cd; font-weight: bold; }
        .text-success { color: green; }
        .text-danger { color: red; }
        
        .no-print { text-align: right; margin-bottom: 15px; }
        .btn { padding: 5px 10px; cursor: pointer; text-decoration: none; color: white; background: #007bff; border-radius: 3px; }

        @media print {
            .no-print { display: none; }
            body { margin: 15px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn">🖨️ Cetak Halaman</button>
    </div>

    <h2>Kartu Stok Chemical (Terperinci)</h2>
    <div class="periode">Periode: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?></div>

    <?php foreach ($sabun_list as $sabun): 
        $saldo = $this->Laporan_model->hitung_saldo_awal($sabun->id, $dari);
        $transaksi = $this->Laporan_model->get_transaksi_stok($sabun->id, $dari, $sampai);
    ?>
    
    <!-- ✅ Setiap .card akan otomatis pindah ke halaman baru saat di-print -->
    <div class="card">
        <div class="card-header">
            <span><?= $sabun->nama_sabun ?></span>
            <span>Satuan: <?= $sabun->nama_satuan ?? 'ML' ?></span>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="text-center" width="30">No</th>
                    <th class="text-center" width="80">Tanggal</th>
                    <th class="text-center" width="200">Keterangan</th>
                    <th class="text-center" width="80" class="text-center">Masuk</th>
                    <th class="text-center" width="80" class="text-center">Keluar</th>
                    <th class="text-center" width="100" class="text-center">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-light">
                    <td class="text-center">-</td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($dari)) ?></td>
                    <td>Saldo Awal Periode</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td class="text-center"><?= number_format($saldo, 2) ?></td>
                </tr>
                <?php 
                $no = 1;
                if (!empty($transaksi)):
                    foreach ($transaksi as $t):
                        $saldo = $saldo + (float)$t->masuk - (float)$t->keluar;
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($t->tanggal)) ?></td>
                    <td class="text-left"><?= $t->keterangan ?></td>
                    <td class="text-center text-success"><?= $t->masuk > 0 ? number_format($t->masuk, 2) : '-' ?></td>
                    <td class="text-center text-danger"><?= $t->keluar > 0 ? number_format($t->keluar, 2) : '-' ?></td>
                    <td class="text-center" style="font-weight:bold;"><?= number_format($saldo, 2) ?></td>
                </tr>
                <?php endforeach; endif; ?>
                <tr class="table-warning">
                    <td colspan="4" class="text-right">Sisa Stok Akhir:</td>
                    <td colspan="2" class="text-center"><?= number_format($saldo, 2) ?> <?= $sabun->nama_satuan ?? 'ML' ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>

</body>
</html>