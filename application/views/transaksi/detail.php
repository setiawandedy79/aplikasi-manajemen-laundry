<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-file-alt me-2"></i> Detail Transaksi</h5>
        <div>
            <a href="<?= base_url('transaksi/print/'.$header->id) ?>" target="_blank" class="btn btn-success btn-sm">
                <i class="fas fa-print me-1"></i> Print
            </a>
            <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="content-area">
        
        <!-- Info Header Transaksi -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th width="130">No Transaksi</th>
                                <td class="text-left">: <strong class="text-primary"><?= isset($header->no_transaksi) ? $header->no_transaksi : '-' ?></strong></td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td class="text-left">: <?= isset($header->tanggal) ? date('d/m/Y', strtotime($header->tanggal)) : '-' ?></td>
                            </tr>
                            <tr>
                                <th>Shift</th>
                                <td class="text-left">: 
                                    <?php 
                                        $shift_val = isset($header->shift) ? trim(strtolower($header->shift)) : '';
                                        $shift_badge = 'bg-secondary';
                                        $shift_display = '-';
                                        
                                        if ($shift_val == 'pagi') {
                                            $shift_badge = 'bg-warning text-dark';
                                            $shift_display = 'Pagi';
                                        } elseif ($shift_val == 'siang') {
                                            $shift_badge = 'bg-info';
                                            $shift_display = 'Siang';
                                        } elseif ($shift_val == 'sore') {
                                            $shift_badge = 'bg-secondary';
                                            $shift_display = 'Sore';
                                        } elseif ($shift_val == 'malam') {
                                            $shift_badge = 'bg-dark text-white';
                                            $shift_display = 'Malam';
                                        } elseif (!empty($shift_val)) {
                                            $shift_display = ucfirst($shift_val);
                                        }
                                    ?>
                                    <span class="badge <?= $shift_badge ?>"><?= $shift_display ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td class="text-left">: <?= isset($header->nama_pelanggan) ? $header->nama_pelanggan : '-' ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Laundry</th>
                                <td class="text-left">: 
                                    <?php 
                                        $jenis = isset($header->jenis_laundry) ? $header->jenis_laundry : 'Non Infeksius';
                                        $badge_jenis = ($jenis == 'Infeksius') ? 'bg-danger' : 'bg-success';
                                    ?>
                                    <span class="badge <?= $badge_jenis ?>"><?= $jenis ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <th width="130">Nama Pengirim</th>
                                <td class="text-left">: <?= isset($header->nama_pengirim) ? $header->nama_pengirim : '-' ?></td>
                            </tr>
                            <tr>
                                <th>Nama Penerima</th>
                                <td class="text-left">: <?= isset($header->nama_penerima) ? $header->nama_penerima : '-' ?></td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td class="text-left">: <?= isset($header->nama_lengkap) ? $header->nama_lengkap : '-' ?></td>
                            </tr>
                            <tr>
                                <th>Status Serah</th>
                                <td class="text-left">: 
                                    <?php if (isset($header->status_serah) && $header->status_serah == 'diserahkan'): ?>
                                        <span class="badge bg-success">Sudah Diserahkan</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum Diserahkan</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Detail Linen -->
        <div class="card">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-list me-2"></i> Detail Transaksi
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="50">No</th>
                                <th>Nama Linen</th>
                                <th width="120">Kategori</th>
                                <th width="100">Status</th>
                                <th width="100">Jumlah (Pcs)</th>
                                <th width="120">Berat (Kg)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $list_detail = isset($details) ? $details : (isset($detail) ? $detail : []);
                            
                            $no = 1;
                            $total_qty = 0; 
                            $total_kg = 0; 
                            $ada_data = false;
                            
                            if (!empty($list_detail)):
                                foreach ($list_detail as $d): 
                                    $qty = isset($d->jumlah) ? (int)$d->jumlah : 0;
                                    $kg  = isset($d->jumlah_kg) ? (float)$d->jumlah_kg : 0.00;
                                    
                                    if ($qty > 0 || $kg > 0):
                                        $ada_data = true;
                                        $total_qty += $qty;
                                        $total_kg  += $kg;
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-left" class="fw-semibold"><?= isset($d->nama_pakaian) ? $d->nama_pakaian : '-' ?></td>
                                <td class="text-center"><span class="badge bg-info"><?= isset($d->kategori) ? $d->kategori : '-' ?></span></td>
                                <td class="text-center">
                                    <?php if (isset($d->ceklis) && $d->ceklis == 1): ?>
                                        <span class="badge bg-success">Ya</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tidak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center fw-bold"><?= $qty ?></td>
                                <td class="text-center"><?= number_format($kg, 2) ?> Kg</td>
                                <td><?= isset($d->keterangan) ? $d->keterangan : '-' ?></td>
                            </tr>
                            <?php 
                                    endif;
                                endforeach;
                            endif;

                            if (!$ada_data):
                            ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    <i class="fas fa-info-circle me-2"></i>Tidak ada detail item yang memiliki jumlah/berat.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        
                        <?php if ($ada_data): ?>
                        <tfoot class="table-warning fw-bold">
                            <tr>
                                <td colspan="4" class="text-end">TOTAL KESELURUHAN</td>
                                <td class="text-center"><?= $total_qty ?> Pcs</td>
                                <td class="text-center"><?= number_format($total_kg, 2) ?> Kg</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>