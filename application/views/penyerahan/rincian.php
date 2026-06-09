<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-list-alt me-2"></i> Rincian Penyerahan Linen</h5>
    </div>
    <div class="content-area">
        
        <!-- Info Header Transaksi -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"><strong>No. Transaksi:</strong> <?= isset($header->no_transaksi) ? $header->no_transaksi : '-' ?></div>
                    <div class="col-md-3"><strong>Tanggal:</strong> <?= isset($header->tanggal) ? date('d/m/Y', strtotime($header->tanggal)) : '-' ?></div>
                    <div class="col-md-3"><strong>Pengirim:</strong> <?= isset($header->nama_pengirim) ? $header->nama_pengirim : '-' ?></div>
                    <div class="col-md-3"><strong>Penerima:</strong> <?= isset($header->nama_penerima) ? $header->nama_penerima : '-' ?></div>
                    <div class="col-md-12 mt-2">
                        <strong>Status:</strong> 
                        <?php if (isset($header->status_serah) && $header->status_serah == 'diserahkan'): ?>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Sudah Diserahkan</span>
                            <small class="text-muted">(Oleh: <?= isset($header->nama_pengambil) ? $header->nama_pengambil : '-' ?>)</small>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Belum Diserahkan</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Per Linen -->
        <div class="card">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-tshirt me-2"></i> Rincian Jumlah Per Jenis Linen
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">No</th>
                                <th class="text-start">Nama Linen</th>
                                <th width="120">Jumlah Awal</th>
                                <th width="150">Jumlah Diserahkan</th>
                                <th width="130">Sisa / Belum Diambil</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $total_awal = 0;
                            $total_serah = 0;
                            $ada_item_diserahkan = false; // Flag untuk cek apakah ada data
                            
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
                                <td class="text-start fw-semibold"><?= isset($d->nama_pakaian) ? $d->nama_pakaian : '-' ?></td>
                                <td class="fw-bold"><?= $qty_awal ?></td>
                                <td class="fw-bold text-primary"><?= $qty_serah ?></td>
                                <td>
                                    <?php if ($sisa > 0): ?>
                                        <span class="badge bg-danger"><?= $sisa ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success">0</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-start small text-muted"><?= isset($d->keterangan) ? $d->keterangan : '-' ?></td>
                            </tr>
                            <?php 
                                    endif; // Tutup if qty_serah > 0
                                endforeach; 
                            endif; 

                            // Tampilkan pesan jika belum ada yang diserahkan sama sekali
                            if (!$ada_item_diserahkan): 
                            ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-info-circle me-2"></i>Belum ada linen yang diserahkan untuk transaksi ini.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-warning fw-bold">
                            <tr>
                                <td colspan="2" class="text-end">TOTAL KESELURUHAN</td>
                                <td><?= $total_awal ?></td>
                                <td><?= $total_serah ?></td>
                                <td><?= $total_awal - $total_serah ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-3 d-flex gap-2 no-print">
            <a href="<?= base_url('penyerahan/print_rincian/'.$header->id) ?>" target="_blank" class="btn btn-success">
                <i class="fas fa-print me-1"></i> Cetak / Print Rincian
            </a>
            <a href="<?= base_url('penyerahan') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>