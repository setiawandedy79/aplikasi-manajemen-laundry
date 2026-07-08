<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rincian Penyerahan - <?= isset($header->no_transaksi) ? $header->no_transaksi : '' ?></title>
    <style>
        @page { size: A4 portrait; margin: 15mm; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 15px; }
        th, td { border: 1px solid #333; padding: 5px 8px; text-align: center; vertical-align: middle; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-start { text-align: left !important; }
        .text-end { text-align: right !important; }
        .header-info { margin-bottom: 20px; border: 1px solid #333; padding: 10px; }
        .header-info table { border: none; margin-bottom: 0; }
        .header-info td { border: none; padding: 3px 5px; text-align: left; }
        .title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
        .signature { margin-top: 40px; }
        .signature table { border: none; }
        .signature td { border: none; text-align: center; vertical-align: bottom; height: 80px; }
    </style>
</head>
<body onload="window.print()">
    <div class="title">RINCIAN PENYERAHAN LINEN</div>
    
    <!-- Info Header Transaksi -->
    <div class="header-info">
        <table>
            <tr>
                <td width="120"><strong>No. Transaksi</strong></td>
                <td width="10">:</td>
                <td><?= isset($header->no_transaksi) ? $header->no_transaksi : '-' ?></td>
                <td width="120"><strong>Tanggal</strong></td>
                <td width="10">:</td>
                <td><?= isset($header->tanggal) ? date('d/m/Y', strtotime($header->tanggal)) : '-' ?></td>
            </tr>
            <tr>
                <td><strong>Nama Unit</strong></td>
                <td>:</td>
                <td><?= isset($header->nama_pelanggan) ? $header->nama_pelanggan : '-' ?></td>
                <!-- <td><strong>Penerima</strong></td>
                <td>:</td>
                <td><?= isset($header->nama_penerima) ? $header->nama_penerima : '-' ?></td> -->
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>:</td>
                <td colspan="4">
                    <?php if (isset($header->status_serah) && $header->status_serah == 'diserahkan'): ?>
                        <strong>SUDAH DISERAHKAN</strong> (Oleh: <?= isset($header->nama_pengambil) ? $header->nama_pengambil : '-' ?>)
                    <?php else: ?>
                        <strong>BELUM DISERAHKAN</strong>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabel Rincian -->
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th class="text-center">Nama Linen</th>
                <th width="80">Jml Awal</th>
                <th width="100">Jml Diserahkan</th>
                <th width="80">Sisa</th>
                <th class="text-center">Keterangan / Status Kekurangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total_awal = 0;
            $total_serah = 0;
            $ada_item_diserahkan = false;
            
            if (!empty($detail)):
                foreach ($detail as $d): 
                    $qty_awal  = isset($d->jumlah) ? (int)$d->jumlah : 0;
                    $qty_serah = isset($d->jumlah_diserahkan) ? (int)$d->jumlah_diserahkan : 0;
                    
                    // ✅ FILTER: Hanya tampilkan jika jumlah diserahkan > 0
                    if ($qty_serah > 0): 
                        $ada_item_diserahkan = true;
                        $sisa = $qty_awal - $qty_serah;
                        
                        $total_awal  += $qty_awal;
                        $total_serah += $qty_serah;
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td class="text-start"><?= isset($d->nama_pakaian) ? $d->nama_pakaian : '-' ?></td>
                <td><?= $qty_awal ?></td>
                <td><?= $qty_serah ?></td>
                <td><?= $sisa > 0 ? $sisa : '0' ?></td>
                <?php 
                    // ✅ LOGIKA KHUSUS UNTUK PRINT (Tanpa Bootstrap)
                    $keterangan_tampil = '-';
                    
                    if ($sisa > 0) {
                        $status_text = '';
                        if (isset($d->status_kekurangan) && $d->status_kekurangan == 'rusak') {
                            $status_text = '🔥 RUSAK';
                        } elseif (isset($d->status_kekurangan) && $d->status_kekurangan == 'belum_terkirim') {
                            $status_text = '📦 BELUM TERKIRIM';
                        } else {
                            $status_text = 'KEKURANGAN';
                        }
                        
                        $ket_kurang = isset($d->keterangan_kekurangan) && !empty($d->keterangan_kekurangan) ? $d->keterangan_kekurangan : '';
                        $keterangan_tampil = '<strong>' . $status_text . '</strong>' . ($ket_kurang ? '<br><em>' . $ket_kurang . '</em>' : '');
                    } else {
                        if (isset($d->keterangan) && !empty($d->keterangan)) {
                            $keterangan_tampil = $d->keterangan;
                        }
                    }
                ?>

                <!-- ✅ GANTI TD INI -->
                <td><?= $keterangan_tampil ?></td>
                <!-- <td class="text-start"><?= isset($d->keterangan) ? $d->keterangan : '-' ?></td> -->
            </tr>
            <?php 
                    endif; // Tutup if qty_serah > 0
                endforeach; 
            endif; 

            if (!$ada_item_diserahkan): 
            ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 15px;">Belum ada linen yang diserahkan</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td colspan="2" class="text-end">TOTAL KESELURUHAN</td>
                <td><?= $total_awal ?></td>
                <td><?= $total_serah ?></td>
                <td><?= $total_awal - $total_serah ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Kolom Tanda Tangan -->
    <div class="signature">
        <table>
            <tr>
                <td width="33%">
                    Mengetahui,<br>
                    Kepala Unit Laundry<br><br><br><br>
                    ( _______________________ )
                </td>
                <td width="33%">
                    Petugas Penyerahan<br><br><br><br>
                    ( _______________________ )
                </td>
                <td width="33%">
                    Penerima / Pengambil<br><br><br><br>
                    ( _______________________ )
                </td>
            </tr>
        </table>
    </div>
</body>
</html>