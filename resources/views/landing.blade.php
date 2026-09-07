<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Key - Sistem Akses & Monitoring Karyawan</title>
    <meta name="description" content="Smart Key adalah sistem akses dan monitoring karyawan berbasis RFID & IoT untuk proses checkin, checkout, monitoring, dan pelaporan aktivitas secara terintegrasi.">

    <style>
        :root {
            --primary: #ed1c24;
            --primary-dark: #c9151c;
            --primary-soft: #fff1f2;
            --text: #172033;
            --muted: #667085;
            --line: #e7eaf0;
            --surface: #ffffff;
            --surface-alt: #f7f8fb;
            --success: #16a34a;
            --shadow: 0 18px 50px rgba(22, 32, 51, 0.08);
            --radius-lg: 28px;
            --radius-md: 18px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background: #0d1117;
        }

        main {
            background:
                radial-gradient(circle at 10% 18%, rgba(237, 28, 36, 0.10), transparent 25%),
                radial-gradient(circle at 92% 66%, rgba(56, 68, 88, 0.22), transparent 28%),
                linear-gradient(180deg, #111720 0%, #0f141c 48%, #0b1017 100%);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        .container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background:
                linear-gradient(
                    90deg,
                    rgba(12, 8, 10, 0.78) 0%,
                    rgba(12, 8, 10, 0.48) 36%,
                    rgba(12, 8, 10, 0.20) 68%,
                    rgba(12, 8, 10, 0.10) 100%
                );
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: none;
            backdrop-filter: blur(5px);
        }

        .nav-inner {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand img {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .brand-copy strong {
            display: block;
            font-size: 18px;
            line-height: 1.1;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0,0,0,.35);
        }

        .brand-copy span {
            display: block;
            margin-top: 4px;
            color: rgba(255,255,255,.72);
            font-size: 11px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 26px;
            font-size: 14px;
            font-weight: 650;
            color: rgba(255,255,255,.90);
        }

        .nav-links a {
            transition: color .2s ease;
        }

        .nav-links a:hover {
            color: #ffffff;
        }

        .nav-links a {
            position: relative;
        }

        .nav-links a::after {
            content: "";
            position: absolute;
            left: 0;
            right: 100%;
            bottom: -8px;
            height: 2px;
            border-radius: 999px;
            background: var(--primary);
            transition: right .2s ease;
        }

        .nav-links a:hover::after {
            right: 0;
        }

        .nav-links a.is-active {
            color: #ffffff;
        }

        .nav-links a.is-active::after {
            right: 0;
        }

        .navbar.is-scrolled {
            background: rgba(10, 15, 22, 0.92);
            border-bottom-color: rgba(255,255,255,.10);
            box-shadow: 0 10px 30px rgba(0,0,0,.22);
            backdrop-filter: blur(16px);
        }

        #home,
        #tentang,
        #fitur,
        #alur,
        #role {
            scroll-margin-top: 92px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 18px;
            border-radius: 12px;
            border: 1px solid transparent;
            font-weight: 750;
            font-size: 14px;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-outline {
            border-color: rgba(255,255,255,.58);
            background: rgba(255,255,255,.08);
            color: #ffffff;
            backdrop-filter: blur(8px);
        }

        .btn-outline:hover {
            border-color: rgba(255,255,255,.88);
            background: rgba(255,255,255,.14);
            box-shadow: 0 10px 24px rgba(0,0,0,.18);
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 10px 24px rgba(237, 28, 36, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 14px 28px rgba(237, 28, 36, 0.26);
        }

        .hero {
            position: relative;
            min-height: 760px;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 150px 0 120px;
            background:
                linear-gradient(
                    90deg,
                    rgba(15, 8, 10, 0.72) 0%,
                    rgba(15, 8, 10, 0.56) 30%,
                    rgba(15, 8, 10, 0.18) 58%,
                    rgba(15, 8, 10, 0.04) 100%
                ),
                url('/images/landing-telkom-hd.png') center/cover no-repeat;
        }

        .hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 210px;
            background: linear-gradient(180deg, rgba(13,17,23,0), #111720 94%);
            pointer-events: none;
        }

        .hero-grid {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr;
            align-items: center;
            gap: 0;
        }

        .eyebrow {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .eyebrow-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            box-shadow: 0 0 0 5px rgba(237, 28, 36, 0.12);
        }

        .hero h1 {
            margin: 22px 0 18px;
            max-width: 760px;
            font-size: clamp(50px, 6vw, 82px);
            line-height: .98;
            letter-spacing: -0.045em;
            color: #ffffff;
            text-shadow: 0 8px 30px rgba(0,0,0,.25);
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            max-width: 650px;
            margin: 0;
            color: rgba(255,255,255,.86);
            font-size: 18px;
            line-height: 1.75;
            text-shadow: 0 3px 16px rgba(0,0,0,.2);
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .hero-actions .btn {
            min-height: 50px;
            padding: 0 22px;
        }

        .hero .btn-outline {
            border-color: rgba(255,255,255,.45);
            background: rgba(20,20,20,.18);
            color: #ffffff;
            backdrop-filter: blur(8px);
        }

        .hero .btn-outline:hover {
            border-color: rgba(255,255,255,.78);
            background: rgba(255,255,255,.10);
            box-shadow: 0 12px 28px rgba(0,0,0,.18);
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 30px;
            color: rgba(255,255,255,.92);
            font-size: 13px;
            font-weight: 700;
        }

        .hero-meta span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .hero-meta i {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255,255,255,.16);
            color: #ffffff;
            font-style: normal;
            font-size: 12px;
            font-weight: 900;
            border: 1px solid rgba(255,255,255,.24);
        }

        .hero-visual {
            display: none;
        }

        .hero-visual::before {
            content: "";
            position: absolute;
            inset: 30px 20px 10px 10px;
            border-radius: 50px;
            background: linear-gradient(135deg, rgba(237, 28, 36, 0.12), rgba(237, 28, 36, 0.025));
            transform: rotate(-4deg);
        }

        .visual-card {
            position: relative;
            width: min(100%, 510px);
            min-height: 410px;
            overflow: hidden;
            border: 1px solid #edf0f4;
            border-radius: 32px;
            background: #fff;
            box-shadow: var(--shadow);
            padding: 30px;
        }

        .visual-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .visual-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .visual-brand img {
            width: 68px;
            height: 68px;
            object-fit: contain;
        }

        .visual-brand strong {
            display: block;
            font-size: 16px;
        }

        .visual-brand span {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 12px;
        }

        .live-badge {
            padding: 7px 10px;
            border-radius: 999px;
            background: #ecfdf3;
            color: #15803d;
            font-size: 11px;
            font-weight: 800;
        }

        .access-card {
            margin-top: 28px;
            border: 1px solid #edf0f4;
            border-radius: 22px;
            background: linear-gradient(180deg, #fff, #fafbfc);
            padding: 22px;
        }

        .access-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .access-title span:first-child {
            color: var(--muted);
            font-size: 12px;
            font-weight: 750;
        }

        .access-title span:last-child {
            color: #15803d;
            font-size: 12px;
            font-weight: 800;
        }

        .rfid-box {
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #e8ebef;
        }

        .rfid-icon {
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 26px;
        }

        .rfid-copy strong {
            display: block;
            font-size: 15px;
        }

        .rfid-copy span {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 12px;
        }

        .mini-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 18px;
        }

        .mini-stat {
            border: 1px solid #edf0f4;
            border-radius: 14px;
            background: #fff;
            padding: 14px;
        }

        .mini-stat span {
            display: block;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
        }

        .mini-stat strong {
            display: block;
            margin-top: 6px;
            font-size: 20px;
        }

        section {
            padding: 68px 0;
            position: relative;
        }

        .section-soft {
            background:
                radial-gradient(circle at 18% 10%, rgba(237, 28, 36, 0.08), transparent 22%),
                radial-gradient(circle at 86% 78%, rgba(255,255,255,0.025), transparent 24%),
                linear-gradient(180deg, #121924 0%, #0f151e 100%);
            border-top: 1px solid rgba(255,255,255,.06);
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        main > section:not(.hero):not(.section-soft):not(.cta) {
            background:
                radial-gradient(circle at 82% 10%, rgba(237, 28, 36, 0.055), transparent 24%),
                linear-gradient(180deg, #101720 0%, #0d131b 100%);
        }

        #fitur {
            background:
                radial-gradient(circle at 12% 12%, rgba(237, 28, 36, 0.08), transparent 24%),
                radial-gradient(circle at 90% 82%, rgba(255,255,255,0.025), transparent 24%),
                linear-gradient(180deg, #0f151d 0%, #0b1118 100%);
        }

        #role {
            background:
                radial-gradient(circle at 88% 12%, rgba(237, 28, 36, 0.075), transparent 24%),
                linear-gradient(180deg, #101720 0%, #0c1219 100%);
        }

        #tentang,
        #fitur,
        #alur,
        #role {
            overflow: hidden;
        }

        #tentang::before,
        #fitur::before,
        #alur::before,
        #role::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(237, 28, 36, 0.08);
            filter: blur(28px);
            pointer-events: none;
        }

        #tentang::before {
            top: -90px;
            right: -90px;
        }

        #fitur::before {
            bottom: -110px;
            left: -90px;
        }

        #alur::before {
            top: -100px;
            left: -100px;
        }

        #role::before {
            bottom: -100px;
            right: -100px;
        }

        .section-heading {
            max-width: 760px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .section-heading .eyebrow {
            margin: 0 auto;
            background: rgba(237, 28, 36, .12);
            color: #ff7378;
            border: 1px solid rgba(237, 28, 36, .16);
        }

        .section-heading h2 {
            margin: 16px 0 12px;
            font-size: clamp(34px, 4vw, 50px);
            letter-spacing: -0.04em;
            color: #f8fafc;
            line-height: 1.08;
        }

        .section-heading p {
            margin: 0;
            color: #9aa7b8;
            font-size: 16px;
            line-height: 1.75;
        }

        .feature-showcase {
            position: relative;
            z-index: 3;
            margin-top: -72px;
            padding-bottom: 42px;
            background: linear-gradient(180deg, rgba(17,23,32,0) 0%, #111720 64%, #111720 100%);
        }

        .feature-showcase .feature-grid {
            background: rgba(20, 28, 39, .86);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 26px;
            padding: 18px;
            backdrop-filter: blur(18px);
            box-shadow: 0 28px 70px rgba(0,0,0,.32);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .feature-card {
            min-height: 240px;
            padding: 24px;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: var(--radius-md);
            background:
                linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018)),
                #151d28;
            box-shadow: 0 16px 34px rgba(0,0,0,.18);
            transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(237, 28, 36, .42);
            box-shadow: 0 20px 44px rgba(0,0,0,.28);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 22px;
        }

        .feature-card h3 {
            margin: 20px 0 10px;
            font-size: 18px;
            color: #f8fafc;
        }

        .feature-card p {
            margin: 0;
            color: #98a5b5;
            line-height: 1.7;
            font-size: 14px;
        }

        .workflow {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            align-items: stretch;
        }

        .workflow-item {
            position: relative;
            padding: 24px 18px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,.08);
            background: linear-gradient(180deg, rgba(255,255,255,.045), rgba(255,255,255,.015));
            text-align: center;
            box-shadow: 0 14px 30px rgba(0,0,0,.16);
        }

        .workflow-number {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            font-size: 13px;
            font-weight: 850;
        }

        .workflow-item h3 {
            margin: 0 0 8px;
            font-size: 15px;
            color: #f8fafc;
        }

        .workflow-item p {
            margin: 0;
            color: #95a1b0;
            font-size: 12px;
            line-height: 1.55;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .role-card {
            padding: 24px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,.08);
            background: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.015));
            box-shadow: 0 14px 30px rgba(0,0,0,.16);
            transition: transform .2s ease, border-color .2s ease;
        }

        .role-card:hover {
            transform: translateY(-4px);
            border-color: rgba(237, 28, 36, .38);
        }

        .role-card strong {
            display: block;
            font-size: 16px;
            color: #f8fafc;
        }

        .role-card p {
            margin: 8px 0 0;
            color: #97a4b4;
            font-size: 13px;
            line-height: 1.6;
        }

        .cta {
            padding: 52px 0 88px;
            background:
                radial-gradient(circle at 12% 20%, rgba(237,28,36,.10), transparent 26%),
                linear-gradient(180deg, #0d131b 0%, #090e14 100%);
        }

        .cta-card {
            display: grid;
            grid-template-columns: 1.3fr .7fr;
            align-items: center;
            gap: 28px;
            padding: 44px;
            border-radius: 28px;
            color: #fff;
            border: 1px solid rgba(255,255,255,.08);
            background:
                radial-gradient(circle at 88% 18%, rgba(255,255,255,.16), transparent 28%),
                linear-gradient(135deg, #ef1f2a 0%, #c5151d 48%, #921117 100%);
            box-shadow: 0 30px 70px rgba(144, 12, 18, .32);
        }

        .cta-card h2 {
            margin: 0;
            font-size: clamp(30px, 4vw, 44px);
            letter-spacing: -0.03em;
        }

        .cta-card p {
            margin: 12px 0 0;
            max-width: 650px;
            color: rgba(255,255,255,.82);
            line-height: 1.65;
        }

        .cta-actions {
            display: flex;
            justify-content: flex-end;
        }

        .cta-actions .btn {
            background: #fff;
            color: var(--primary-dark);
            min-height: 50px;
            padding: 0 22px;
        }

        footer {
            border-top: 1px solid rgba(255,255,255,.07);
            background: linear-gradient(180deg, #090e14 0%, #070b10 100%);
        }

        .footer-inner {
            min-height: 96px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            color: #7f8b9b;
            font-size: 13px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #f8fafc;
            font-weight: 800;
        }

        .footer-brand img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .mobile-toggle {
            display: none;
            border: 1px solid rgba(255,255,255,.42);
            background: rgba(255,255,255,.08);
            color: #ffffff;
            border-radius: 10px;
            width: 42px;
            height: 42px;
            font-size: 19px;
            cursor: pointer;
            backdrop-filter: blur(8px);
        }

        @media (max-width: 980px) {
            .nav-links {
                display: none;
                position: absolute;
                left: 20px;
                right: 20px;
                top: 86px;
                padding: 18px;
                border: 1px solid var(--line);
                border-radius: 16px;
                background: rgba(12, 17, 24, .96);
                border-color: rgba(255,255,255,.10);
                box-shadow: 0 18px 42px rgba(0,0,0,.28);
                backdrop-filter: blur(18px);
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .nav-links.is-open {
                display: flex;
            }

            .mobile-toggle {
                display: inline-grid;
                place-items: center;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 34px;
            }

            .hero-visual {
                min-height: unset;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .workflow {
                grid-template-columns: repeat(2, 1fr);
            }

            .roles-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cta-card {
                grid-template-columns: 1fr;
            }

            .cta-actions {
                justify-content: flex-start;
            }
        }

        @media (max-width: 640px) {
            .container {
                width: min(100% - 28px, 1180px);
            }

            .nav-inner {
                min-height: 70px;
            }

            .brand img {
                width: 44px;
                height: 44px;
            }

            .brand-copy span,
            .nav-actions .btn-outline {
                display: none;
            }

            .nav-actions {
                margin-left: auto;
            }

            .nav-actions .btn-primary {
                min-height: 40px;
                padding: 0 14px;
            }

            .hero {
                min-height: 650px;
                padding: 122px 0 110px;
                background-position: 58% center;
            }

            .hero h1 {
                font-size: 47px;
            }

            .hero p {
                font-size: 16px;
            }

            .visual-card {
                min-height: auto;
                padding: 22px;
                border-radius: 24px;
            }

            .visual-brand img {
                width: 54px;
                height: 54px;
            }

            .mini-stats,
            .feature-grid,
            .workflow,
            .roles-grid {
                grid-template-columns: 1fr;
            }

            section {
                padding: 58px 0;
            }

            .cta-card {
                padding: 28px;
            }

            .footer-inner {
                padding: 22px 0;
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="container nav-inner">
            <a href="#home" class="brand" aria-label="Smart Key Home">
                <img src="/images/1000452284.png" alt="Smart Key Logo">
                <div class="brand-copy">
                    <strong>Smart Key</strong>
                    <span>Access & Employee Monitoring</span>
                </div>
            </a>

            <nav class="nav-links" id="navLinks">
                <a href="#home">Home</a>
                <a href="#tentang">Tentang</a>
                <a href="#fitur">Fitur</a>
                <a href="#alur">Cara Kerja</a>
                <a href="#role">Role</a>
            </nav>

            <div class="nav-actions">
                <a class="btn btn-outline" href="{{ route('register') }}">Register</a>
                <a class="btn btn-primary" href="{{ route('login') }}">Masuk</a>

                <button
                    type="button"
                    class="mobile-toggle"
                    id="mobileToggle"
                    aria-label="Buka menu"
                    aria-expanded="false"
                >
                    ☰
                </button>
            </div>
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="container hero-grid">
                <div>
                    <div class="eyebrow">
                        <span class="eyebrow-dot"></span>
                        RFID & IoT Employee Access System
                    </div>

                    <h1>
                        Akses karyawan lebih
                        <span>aman, cepat, dan terpantau.</span>
                    </h1>

                    <p>
                        Smart Key membantu proses akses, Checkin/Checkout, monitoring aktivitas,
                        manajemen karyawan, serta pelaporan melalui sistem terintegrasi berbasis RFID dan IoT.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn btn-primary">Masuk ke Smart Key</a>
                        <a href="#fitur" class="btn btn-outline">Pelajari Fitur</a>
                    </div>

                    <div class="hero-meta">
                        <span><i>✓</i> Monitoring aktivitas</span>
                        <span><i>✓</i> Manajemen karyawan</span>
                        <span><i>✓</i> Integrasi RFID & IoT</span>
                    </div>
                </div>

                <div class="hero-visual" aria-hidden="true">
                    <div class="visual-card">
                        <div class="visual-top">
                            <div class="visual-brand">
                                <img src="/images/1000452284.png" alt="">
                                <div>
                                    <strong>Smart Key</strong>
                                    <span>Employee Access Monitoring</span>
                                </div>
                            </div>

                            <div class="live-badge">● System Active</div>
                        </div>

                        <div class="access-card">
                            <div class="access-title">
                                <span>RFID ACCESS</span>
                                <span>Connected</span>
                            </div>

                            <div class="rfid-box">
                                <div class="rfid-icon">◉</div>
                                <div class="rfid-copy">
                                    <strong>Tap ID Card</strong>
                                    <span>Identitas diverifikasi melalui Smart Box</span>
                                </div>
                            </div>

                            <div class="mini-stats">
                                <div class="mini-stat">
                                    <span>CHECKIN</span>
                                    <strong>12</strong>
                                </div>
                                <div class="mini-stat">
                                    <span>CHECKOUT</span>
                                    <strong>10</strong>
                                </div>
                                <div class="mini-stat">
                                    <span>ACTIVE</span>
                                    <strong>24</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="feature-showcase">
            <div class="container">
                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon">📡</div>
                        <h3>Akses RFID</h3>
                        <p>Identifikasi karyawan dengan cepat dan akurat.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">⏱</div>
                        <h3>Monitoring Real-time</h3>
                        <p>Pantau aktivitas akses secara langsung.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">👥</div>
                        <h3>Manajemen Karyawan</h3>
                        <p>Kelola data dan status karyawan secara terpusat.</p>
                    </article>
                </div>
            </div>
        </div>

        <section class="section-soft" id="tentang">
            <div class="container">
                <div class="section-heading">
                    <div class="eyebrow">Tentang Smart Key</div>
                    <h2>Satu sistem untuk akses dan monitoring operasional.</h2>
                    <p>
                        Smart Key dirancang untuk membantu pengelolaan akses karyawan secara lebih terstruktur,
                        mulai dari identifikasi RFID, proses Checkin/Checkout, pemantauan aktivitas,
                        hingga pengelolaan data karyawan dan laporan.
                    </p>
                </div>
            </div>
        </section>

        <section id="fitur">
            <div class="container">
                <div class="section-heading">
                    <div class="eyebrow">Fitur Utama</div>
                    <h2>Dibangun untuk kebutuhan operasional yang nyata.</h2>
                    <p>
                        Fokus pada keamanan akses, keterlacakan aktivitas, dan kemudahan pengelolaan data.
                    </p>
                </div>

                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon">📡</div>
                        <h3>RFID & IoT Access</h3>
                        <p>Identifikasi karyawan melalui kartu RFID yang terhubung dengan Smart Box dan sistem backend.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">⏱</div>
                        <h3>Checkin / Checkout</h3>
                        <p>Mencatat waktu Checkin dan Checkout serta aktivitas akses secara terstruktur.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Monitoring Aktivitas</h3>
                        <p>Dashboard menampilkan statistik akses, grafik aktivitas, dan tabel aktivitas terbaru.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">👥</div>
                        <h3>Manajemen Karyawan</h3>
                        <p>Super Admin dapat menambah, melihat detail, mengedit, menonaktifkan, dan mengelola data karyawan.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">🗂</div>
                        <h3>History & Laporan</h3>
                        <p>Riwayat aktivitas tersimpan untuk kebutuhan monitoring, audit, dan pelaporan operasional.</p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-icon">🔐</div>
                        <h3>Role & Access Control</h3>
                        <p>Akses halaman dan fitur dapat dibedakan berdasarkan peran pengguna di dalam sistem.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section-soft" id="alur">
            <div class="container">
                <div class="section-heading">
                    <div class="eyebrow">Cara Kerja</div>
                    <h2>Alur akses yang sederhana dan terkontrol.</h2>
                    <p>
                        Proses dirancang agar aktivitas karyawan mudah dipantau dari awal akses sampai Checkout.
                    </p>
                </div>

                <div class="workflow">
                    <div class="workflow-item">
                        <div class="workflow-number">01</div>
                        <h3>Tap RFID</h3>
                        <p>Karyawan melakukan tap kartu pada perangkat RFID.</p>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-number">02</div>
                        <h3>Validasi</h3>
                        <p>Sistem memeriksa identitas dan status karyawan.</p>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-number">03</div>
                        <h3>Smart Box</h3>
                        <p>Akses dikaitkan dengan Smart Box dan area kerja.</p>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-number">04</div>
                        <h3>Checkin</h3>
                        <p>Aktivitas Checkin tercatat dan masuk ke monitoring.</p>
                    </div>

                    <div class="workflow-item">
                        <div class="workflow-number">05</div>
                        <h3>Checkout</h3>
                        <p>Aktivitas ditutup dan histori tersimpan di sistem.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="role">
            <div class="container">
                <div class="section-heading">
                    <div class="eyebrow">Role Sistem</div>
                    <h2>Akses disesuaikan dengan kebutuhan pengguna.</h2>
                    <p>
                        Setiap pengguna dapat memiliki hak akses berbeda agar operasional tetap terkontrol.
                    </p>
                </div>

                <div class="roles-grid">
                    <div class="role-card">
                        <strong>Super Admin</strong>
                        <p>Mengelola dashboard, data karyawan, status karyawan, history, dan pengaturan utama.</p>
                    </div>

                    <div class="role-card">
                        <strong>Admin / Korlap</strong>
                        <p>Mengakses dashboard operasional dan proses Checkin/Checkout sesuai kebutuhan lapangan.</p>
                    </div>

                    <div class="role-card">
                        <strong>HSA</strong>
                        <p>Berfokus pada kebutuhan monitoring dan laporan sesuai hak akses yang ditentukan.</p>
                    </div>

                    <div class="role-card">
                        <strong>Teknisi B2B</strong>
                        <p>Berperan pada aktivitas operasional yang terhubung dengan proses akses dan pekerjaan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta">
            <div class="container">
                <div class="cta-card">
                    <div>
                        <h2>Mulai kelola akses karyawan dengan Smart Key.</h2>
                        <p>
                            Masuk ke sistem untuk mengakses dashboard, monitoring aktivitas,
                            dan pengelolaan operasional Smart Key.
                        </p>
                    </div>

                    <div class="cta-actions">
                        <a href="{{ route('login') }}" class="btn">Masuk ke Sistem</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-inner">
            <div class="footer-brand">
                <img src="/images/1000452284.png" alt="Smart Key Logo">
                Smart Key
            </div>

            <div>
                © {{ date('Y') }} Smart Key. Sistem Akses & Monitoring Karyawan.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('mobileToggle');
            const links = document.getElementById('navLinks');

            if (toggle && links) {
                toggle.addEventListener('click', function () {
                    const isOpen = links.classList.toggle('is-open');
                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    toggle.textContent = isOpen ? '✕' : '☰';
                });

                links.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function () {
                        links.classList.remove('is-open');
                        toggle.setAttribute('aria-expanded', 'false');
                        toggle.textContent = '☰';
                    });
                });
            }

            const navbar = document.querySelector('.navbar');
            const navAnchors = document.querySelectorAll('.nav-links a[href^="#"]');
            const sections = [
                document.getElementById('home'),
                document.getElementById('tentang'),
                document.getElementById('fitur'),
                document.getElementById('alur'),
                document.getElementById('role')
            ].filter(Boolean);

            function updateNavbarOnScroll() {
                if (navbar) {
                    navbar.classList.toggle('is-scrolled', window.scrollY > 40);
                }

                let activeId = 'home';
                const navbarOffset = 130;

                sections.forEach(function (section) {
                    if (window.scrollY + navbarOffset >= section.offsetTop) {
                        activeId = section.id;
                    }
                });

                navAnchors.forEach(function (link) {
                    link.classList.toggle(
                        'is-active',
                        link.getAttribute('href') === '#' + activeId
                    );
                });
            }

            updateNavbarOnScroll();
            window.addEventListener('scroll', updateNavbarOnScroll, { passive: true });
        });
    </script>
</body>
</html>
