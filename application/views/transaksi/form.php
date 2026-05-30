<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-receipt me-2"></i> Tambah Transaksi Laundry</h5>
    </div>
    <div class="content-area">
        <!-- SATU FORM UTAMA UNTUK SEMUA INPUT -->
        <!-- <form action="<?= base_url('transaksi/save') ?>" method="post"> -->
            <form action="<?= base_url(isset($is_edit) && $is_edit ? 'transaksi/update/'.$transaksi_id : 'transaksi/save') ?>" method="post">  

            <!-- Bagian Header -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Informasi Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">No Transaksi</label>
                                <input type="text" name="no_transaksi" class="form-control" value="<?= isset($no_transaksi) ? $no_transaksi : '' ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-500">No Transaksi</label>
                                    <input type="text" name="no_transaksi" class="form-control" value="<?= isset($no_transaksi) ? $no_transaksi : '' ?>" readonly>
                                    <!-- <small class="text-muted">
                                        Status: 
                                        <?php $status = isset($header->status_serah) ? $header->status_serah : 'belum'; ?>
                                        <?= $status == 'diserahkan' ? '<span class="text-success fw-semibold">Sudah Diserahkan</span>' : '<span class="text-warning fw-semibold">Belum Diserahkan</span>' ?>
                                    </small> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="<?= isset($header) && $header->tanggal ? $header->tanggal : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">Shift <span class="text-danger">*</span></label>
                                <select name="shift" class="form-select" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="pagi" <?= (isset($header) && $header->shift == 'pagi') ? 'selected' : '' ?>>Pagi (06:00 - 14:00)</option>
                                    <option value="siang" <?= (isset($header) && $header->shift == 'siang') ? 'selected' : '' ?>>Siang (14:00 - 22:00)</option>
                                </select>
                            </div>
                           
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">Pelanggan</label>
                                <select name="pelanggan_id" class="form-select">
                                    <option value="">Pilih Pelanggan</option>
                                    <?php foreach ($pelanggan as $p): ?>
                                    <option value="<?= $p->id ?>" <?= (isset($header) && $header->pelanggan_id == $p->id) ? 'selected' : '' ?>><?= $p->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Nama Pengirim <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pengirim" class="form-control" value="<?= isset($header) ? $header->nama_pengirim : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-500">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" name="nama_penerima" class="form-control" value="<?= isset($header) ? $header->nama_penerima : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-500">Jenis Laundry <span class="text-danger">*</span></label>
                                <select name="jenis_laundry" class="form-select" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="Infeksius" <?= (isset($header) && $header->jenis_laundry == 'Infeksius') ? 'selected' : '' ?>>
                                        🦠 Infeksius
                                    </option>
                                    <option value="Non Infeksius" <?= (isset($header) && ($header->jenis_laundry == 'Non Infeksius' || empty($header->jenis_laundry))) ? 'selected' : '' ?>>
                                        🛡️ Non Infeksius
                                    </option>
                                </select>
                                <small class="text-muted">Pilih kategori risiko linen</small>
                            </div>
                        </div>
                    </div>
                   
            </div>

            <!-- Bagian Detail Barang -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-tshirt me-2 text-primary"></i>Daftar Linen</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th width="60" class="text-center">No</th>
                                    <th class="text-center">Nama Linen</th>
                                    <th class="text-center">Kategori</th>
                                    <th width="80" class="text-center">Ceklis</th>
                                    <th width="100" class="text-center">Jumlah</th>
                                    <th width="100" class="text-center">Berat (Kg)</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; foreach ($pakaian as $p): ?>
                                    <?php 
                                        //  Logic Pre-fill untuk Mode Edit
                                        $checked = false; $jumlah_val = 0; $kg_val = 0.00; $ket_val = '';
                                        if (isset($detail) && !empty($detail)) {
                                            foreach ($detail as $d) {
                                                if ($d->pakaian_id == $p->id) {
                                                    $checked  = ($d->ceklis == 1);
                                                    $jumlah_val = $d->jumlah;
                                                    $kg_val   = isset($d->jumlah_kg) ? $d->jumlah_kg : 0.00;
                                                    $ket_val  = $d->keterangan;
                                                    break;
                                                }
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><strong><?= $p->nama_pakaian ?></strong></td>
                                        <td class="text-center"><span class="badge bg-info"><?= $p->kategori ?></span></td>
                                        
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input type="hidden" name="ceklis[<?= $i ?>]" value="0">
                                                <input type="checkbox" name="ceklis[<?= $i ?>]" value="1" class="form-check-input" <?= $checked ? 'checked' : '' ?> style="width: 22px; height: 22px;">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" name="jumlah[<?= $i ?>]" class="form-control form-control-sm text-center" value="<?= $jumlah_val ?>" min="0" style="max-width: 80px;">
                                        </td>
                                        <td class="text-center">
                                            <!-- ✅ INPUT BERAT KG (step 0.01 untuk desimal) -->
                                            <input type="number" step="0.01" name="jumlah_kg[<?= $i ?>]" class="form-control form-control-sm text-center" value="<?= $kg_val ?>" min="0" style="max-width: 100px;">
                                        </td>
                                        <td>
                                            <input type="hidden" name="pakaian_id[<?= $i ?>]" value="<?= $p->id ?>">
                                            <input type="text" name="keterangan[<?= $i ?>]" class="form-control form-control-sm" placeholder="Keterangan..." value="<?= $ket_val ?>">
                                        </td>
                                    </tr>
                                <?php $i++; endforeach; ?>
                                <!-- <?php 
                                $i = 0; 
                                if (!empty($pakaian)):
                                    foreach ($pakaian as $p): 
                                ?>
                                
                                <?php 
                                        $i++; 
                                    endforeach; 
                                else: 
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data linen. <a href="<?= base_url('pakaian/add') ?>">Tambah data</a> terlebih dahulu.
                                    </td>
                                </tr>
                                <?php endif; ?> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan (Di dalam form yang sama) -->
            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> <?= isset($is_edit) && $is_edit ? 'Update Transaksi' : 'Simpan Transaksi' ?>
                </button>
                    <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
            </div>
            <!-- <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Transaksi
                </button>
                <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div> -->
        </form> <!-- Tutup form utama di sini -->
    </div>
</div>