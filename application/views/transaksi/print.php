<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Transaksi <?= $header->no_transaksi ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 5px; vertical-align: top; }
        .info-table .label { width: 130px; font-weight: bold; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.items th, table.items td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        table.items th { background: #f0f0f0; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-success { background: #10b981; color: white; }
        .badge-danger { background: #ef4444; color: white; }
        .footer { margin-top: 30px; display: flex; justify-content: space-between; }
        .signature { text-align: center; width: 200px; }
        .signature .line { border-top: 1px solid #333; margin-top: 60px; }
        @media print {
            body { margin: 10px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>MEDIKA LAUNDRY PRO</h2>
        <p>Laporan Transaksi Laundry</p>
    </div>

    <table class="info-table">
        <tr><td class="label">No Transaksi</td><td>: <?= $header->no_transaksi ?></td><td class="label">Tanggal</td><td>: <?= date('d/m/Y', strtotime($header->tanggal)) ?></td></tr>
        <tr><td class="label">Pelanggan</td><td>: <?= $header->nama_pelanggan ?? '-' ?></td><td class="label">Shift</td><td>: <?= ucfirst($header->shift) ?></td>
        <td class="label">Jenis Laundry</td><td>: 
        <span style="padding:2px 6px; border-radius:3px; font-size:10px; color:white; background: <?= $header->jenis_laundry == 'Infeksius' ? '#ef4444' : '#10b981' ?>;">
            <?= isset($header->jenis_laundry) ? $header->jenis_laundry : 'Non Infeksius' ?>
        </span>
        </td></tr>
        <tr><td class="label">Nama Pengirim</td><td>: <?= $header->nama_pengirim ?></td><td class="label">Nama Penerima</td><td>: <?= $header->nama_penerima ?></td></tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th class="text-center" width="40">No</th>
                <th class="text-center">Nama Linen</th>
                <th class="text-center" width="80">Kategori</th>
                <th class="text-center" width="60">Jumlah</th>
                <th width="80" class="text-center">Berat (Kg)</th>
                <th class="text-center" width="60">Status</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
            <tbody>
                <?php 
                $no = 1; 
                $ada_item = false; // Flag untuk cek apakah ada barang yang dicentang
                foreach ($detail as $d): 
                    if ($d->ceklis == 1): //  Hanya proses jika dicentang
                        $ada_item = true;
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $d->nama_pakaian ?></td>
                    <td class="text-center"><?= $d->kategori ?></td>
                    <td class="text-center"><?= $d->jumlah > 0 ? $d->jumlah : '-' ?></td>
                    <td class="text-center"><?= isset($d->jumlah_kg) ? number_format($d->jumlah_kg, 2) : '0.00' ?> Kg</td>
                    <td class="text-center">☑️</td>
                    <td><?= $d->keterangan ?: '-' ?></td>
                </tr>
                <?php 
                    endif; 
                endforeach; 
                
                // Tampilkan pesan jika tidak ada barang yang dicentang
                if (!$ada_item): 
                ?>
                <tr>
                    <td colspan="6" class="text-center py-3" style="color: #666; font-style: italic;">
                        Tidak ada barang yang dipilih/dicentang pada transaksi ini.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Pengirim</p>
            <div class="line"></div>
            <p><?= $header->nama_pengirim ?></p>
        </div>
        <div class="signature">
            <p>Penerima</p>
            <div class="line"></div>
            <p><?= $header->nama_penerima ?></p>
        </div>
    </div>

    <script>window.print();</script>
</body>
</html>