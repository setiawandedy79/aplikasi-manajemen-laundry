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
        <?php if (is_allowed('mutasi')): ?>
        <a href="<?= base_url('mutasi') ?>" class="<?= $this->uri->segment(1) == 'mutasi' ? 'active' : '' ?>">
            <i class="fas fa-truck-loading"></i> Mutasi Masuk Sabun
        </a>
        
        <?php endif; ?>
        <?php if (is_allowed('pemakaian')): ?>
        <a href="<?= base_url('pemakaian') ?>" class="<?= $this->uri->segment(1) == 'pemakaian' ? 'active' : '' ?>">
            <i class="fas fa-clock"></i> Pemakaian Sabun
        </a>
        
        <?php endif; ?>
        <?php if (is_allowed('penyerahan')): ?>
        <a href="<?= base_url('penyerahan') ?>" class="<?= $this->uri->segment(1) == 'penyerahan' ? 'active' : '' ?>">
            <i class="fas fa-hand-holding"></i> Penyerahan Laundry
        </a>
        <?php endif; ?>

        <div class="nav-section">Laporan</div>
        <?php if (is_allowed('laporan')): ?>
        <a href="<?= base_url('laporan') ?>" class="<?= strpos($this->uri->uri_string(), 'laporan') !== false ? 'active' : '' ?>">
            <i class="fas fa-file-invoice"></i> Menu Laporan
        </a>
        <?php endif; ?>

        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px;">
            <a href="<?= base_url('auth/logout') ?>">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
</div>