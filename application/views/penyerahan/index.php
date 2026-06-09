<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-hand-holding me-2"></i> Penyerahan Laundry</h5>
    </div>
    <div class="content-area">
            <?php 
            // ✅ FIX PHP 8: Simpan hasil flashdata ke variabel dulu
            $flash_msg = $this->session->flashdata('success');
            if ($flash_msg): 
            ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?= $flash_msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Transaksi</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Nama Unit</th>
                               <!--  <th class="text-center">Pengirim</th>
                                <th class="text-center">Penerima</th> -->
                                <th class="text-center" width="100">Jumlah Awal</th>
                                <th class="text-center" width="130">Jumlah Diserahkan</th>
                                <th class="text-center">Status Serah</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($transaksi as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong class="text-primary"><?= $row->no_transaksi ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                                <td><?= isset($row->nama_pelanggan) ? $row->nama_pelanggan : '-' ?></td>
                                <!-- <td><?= $row->nama_pengirim ?></td>
                                <td><?= $row->nama_penerima ?></td> -->
                                <td class="text-center fw-bold"><?= isset($row->total_jumlah_awal) ? $row->total_jumlah_awal : 0 ?></td>
                                <td class="text-center fw-bold text-primary"><?= isset($row->total_jumlah_diserahkan) ? $row->total_jumlah_diserahkan : 0 ?></td>
                                <td>
                                    <?php if ($row->status_serah == 'diserahkan'): ?>
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Diserahkan</span>
                                        <br><small class="text-muted">Oleh: <?= isset($row->nama_pengambil) ? $row->nama_pengambil : '-' ?></small>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Belum</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row->status_serah == 'belum'): ?>
                                        <a href="<?= base_url('penyerahan/form/'.$row->id) ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-hand-holding me-1"></i> Serahkan
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('penyerahan/rincian/'.$row->id) ?>" class="btn btn-info btn-sm text-white">
                                            <i class="fas fa-list-alt me-1"></i> Rincian Linen
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($transaksi)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data transaksi</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>