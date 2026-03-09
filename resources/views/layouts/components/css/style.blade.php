<link href="{{ asset('templating/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<link href="{{ asset('templating/css/sb-admin-2.min.css') }}" rel="stylesheet">

<style>
    body {
        background: url('https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=2070') center/cover no-repeat;
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.45);
        z-index: -1;
    }

    /* SIDEBAR */

    .wedding-sidebar {
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(6px);
        min-height: 100vh;
        padding-top: 10px;
    }

    .brand-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        color: #d4af37;
        font-weight: 600;
    }

    .wedding-sidebar .nav-link {
        color: #eee;
        font-size: 15px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .wedding-sidebar .nav-link i {
        width: 20px;
    }

    .wedding-sidebar .nav-link:hover {
        background: rgba(212, 175, 55, 0.15);
        color: #d4af37;
        border-left: 3px solid #d4af37;
    }

    .wedding-sidebar .nav-item.active .nav-link {
        background: rgba(212, 175, 55, 0.2);
        color: #d4af37;
        border-left: 3px solid #d4af37;
    }
</style>

@stack('style-css')
