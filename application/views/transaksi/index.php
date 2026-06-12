<div class="content-area">
    <div class="main-content" style="margin-left: 165px !important;">
    <!-- <div class="topbar">...</div> -->
    <div class="content-area" style="padding-left: 65px !important;">
    <!-- 🔍 FORM PENCARIAN -->
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body py-2">
            <form method="get" action="<?= base_url('transaksi') ?>" class="row g-2 align-items-center">
                <div class="col-md-4 col-12">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Cari No. Transaksi, Pengirim, Penerima..." value="<?= $this->input->get('q') ?>">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search me-1"></i> Cari</button>
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-redo me-1"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Data Transaksi</h6>
            <a href="<?= base_url('transaksi/add') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Transaksi Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No Transaksi</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Pengirim</th>
                            <th class="text-center">Penerima</th>
                            <th class="text-center">Shift</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center" width="200">Aksi</th> <!-- Lebar diperbesar -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($transaksi as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><div class="fw-bold text-primary"><?= $row->no_transaksi ?></div>
                                <!-- <small class="text-muted">
                                    Status: 
                                    <?php $status = isset($row->status_serah) ? $row->status_serah : 'belum'; ?>
                                    <?php if ($status == 'diserahkan'): ?>
                                        <span class="text-success fw-semibold">Sudah Diserahkan</span>
                                    <?php else: ?>
                                        <span class="text-warning fw-semibold">Belum Diserahkan</span>
                                    <?php endif; ?>
                                </small> --></td>
                            <!-- <td><strong class="text-primary"><?= $row->no_transaksi ?></strong></td> -->
                            <td><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                            <td class="text-left"><?= isset($row->nama_pelanggan) ? $row->nama_pelanggan : '-' ?></td>
                            <td><?= $row->nama_pengirim ?></td>
                            <td><?= $row->nama_penerima ?></td>
                            <td>
                                <span class="badge <?= $row->shift == 'pagi' ? 'badge-shift-pagi' : 'badge-shift-siang' ?>">
                                    <?= ucfirst($row->shift) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php 
                                $j = isset($row->jenis_laundry) ? $row->jenis_laundry : 'Non Infeksius';
                                $cls = ($j == 'Infeksius') ? 'bg-danger' : 'bg-secondary';
                                ?>
                                <span class="badge <?= $cls ?>"><?= $j ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('transaksi/detail/'.$row->id) ?>" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="<?= base_url('transaksi/edit/'.$row->id) ?>" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('transaksi/print/'.$row->id) ?>" class="btn btn-secondary btn-sm" title="Print" target="_blank"><i class="fas fa-print"></i></a>
                                <a href="<?= base_url('transaksi/delete/'.$row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($transaksi)): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">
                            <?= !empty($keyword) ? 'Data tidak ditemukan untuk kata kunci: <strong>'.$keyword.'</strong>' : 'Belum ada transaksi' ?>
                        </td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>