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

            <table class="table-print" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f0f0f0; text-align: center; font-weight: bold;">
                    <th style="border: 1px solid #000; padding: 5px; width: 40px;">No</th>
                    <th style="border: 1px solid #000; padding: 5px; text-align: center;">Nama Linen</th>
                    <th style="border: 1px solid #000; padding: 5px; width: 100px;">Kategori</th>
                    <th style="border: 1px solid #000; padding: 5px; width: 80px;">Status</th>
                    <th style="border: 1px solid #000; padding: 5px; width: 80px;">Jumlah</th>
                    <th style="border: 1px solid #000; padding: 5px; width: 100px;">Berat (Kg)</th>
                    <th style="border: 1px solid #000; padding: 5px; text-align: center;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $list_detail = isset($details) ? $details : (isset($detail) ? $detail : []);
                
                $no = 1;
                $total_qty = 0; 
                $total_kg = 0; 
                
                if (!empty($list_detail)): 
                    foreach ($list_detail as $d): 
                        $total_qty += isset($d->jumlah) ? (int)$d->jumlah : 0;
                        $total_kg  += isset($d->jumlah_kg) ? (float)$d->jumlah_kg : 0.00;
                ?>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= $no++ ?></td>
                    <td style="border: 1px solid #000; padding: 5px;"><?= isset($d->nama_pakaian) ? $d->nama_pakaian : '-' ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= isset($d->kategori) ? $d->kategori : '-' ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <?= (isset($d->ceklis) && $d->ceklis == 1) ? 'Ya' : 'Tidak' ?>
                    </td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center; font-weight: bold;">
                        <?= isset($d->jumlah) ? $d->jumlah : 0 ?>
                    </td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <?= isset($d->jumlah_kg) ? number_format($d->jumlah_kg, 2) : '0.00' ?>
                    </td>
                    <td style="border: 1px solid #000; padding: 5px;"><?= isset($d->keterangan) ? $d->keterangan : '-' ?></td>
                </tr>
                <?php 
                    endforeach; 
                else: 
                ?>
                <tr>
                    <td colspan="7" style="border: 1px solid #000; padding: 10px; text-align: center;">Tidak ada detail item</td>
                </tr>
                <?php endif; ?>
            </tbody>
            
            <!-- Baris Total untuk Print -->
            <tfoot>
                <tr style="background-color: #f9f9f9; font-weight: bold;">
                    <td colspan="4" style="border: 1px solid #000; padding: 5px; text-align: right;">TOTAL KESELURUHAN</td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= $total_qty ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= number_format($total_kg, 2) ?></td>
                    <td style="border: 1px solid #000; padding: 5px;"></td>
                </tr>
            </tfoot>
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