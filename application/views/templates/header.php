<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Medika Laundry Pro</title>
      <!-- ✅ TAMBAHKAN KODE FAVICON DI SINI -->
    <link rel="icon" href="<?= base_url('washing-machine.png') ?>" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --sidebar-width: 260px;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f4f8;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #2563eb 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s;
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand h4 {
            font-weight: 700;
            margin: 0;
            font-size: 1.2rem;
        }
        .sidebar-brand small {
            opacity: 0.7;
            font-size: 0.7rem;
        }
        .sidebar-nav {
            padding: 10px 0;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            margin: 2px 0;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #60a5fa;
        }
        .sidebar-nav a i {
            width: 24px;
            margin-right: 12px;
            font-size: 1rem;
        }
        .nav-section {
            padding: 10px 20px 5px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.5;
        }
        /* Layout Utama */
        .main-content {
            margin-left: 260px; /* Gunakan nilai fix sebagai fallback */
            margin-left: var(--sidebar-width, 260px); /* Fallback aman */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: white;
        }

        .content-area {
            flex: 1;
            padding: 25px 25px 25px 35px; /* Tambah padding kiri 35px agar aman dari sidebar */
        }

        /* Responsif: layar tablet/HP sidebar sembunyi, konten full */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0 !important;
            }
            .content-area {
                padding: 15px !important;
            }
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        .stat-card {
            border-radius: 15px;
            padding: 25px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0 5px;
        }
        .stat-card p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.85rem;
        }
        .bg-gradient-primary { background: linear-gradient(135deg, #2563eb, #3b82f6); }
        .bg-gradient-success { background: linear-gradient(135deg, #10b981, #34d399); }
        .bg-gradient-warning { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .bg-gradient-danger { background: linear-gradient(135deg, #ef4444, #f87171); }
        .bg-gradient-info { background: linear-gradient(135deg, #06b6d4, #22d3ee); }
        .table th {
            font-weight: 600;
            background: #f8fafc;
            border-color: #e2e8f0;
        }
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .badge-shift-pagi { background: #fbbf24; color: #1e293b; }
        .badge-shift-siang { background: #3b82f6; color: white; }
        /*.table-checklist { width: 60px; text-align: center; }*/
        .table-checklist { width: 60px; }
        @media print {
            .sidebar, .topbar, .no-print { display: none !important; }
            .main-content { margin-left: 0 !important; }
            .card { box-shadow: none; border: 1px solid #ddd; }
        }
        /* 📝 Warna teks isi tabel (kolom data) */
        .table tbody td {
            color: #1e293b !important;
        }

        /* 🎨 Warna teks & background header tabel */
        .table thead th {
            color: #ffffff !important;
            background: linear-gradient(135deg, #1e3a5f, #2563eb);
        }

        /* 🔍 Opsional: hover baris tabel agar lebih jelas */
        .table-hover tbody tr:hover td {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }
        /* 🎯 Posisi tengah untuk semua sel data tabel */
        .table tbody td {
            text-align: center !important;
            vertical-align: middle !important; /* Agar teks pas di tengah secara vertikal */
        }

        /* ⬅️ Kecuali kolom berisi teks panjang (biar tetap rapi) */
        .table tbody td.text-left,
        .table tbody td.keterangan-col {
            text-align: left !important;
        }
        /* 📌 Layout Flexbox untuk Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-area {
            flex: 1; /* Mendorong footer ke bawah otomatis */
            padding: 25px;
        }

        /*  Styling Footer */
        .app-footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 16px 25px;
            text-align: center;
            color: #64748b;
            font-size: 0.82rem;
            margin-top: auto; /* Kunci agar footer selalu di bawah */
        }

        .copyright {
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        .copyright strong {
            color: var(--primary);
            font-weight: 600;
        }

        /* 📱 Responsif untuk Mobile */
        @media (max-width: 991.98px) {
            .main-content, .app-footer {
                margin-left: 0 !important;
            }
            .content-area {
                padding: 15px;
            }
        }
    </style>
</head>
<body>