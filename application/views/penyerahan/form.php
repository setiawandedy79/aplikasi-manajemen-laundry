<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-hand-holding me-2"></i> Form Penyerahan</h5>
    </div>
    <div class="content-area">
        <form action="<?= base_url('penyerahan/save') ?>" method="post">
            <input type="hidden" name="transaksi_id" value="<?= isset($header->id) ? $header->id : '' ?>">
            
            <!-- Info Header (Read-Only) -->
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">Informasi Transaksi</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3"><strong>No Transaksi:</strong> <?= isset($header->no_transaksi) ? $header->no_transaksi : '' ?></div>
                        <div class="col-md-3"><strong>Tanggal:</strong> <?= isset($header->tanggal) ? date('d/m/Y', strtotime($header->tanggal)) : '' ?></div>
                        <div class="col-md-3"><strong>Pengirim:</strong> <?= isset($header->nama_pengirim) ? $header->nama_pengirim : '' ?></div>
                        <div class="col-md-3"><strong>Penerima:</strong> <?= isset($header->nama_penerima) ? $header->nama_penerima : '' ?></div>
                    </div>
                </div>
            </div>

            <!-- Input Nama Pengambil -->
            <div class="card mb-3 border-primary">
                <div class="card-body">
                    <label class="form-label fw-bold text-primary"><i class="fas fa-user me-2"></i>Nama Pengambil / Penerima Serahan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pengambil" class="form-control form-control-lg" placeholder="Masukkan nama lengkap pengambil" required>
                </div>
            </div>

            <!-- Tabel Barang -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Daftar Linen & Jumlah Penyerahan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th width="50" class="text-center">No</th>
                                    <th class="text-center">Nama Linen</th>
                                    <th width="100" class="text-center">Kategori</th>
                                    <th width="80" class="text-center">Status</th>
                                    <th width="150" class="text-center">Jumlah Diserahkan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1; 
                                $ada_item_dipilih = false;
                                
                                if (!empty($detail)): 
                                    foreach ($detail as $d): 
                                        // 🔍 FILTER: Hanya tampilkan barang yang dicentang (Status = Ya)
                                        if ($d->ceklis == 1): 
                                            $ada_item_dipilih = true;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><strong><?= isset($d->nama_pakaian) ? $d->nama_pakaian : '' ?></strong></td>
                                    <td class="text-center"><span class="badge bg-info"><?= isset($d->kategori) ? $d->kategori : '' ?></span></td>
                                    <td class="text-center">
                                        <i class="fas fa-check-circle text-success"></i> Ya
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="detail_id[]" value="<?= isset($d->detail_id) ? $d->detail_id : '' ?>">
                                        <!-- ✅ HANYA KOLOM INI YANG BISA DIUBAH -->
                                        <input type="number" name="jumlah_diserahkan[]" class="form-control text-center fw-bold" 
                                               value="<?= isset($d->jumlah) ? $d->jumlah : 0 ?>" min="0" 
                                               style="border: 2px solid #2563eb; background: #f8fafc;">
                                    </td>
                                   <td>
                                        <input type="text" name="keterangan[]" class="form-control form-control-sm" 
                                               value="<?= isset($d->keterangan) ? $d->keterangan : '' ?>" placeholder="Edit keterangan...">
                                    </td>
                                </tr>
                                <?php 
                                        endif; // Tutup if ceklis
                                    endforeach; 
                                endif; 

                                // Tampilkan pesan jika tidak ada barang yang dicentang
                                if (!$ada_item_dipilih): 
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-info-circle me-2"></i>Tidak ada barang yang dipilih (dicentang) pada transaksi ini.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i> Simpan Penyerahan
                </button>
                <a href="<?= base_url('penyerahan') ?>" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>