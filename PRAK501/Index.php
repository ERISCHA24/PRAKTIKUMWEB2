<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:   #F5F0E8;
            --brown:   #3D2B1F;
            --gold:    #C8960C;
            --rust:    #A63D2F;
            --sage:    #4A6741;
            --shadow:  rgba(61,43,31,0.18);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url("https://img.freepik.com/premium-photo/too-many-books-library-library-inside-modern-library-interior-inside_179935-62265.jpg") center/cover no-repeat;
            pointer-events: none;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 56px 64px;
            box-shadow: 0 24px 64px var(--shadow);
            max-width: 520px;
            width: 90%;
            text-align: center;
            position: relative;
            border-top: 6px solid var(--brown);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -6px; left: 50%;
            transform: translateX(-50%);
            width: 80px; height: 6px;
            background: var(--gold);
            border-radius: 0 0 4px 4px;
        }

        .logo {
            font-size: 56px;
            margin-bottom: 16px;
            display: block;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--brown);
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 40px;
            letter-spacing: 0.04em;
        }

        .divider {
            width: 48px;
            height: 3px;
            background: var(--gold);
            margin: 0 auto 40px;
            border-radius: 2px;
        }

        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .menu-btn {
            display: block;
            text-decoration: none;
            padding: 16px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.03em;
            transition: all 0.22s ease;
            position: relative;
            overflow: hidden;
        }

        .menu-btn::after {
            content: '→';
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%) translateX(6px);
            opacity: 0;
            transition: all 0.22s ease;
        }

        .menu-btn:hover::after {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        .btn-member {
            background: var(--brown);
            color: #fff;
        }
        .btn-member:hover { background: #5a3d2b; transform: translateY(-2px); box-shadow: 0 8px 24px var(--shadow); }

        .btn-buku {
            background: var(--sage);
            color: #fff;
        }
        .btn-buku:hover { background: #3a5432; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(74,103,65,0.3); }

        .btn-peminjaman {
            background: var(--rust);
            color: #fff;
        }
        .btn-peminjaman:hover { background: #8a3225; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(166,61,47,0.3); }

        .footer-text {
            margin-top: 36px;
            font-size: 0.78rem;
            color: #bbb;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="card">
        <span class="logo">📚</span>
        <h1>Perpustakaan Digital</h1>
        <p class="subtitle">Sistem Informasi Manajemen Perpustakaan</p>
        <div class="divider"></div>

        <nav class="menu-list">
            <a href="Member.php" class="menu-btn btn-member">Data Member</a>
            <a href="Buku.php"   class="menu-btn btn-buku">Data Buku</a>
            <a href="Peminjaman.php" class="menu-btn btn-peminjaman">Data Peminjaman</a>
        </nav>

        <p class="footer-text">Erischa Marsela &mdash; Modul 5</p>
    </div>
</body>
</html>