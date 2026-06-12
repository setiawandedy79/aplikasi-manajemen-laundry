<div class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-tint"></i> Medika Laundry</h4>
        <small>Professional Laundry Management</small>
    </div>
    <nav class="sidebar-nav">
        <?php if (is_allowed('dashboard')): ?>
        <a href="<?= base_url('dashboard') ?>" class="<?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <?php endif; ?>

        <div class="nav-section">Master Data</div>
        <?php if (is_allowed('pakaian')): ?>
        <a href="<?= base_url('pakaian') ?>" class="<?= $this->uri->segment(1) == 'pakaian' ? 'active' : '' ?>">
            <i class="fas fa-tshirt"></i> Master Linen
        </a>
        <?php endif; ?>
        <?php if (is_allowed('supplier')): ?>
        <a href="<?= base_url('supplier') ?>" class="<?= $this->uri->segment(1) == 'supplier' ? 'active' : '' ?>">
            <i class="fas fa-truck"></i> Master Supplier
        </a>
        <?php endif; ?>
        <?php if (is_allowed('sabun')): ?>
        <a href="<?= base_url('sabun') ?>" class="<?= $this->uri->segment(1) == 'sabun' ? 'active' : '' ?>">
            <i class="fas fa-soap"></i> Master Sabun
        </a>
        <?php endif; ?>
        <?php if (is_allowed('satuan_sabun')): ?>
        <a href="<?= base_url('satuan_sabun') ?>" class="<?= $this->uri->segment(1) == 'satuan_sabun' ? 'active' : '' ?>">
            <i class="fas fa-balance-scale"></i> Master Satuan
        </a>
        <?php endif; ?>
        <?php if (is_allowed('pelanggan')): ?>
        <a href="<?= base_url('pelanggan') ?>" class="<?= $this->uri->segment(1) == 'pelanggan' ? 'active' : '' ?>">
            <i class="fas fa-users"></i> Master Pelanggan
        </a>
        <?php endif; ?>
        <?php if (is_allowed('users')): ?>
        <a href="<?= base_url('users') ?>" class="<?= $this->uri->segment(1) == 'users' ? 'active' : '' ?>">
            <i class="fas fa-user-cog"></i> Master User
        </a>
        <?php endif; ?>

        <div class="nav-section">Operasional</div>
        <?php if (is_allowed('transaksi')): ?>
        <a href="<?= base_url('transaksi') ?>" class="<?= $this->uri->segment(1) == 'transaksi' ? 'active' : '' ?>">
            <i class="fas fa-receipt"></i> Transaksi Laundry
        </a>
        <?php endif; ?>

        <?php if (is_allowed('penyerahan')): ?>
        <a href="<?= base_url('penyerahan') ?>" class="<?= $this->uri->segment(1) == 'penyerahan' ? 'active' : '' ?>">
            <i class="fas fa-hand-holding"></i> Penyerahan Laundry
        </a>
        <?php endif; ?>

        <?php if (is_allowed('mutasi')): ?>
        <a href="<?= base_url('mutasi') ?>" class="<?= $this->uri->segment(1) == 'mutasi' ? 'active' : '' ?>">
            <i class="fas fa-truck-loading"></i> Mutasi Masuk Chemical
        </a>
        
        <?php endif; ?>

        <?php if (is_allowed('pemakaian')): ?>
        <a href="<?= base_url('pemakaian') ?>" class="<?= $this->uri->segment(1) == 'pemakaian' ? 'active' : '' ?>">
            <i class="fas fa-clock"></i> Pemakaian Chemical
        </a>
        
        <?php endif; ?>
        
        <div class="nav-section">Laporan</div>
        <?php if (is_allowed('laporan')): ?>
        <a href="<?= base_url('laporan') ?>" class="<?= strpos($this->uri->uri_string(), 'laporan') !== false ? 'active' : '' ?>">
            <i class="fas fa-file-invoice"></i> Menu Laporan
        </a>
        <?php endif; ?>

        <!-- ✅ TAMBAHKAN MENU BARU INI -->
        <!-- <?php if (is_allowed('laporan')): ?>
        <a href="<?= base_url('laporan/pengambilan_linen') ?>" class="<?= $this->uri->segment(2) == 'pengambilan_linen' ? 'active' : '' ?>">
            <i class="fas fa-tshirt"></i> Laporan Pengambilan Linen
        </a>
        <?php endif; ?> -->


        <!-- ✅ MENU BARU: LAPORAN PENGEMBALIAN LINEN -->
        <!-- <?php if (is_allowed('laporan')): ?>
        <a href="<?= base_url('laporan/pengembalian_linen') ?>" class="<?= $this->uri->segment(2) == 'pengembalian_linen' ? 'active' : '' ?>">
            <i class="fas fa-undo"></i> Laporan Pengembalian Linen
        </a>
        <?php endif; ?> -->

        <!-- ✅ MENU BARU: REKAPITULASI PENCUCIAN -->
        <!-- <?php if (is_allowed('laporan')): ?>
        <a href="<?= base_url('laporan/rekapitulasi_pencucian') ?>" class="<?= $this->uri->segment(2) == 'rekapitulasi_pencucian' ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i> Rekapitulasi Pencucian Linen
        </a>
        <?php endif; ?> -->
        <!-- ✅ MENU BARU: LAPORAN PENGGUNAAN CHEMICAL -->
        <!-- <?php if (is_allowed('laporan')): ?>
        <a href="<?= base_url('laporan/penggunaan_chemical') ?>" class="<?= $this->uri->segment(2) == 'penggunaan_chemical' ? 'active' : '' ?>">
            <i class="fas fa-flask"></i> Laporan Penggunaan Chemical
        </a>
        <?php endif; ?> -->

        <!-- ✅ MENU BARU: REKAPITULASI CHEMICAL -->
       <!--  <?php if (is_allowed('laporan')): ?>
        <a href="<?= base_url('laporan/rekapitulasi_chemical') ?>" class="<?= $this->uri->segment(2) == 'rekapitulasi_chemical' ? 'active' : '' ?>">
            <i class="fas fa-chart-bar"></i> Rekapitulasi Chemical
        </a>
        <?php endif; ?> -->

        <!-- ✅ MENU BARU: Log Activity -->
        <?php if ($this->session->userdata('role') === 'admin'): ?>
        <div class="nav-section mt-3">Administrasi</div>
        <a href="<?= base_url('log_activity') ?>" class="<?= $this->uri->segment(1) == 'log_activity' ? 'active' : '' ?>">
            <i class="fas fa-history"></i> Log Aktivitas
        </a>
        <?php endif; ?>

        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px;">
            <a href="<?= base_url('auth/logout') ?>">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
</div>