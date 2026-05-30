<div class="main-content">
    <div class="topbar">
        <h5><i class="fas fa-file-invoice me-2"></i> Menu Laporan</h5>
    </div>
    <div class="content-area">
        <div class="row">
            <div class="col-md-6 mb-3">
                <a href="<?= base_url('laporan/mutasi_masuk') ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-truck-loading fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Mutasi Masuk Sabun</h5>
                            <p class="text-muted mb-0">Rekapitulasi data masuknya sabun</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <a href="<?= base_url('laporan/pemakaian_shift') ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-clock fa-3x text-success mb-3"></i>
                            <h5 class="fw-bold">Pemakaian Sabun Per Shift</h5>
                            <p class="text-muted mb-0">Laporan pemakaian pagi & siang</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <a href="<?= base_url('laporan/stok_sabun') ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-boxes fa-3x text-warning mb-3"></i>
                            <h5 class="fw-bold">Stok Sabun</h5>
                            <p class="text-muted mb-0">Stok awal, pemakaian & stok akhir</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <a href="<?= base_url('laporan/transaksi') ?>" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-file-alt fa-3x text-info mb-3"></i>
                            <h5 class="fw-bold">Laporan Transaksi</h5>
                            <p class="text-muted mb-0">Rekap semua transaksi laundry</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>