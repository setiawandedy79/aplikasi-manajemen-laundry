<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-receipt me-2"></i> Detail Transaksi</h5>
    </div>
    <div class="content-area">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Detail Transaksi <?= $header->no_transaksi ?></h6>
                <div>
                    <a href="<?= base_url('transaksi/print/'.$header->id) ?>" class="btn btn-secondary btn-sm" target="_blank">
                        <i class="fas fa-print me-1"></i> Print
                    </a>
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><td width="140" class="text-muted">No Transaksi</td><td><strong><?= $header->no_transaksi ?></strong></td></tr>
                            <tr><td class="text-muted">Tanggal</td><td><?= date('d/m/Y', strtotime($header->tanggal)) ?></td></tr>
                            <tr><td class="text-muted">Shift</td><td><span class="badge <?= $header->shift == 'pagi' ? 'badge-shift-pagi' : 'badge-shift-siang' ?>"><?= ucfirst($header->shift) ?></span></td>
                                </tr>
                            <tr><td class="text-muted">Unit</td><td><?= $header->nama_pelanggan ?? '-' ?></td>
                            </tr>
                             <tr><td class="text-muted">Jenis Laundry</td>
                                <td>
                                    <?php 
                                    $jenis = isset($header->jenis_laundry) ? $header->jenis_laundry : 'Non Infeksius';
                                    $badge = ($jenis == 'Infeksius') ? 'bg-danger' : 'bg-success';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= $jenis ?></span>
                                </td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><td width="140" class="text-muted">Nama Pengirim</td><td><strong><?= $header->nama_pengirim ?></strong></td></tr>
                            <tr><td class="text-muted">Nama Penerima</td><td><strong><?= $header->nama_penerima ?></strong></td></tr>
                            <tr><td class="text-muted">Dibuat Oleh</td><td><?= $header->nama_lengkap ?></td></tr>
                            <tr>
                                <!-- <td class="text-muted">Status Penyerahan</td>
                                <td colspan="3">
                                    <small>
                                        <?php $status = isset($header->status_serah) ? $header->status_serah : 'belum'; ?>
                                        <?php if ($status == 'diserahkan'): ?>
                                            <span class="badge bg-success">Sudah Diserahkan</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Belum Diserahkan</span>
                                        <?php endif; ?>
                                    </small>
                                </td> -->
                            </tr>
                           <!-- <tr><td class="text-muted">Jenis Laundry</td> -->
                                <!-- <td>
                                    <?php 
                                    $jenis = isset($header->jenis_laundry) ? $header->jenis_laundry : 'Non Infeksius';
                                    $badge = ($jenis == 'Infeksius') ? 'bg-danger' : 'bg-success';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= $jenis ?></span>
                                </td> --></tr>
                            <!-- <tr><td class="text-muted">Unit</td><td><?= $header->nama_pelanggan ?? '-' ?></td> -->
                        </table>
                    </div>
                </div>

                <h6 class="fw-bold mb-3"><i class="fas fa-tshirt me-2 text-primary"></i>Detail Transaksi</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th class="text-center">Nama Linen</th>
                                <th width="100" class="text-center">Kategori</th>
                                <th width="80" class="text-center">Jumlah</th>
                                <th width="80" class="text-center">Berat (Kg)</th>
                                <th width="80" class="text-center">Status</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($detail as $d): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-left"><strong><?= $d->nama_pakaian ?></strong></td>
                                <td class="text-center"><span class="badge bg-info"><?= $d->kategori ?></span></td>
                                
                                <td class="text-center fw-bold"><?= $d->jumlah ?: 0 ?></td>
                                <td class="text-center"><?= isset($d->jumlah_kg) ? number_format($d->jumlah_kg, 2) : '0.00' ?> Kg</td>
                                
                                <td class="text-center">
                                <?php 
                                    // Casting ke integer agar PHP tidak bingung dengan string '0'/'1'
                                    $status = isset($d->ceklis) ? (int)$d->ceklis : 0; 
                                ?>
                                <?php if ($status === 1): ?>
                                    <i class="fas fa-check-square text-success" style="font-size: 1.3rem;" title="Dicentang"></i>
                                    <div class="small text-success mt-1">Ya</div>
                                <?php else: ?>
                                    <i class="far fa-square text-muted" style="font-size: 1.3rem;" title="Tidak dicentang"></i>
                                    <div class="small text-muted mt-1">Tidak</div>
                                <?php endif; ?>
                            </td>
                                <td><?= $d->keterangan ?: '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>