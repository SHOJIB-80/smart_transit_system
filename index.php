<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SmartTransit | Smart Transportation</title>

    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f8f7;
            color: #10231d;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input {
            font-family: inherit;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .navbar {
            width: 100%;
            height: 76px;
            background: rgba(255,255,255,0.95);
            border-bottom: 1px solid #e4ebe8;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(15px);
        }

        .nav-inner {
            width: 90%;
            max-width: 1200px;
            margin: auto;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }


        /* LOGO */

        .logo {
            display: flex;
            align-items: center;
            gap: 11px;
            font-size: 21px;
            font-weight: 800;
        }

        .logo-box {
            width: 43px;
            height: 43px;

            background: linear-gradient(
                135deg,
                #087f5b,
                #19b77d
            );

            color: white;

            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 23px;

            box-shadow:
                0 8px 20px rgba(8,127,91,.25);
        }

        .logo span {
            color: #087f5b;
        }


        /* NAVIGATION */

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a {
            color: #52635d;
            font-size: 14px;
            font-weight: 600;

            transition: .2s;
        }

        .nav-links a:hover {
            color: #087f5b;
        }

        .nav-login {
            padding: 11px 18px;

            border: 1px solid #087f5b;

            border-radius: 9px;

            color: #087f5b !important;
        }

        .nav-register {
            padding: 12px 18px;

            background: #087f5b;

            color: white !important;

            border-radius: 9px;

            box-shadow:
                0 8px 20px rgba(8,127,91,.2);
        }

        .nav-register:hover {
            background: #056548;
        }


        /* =====================================================
           HERO
        ===================================================== */

        .hero {
            min-height: 650px;

            position: relative;
            overflow: hidden;

            background:
                radial-gradient(
                    circle at 80% 20%,
                    rgba(57,226,139,.18),
                    transparent 30%
                ),

                linear-gradient(
                    135deg,
                    #f2faf7,
                    #e8f6f0
                );

            display: flex;
            align-items: center;
        }


        /* decorative circles */

        .hero-circle {
            position: absolute;

            border-radius: 50%;

            pointer-events: none;
        }

        .circle-one {
            width: 450px;
            height: 450px;

            right: -180px;
            top: -100px;

            background: rgba(21,168,111,.07);
        }

        .circle-two {
            width: 280px;
            height: 280px;

            left: -150px;
            bottom: -120px;

            background: rgba(21,168,111,.06);
        }


        .hero-content {
            position: relative;

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 60px;

            align-items: center;

            z-index: 2;
        }


        /* HERO TEXT */

        .hero-badge {
            display: inline-flex;

            align-items: center;

            gap: 9px;

            padding: 8px 14px;

            border-radius: 30px;

            background: white;

            border: 1px solid #d9ebe4;

            color: #087f5b;

            font-size: 12px;

            font-weight: 700;
        }

        .badge-dot {
            width: 8px;
            height: 8px;

            background: #19c879;

            border-radius: 50%;

            box-shadow:
                0 0 0 5px rgba(25,200,121,.12);
        }

        .hero h1 {
            margin-top: 22px;

            font-size: 68px;

            line-height: 1;

            letter-spacing: -4px;
        }

        .hero h1 span {
            color: #087f5b;
        }

        .hero-description {
            max-width: 560px;

            margin-top: 23px;

            color: #60716b;

            font-size: 17px;

            line-height: 1.8;
        }


        /* HERO BUTTONS */

        .hero-buttons {
            display: flex;

            align-items: center;

            gap: 20px;

            margin-top: 30px;
        }

        .primary-button {
            display: inline-flex;

            align-items: center;

            gap: 10px;

            padding: 15px 22px;

            background: #087f5b;

            color: white;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 700;

            box-shadow:
                0 12px 25px rgba(8,127,91,.22);

            transition: .2s;
        }

        .primary-button:hover {
            background: #056548;

            transform: translateY(-2px);
        }

        .secondary-button {
            color: #087f5b;

            font-size: 14px;

            font-weight: 700;
        }


        /* TRUST */

        .hero-trust {
            display: flex;

            align-items: center;

            gap: 10px;

            margin-top: 32px;
        }

        .trust-check {
            width: 35px;
            height: 35px;

            border-radius: 10px;

            background: #e2f8ee;

            color: #087f5b;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;
        }

        .hero-trust strong {
            display: block;

            font-size: 12px;
        }

        .hero-trust small {
            color: #8a9893;

            font-size: 10px;
        }


        /* =====================================================
           BUS ILLUSTRATION
        ===================================================== */

        .hero-visual {
            height: 470px;

            position: relative;
        }

        .city-card {
            position: absolute;

            inset: 30px 0 30px 20px;

            overflow: hidden;

            border-radius: 30px;

            background:
                linear-gradient(
                    #bdebd9 0%,
                    #e4f7ef 54%,
                    #8dbdac 55%,
                    #547d70 100%
                );

            border: 8px solid rgba(255,255,255,.75);

            box-shadow:
                0 30px 70px rgba(15,67,49,.16);
        }


        /* SUN */

        .sun {
            position: absolute;

            width: 90px;
            height: 90px;

            right: 13%;
            top: 13%;

            border-radius: 50%;

            background: #fff0ad;

            box-shadow:
                0 0 50px rgba(255,224,112,.5);
        }


        /* BUILDINGS */

        .buildings {
            position: absolute;

            left: 0;
            right: 0;

            bottom: 45%;

            height: 170px;

            display: flex;

            align-items: flex-end;

            gap: 7px;

            padding: 0 25px;
        }

        .building {
            width: 13%;

            background: #6e9f92;

            border-radius: 5px 5px 0 0;

            opacity: .65;
        }

        .b1 { height: 90px; }
        .b2 { height: 135px; }
        .b3 { height: 105px; }
        .b4 { height: 165px; }
        .b5 { height: 125px; }
        .b6 { height: 145px; }
        .b7 { height: 110px; }


        /* ROAD */

        .road {
            position: absolute;

            left: -10%;
            right: -10%;

            bottom: -20%;

            height: 48%;

            background: #344d46;

            transform:
                perspective(350px)
                rotateX(10deg);

            border-top: 5px solid #bad7cc;
        }

        .road-line {
            position: absolute;

            width: 85px;
            height: 6px;

            background: white;

            top: 55px;

            left: 50%;

            transform: translateX(-50%);
        }


        /* BUS */

        .bus {
            position: absolute;

            width: 67%;
            height: 215px;

            right: 5%;
            bottom: 15%;

            background: #ffffff;

            border-radius: 23px 23px 14px 14px;

            border: 4px solid #d2e5de;

            box-shadow:
                0 25px 35px rgba(18,54,44,.3);
        }

        .bus-top {
            height: 13px;

            width: 100%;

            background:
                linear-gradient(
                    90deg,
                    #087f5b,
                    #19b77d
                );

            border-radius: 18px 18px 0 0;
        }

        .bus-name {
            position: absolute;

            left: 7%;
            top: 24px;

            padding: 5px 9px;

            border-radius: 4px;

            background: #16352b;

            color: #65e9a6;

            font-size: 8px;

            font-weight: 800;

            letter-spacing: 1px;
        }

        .bus-windows {
            position: absolute;

            left: 6%;
            right: 5%;

            top: 55px;

            height: 65px;

            display: flex;

            gap: 5px;
        }

        .bus-window {
            flex: 1;

            border-radius: 6px;

            border: 2px solid #d0e5de;

            background:
                linear-gradient(
                    140deg,
                    #294d48,
                    #729c94
                );
        }

        .bus-green-line {
            position: absolute;

            left: 0;
            right: 0;

            top: 135px;

            height: 7px;

            background: #12a66f;
        }

        .bus-door {
            position: absolute;

            width: 34px;
            height: 67px;

            right: 13%;
            top: 143px;

            border: 2px solid #a9c5ba;

            border-bottom: none;
        }

        .wheel {
            position: absolute;

            bottom: -21px;

            width: 45px;
            height: 45px;

            border-radius: 50%;

            background: #1c2b28;

            border: 8px solid #70857e;
        }

        .wheel-one {
            left: 15%;
        }

        .wheel-two {
            right: 15%;
        }


        /* FLOATING CARDS */

        .floating-card {
            position: absolute;

            z-index: 5;

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 12px 15px;

            background: rgba(255,255,255,.95);

            border-radius: 13px;

            box-shadow:
                0 15px 35px rgba(15,60,45,.13);
        }

        .floating-one {
            right: -10px;
            top: 22px;
        }

        .floating-two {
            left: -5px;
            bottom: 18px;
        }

        .floating-icon {
            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #e6f7f0;

            color: #087f5b;

            border-radius: 9px;

            font-weight: bold;
        }

        .floating-card strong {
            display: block;

            font-size: 11px;
        }

        .floating-card small {
            display: block;

            color: #8b9893;

            font-size: 9px;
        }


        /* =====================================================
           SEARCH BOX
        ===================================================== */

        .search-section {
            position: relative;

            margin-top: -40px;

            z-index: 20;
        }

        .search-box {
            background: white;

            border: 1px solid #e1ebe7;

            border-radius: 18px;

            padding: 17px;

            display: grid;

            grid-template-columns:
                1.1fr
                1fr
                1fr
                160px;

            gap: 12px;

            align-items: center;

            box-shadow:
                0 25px 55px rgba(15,65,48,.14);
        }

        .search-title strong {
            display: block;

            font-size: 13px;
        }

        .search-title small {
            color: #87948f;

            font-size: 10px;
        }

        .input-box {
            height: 52px;

            border: 1px solid #dce7e2;

            border-radius: 10px;

            padding: 8px 12px;

            display: flex;

            flex-direction: column;

            justify-content: center;
        }

        .input-box label {
            color: #9aa7a2;

            font-size: 8px;

            font-weight: bold;

            letter-spacing: 1px;
        }

        .input-box input {
            width: 100%;

            border: none;

            outline: none;

            font-size: 12px;

            margin-top: 3px;

            color: #25352f;
        }

        .search-button {
            height: 52px;

            border: none;

            border-radius: 10px;

            background: #087f5b;

            color: white;

            cursor: pointer;

            font-size: 13px;

            font-weight: 700;

            transition: .2s;
        }

        .search-button:hover {
            background: #056548;
        }


        /* =====================================================
           STATISTICS
        ===================================================== */

        .stats {
            padding: 55px 0;

            background: white;
        }

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            border: 1px solid #e2ebe7;

            border-radius: 16px;

            overflow: hidden;
        }

        .stat {
            padding: 24px;

            display: flex;

            align-items: center;

            gap: 14px;

            border-right: 1px solid #e2ebe7;
        }

        .stat:last-child {
            border-right: none;
        }

        .stat-icon {
            width: 44px;
            height: 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #e4f7ef;

            color: #087f5b;

            border-radius: 12px;

            font-size: 19px;

            font-weight: bold;
        }

        .stat strong {
            display: block;

            font-size: 23px;
        }

        .stat small {
            color: #899691;

            font-size: 10px;
        }


        /* =====================================================
           SERVICES
        ===================================================== */

        .services {
            padding: 90px 0;

            background: #fff;
        }

        .section-label {
            color: #087f5b;

            font-size: 11px;

            font-weight: 800;

            letter-spacing: 2px;
        }

        .section-title {
            margin-top: 9px;

            font-size: 36px;

            letter-spacing: -1px;
        }

        .section-description {
            color: #84918d;

            font-size: 13px;

            margin-top: 7px;
        }

        .service-grid {
            margin-top: 35px;

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 16px;
        }

        .service-card {
            position: relative;

            min-height: 220px;

            padding: 24px;

            border: 1px solid #e1e9e5;

            border-radius: 17px;

            background: white;

            transition: .25s;
        }

        .service-card:hover {
            transform: translateY(-7px);

            box-shadow:
                0 20px 45px rgba(15,60,45,.1);

            border-color: #b9dace;
        }

        .service-card.featured {
            background:
                linear-gradient(
                    145deg,
                    #087f5b,
                    #045e45
                );

            color: white;

            border: none;
        }

        .service-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #e5f7ef;

            color: #087f5b;

            font-size: 20px;

            font-weight: bold;
        }

        .featured .service-icon {
            background: rgba(255,255,255,.15);

            color: white;
        }

        .service-number {
            display: block;

            margin-top: 20px;

            color: #9ca9a4;

            font-size: 9px;

            font-weight: bold;
        }

        .featured .service-number {
            color: #a8dbc7;
        }

        .service-card h3 {
            margin-top: 4px;

            font-size: 18px;
        }

        .service-card p {
            margin-top: 6px;

            color: #899691;

            font-size: 11px;

            line-height: 1.7;
        }

        .featured p {
            color: #c2e5d8;
        }

        .service-arrow {
            position: absolute;

            right: 20px;
            bottom: 18px;

            font-size: 21px;

            color: #087f5b;
        }

        .featured .service-arrow {
            color: #9ff0c3;
        }


        /* =====================================================
           NETWORK SECTION
        ===================================================== */

        .network {
            padding: 100px 0;

            background:
                radial-gradient(
                    circle at 80% 20%,
                    #dff5eb,
                    transparent 30%
                ),

                #f1f7f4;
        }

        .network-grid {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 80px;

            align-items: center;
        }

        .network h2 {
            margin-top: 10px;

            font-size: 45px;

            line-height: 1.05;

            letter-spacing: -2px;
        }

        .network h2 span {
            color: #087f5b;
        }

        .network-description {
            margin-top: 20px;

            color: #71817b;

            font-size: 14px;

            line-height: 1.8;

            max-width: 500px;
        }

        .network-list {
            list-style: none;

            margin-top: 25px;

            display: grid;

            gap: 12px;
        }

        .network-list li {
            font-size: 13px;

            font-weight: 600;
        }

        .network-list li::first-letter {
            color: #087f5b;
        }


        /* NETWORK CARD */

        .network-card {
            background: white;

            border: 1px solid #dfe9e4;

            border-radius: 20px;

            padding: 25px;

            box-shadow:
                0 25px 55px rgba(15,65,48,.1);
        }

        .network-header {
            display: flex;

            justify-content: space-between;

            padding-bottom: 18px;

            border-bottom: 1px solid #e6ece9;
        }

        .network-header strong {
            font-size: 13px;
        }

        .network-header small {
            color: #98a49f;

            font-size: 9px;

            letter-spacing: 1px;
        }

        .route {
            display: grid;

            grid-template-columns:
                15px
                1fr
                50px
                1fr;

            align-items: center;

            gap: 10px;

            padding: 18px 4px;

            border-bottom: 1px solid #edf1ef;
        }

        .route-dot {
            width: 11px;
            height: 11px;

            border-radius: 50%;

            background: #087f5b;

            box-shadow:
                0 0 0 5px #def5eb;
        }

        .route-dot.blue {
            background: #4387d7;

            box-shadow:
                0 0 0 5px #e4effd;
        }

        .route-dot.purple {
            background: #805bd3;

            box-shadow:
                0 0 0 5px #eee8ff;
        }

        .route strong {
            display: block;

            font-size: 12px;
        }

        .route small {
            color: #929f9a;

            font-size: 9px;
        }

        .route-line {
            height: 2px;

            background: #dce9e4;
        }

        .network-footer {
            display: flex;

            justify-content: space-between;

            padding-top: 18px;

            color: #899691;

            font-size: 10px;
        }

        .network-footer a {
            color: #087f5b;

            font-weight: bold;
        }


        /* =====================================================
           NOTICE
        ===================================================== */

        .notice-section {
            padding: 90px 0;

            background: white;
        }

        .notice {
            margin-top: 30px;

            padding: 22px;

            display: flex;

            align-items: center;

            gap: 18px;

            border: 1px solid #eadfbf;

            background: #fffbf3;

            border-radius: 15px;
        }

        .notice-icon {
            width: 45px;
            height: 45px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #fff0c9;

            color: #b77b17;

            font-weight: bold;
        }

        .notice small {
            color: #b17b20;

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 1px;
        }

        .notice h3 {
            margin-top: 2px;

            font-size: 15px;
        }

        .notice p {
            margin-top: 2px;

            color: #899691;

            font-size: 11px;
        }


        /* =====================================================
           CTA
        ===================================================== */

        .cta {
            padding: 0 0 90px;

            background: white;
        }

        .cta-box {
            padding: 50px;

            border-radius: 22px;

            background:
                radial-gradient(
                    circle at 85% 20%,
                    rgba(60,232,145,.25),
                    transparent 28%
                ),

                linear-gradient(
                    120deg,
                    #064e3b,
                    #087f5b
                );

            color: white;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 30px;
        }

        .cta-box h2 {
            margin-top: 8px;

            font-size: 33px;
        }

        .cta-box p {
            margin-top: 5px;

            color: #bce6d7;

            font-size: 13px;
        }

        .cta-button {
            padding: 14px 20px;

            background: white;

            color: #087f5b;

            border-radius: 10px;

            font-size: 13px;

            font-weight: 800;

            white-space: nowrap;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            background: #10251e;

            color: #c8d6d1;
        }

        .footer-grid {
            padding: 55px 0;

            display: grid;

            grid-template-columns:
                2fr
                1fr
                1fr;

            gap: 50px;
        }

        .footer-logo {
            color: white;

            font-size: 20px;

            font-weight: 800;
        }

        .footer-logo span {
            color: #4ee495;
        }

        .footer-description {
            margin-top: 12px;

            color: #8fa39b;

            font-size: 12px;

            max-width: 360px;

            line-height: 1.8;
        }

        .footer h4 {
            color: white;

            font-size: 13px;

            margin-bottom: 13px;
        }

        .footer a {
            display: block;

            margin: 7px 0;

            color: #91a69e;

            font-size: 11px;
        }

        .footer a:hover {
            color: white;
        }

        .footer-bottom {
            padding: 18px 0;

            border-top: 1px solid #263e35;

            text-align: center;

            color: #71867e;

            font-size: 10px;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width: 900px) {

            .nav-links {
                display: none;
            }

            .hero-content {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 70px 0 80px;
            }

            .hero h1 {
                font-size: 55px;
            }

            .hero-visual {
                height: 400px;
            }

            .search-box {
                grid-template-columns: 1fr 1fr;
            }

            .search-title {
                grid-column: 1 / -1;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stat:nth-child(2) {
                border-right: none;
            }

            .service-grid {
                grid-template-columns: 1fr 1fr;
            }

            .network-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

        }


        @media(max-width: 600px) {

            .hero h1 {
                font-size: 45px;

                letter-spacing: -2px;
            }

            .hero-description {
                font-size: 14px;
            }

            .hero-buttons {
                flex-direction: column;

                align-items: flex-start;
            }

            .hero-visual {
                height: 320px;
            }

            .city-card {
                inset: 10px 0 10px 0;
            }

            .bus {
                width: 78%;

                height: 170px;
            }

            .bus-windows {
                height: 50px;
            }

            .bus-green-line {
                top: 105px;
            }

            .bus-door {
                top: 113px;

                height: 50px;
            }

            .search-box {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat {
                border-right: none;

                border-bottom: 1px solid #e2ebe7;
            }

            .stat:last-child {
                border-bottom: none;
            }

            .service-grid {
                grid-template-columns: 1fr;
            }

            .network h2 {
                font-size: 37px;
            }

            .notice {
                align-items: flex-start;
            }

            .cta-box {
                padding: 35px 25px;

                flex-direction: column;

                align-items: flex-start;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =========================================================
     NAVBAR
========================================================= -->

<nav class="navbar">

    <div class="nav-inner">

        <a href="index.php" class="logo">

            <div class="logo-box">
                🚌
            </div>

            Smart<span>Transit</span>

        </a>


        <div class="nav-links">

            <a href="index.php">
                Home
            </a>

            <a href="about.php">
                About
            </a>

            <a href="passenger/routes.php">
                Routes
            </a>

            <a href="passenger/schedules.php">
                Schedules
            </a>

            <a href="passenger/buses.php">
                Buses
            </a>

            <a href="login.php" class="nav-login">
                Login
            </a>

            <a href="register.php" class="nav-register">
                Get Started
            </a>

        </div>

    </div>

</nav>



<!-- =========================================================
     HERO
========================================================= -->

<section class="hero">

    <div class="hero-circle circle-one"></div>
    <div class="hero-circle circle-two"></div>


    <div class="container hero-content">


        <!-- LEFT -->

        <div class="hero-text">

            <div class="hero-badge">

                <span class="badge-dot"></span>

                SMART PUBLIC TRANSPORTATION

            </div>


            <h1>

                Your journey.<br>

                <span>Our priority.</span>

            </h1>


            <p class="hero-description">

                Discover routes, buses and schedules in one
                simple place. SmartTransit helps you plan
                your journey with clear and reliable
                transportation information.

            </p>


            <div class="hero-buttons">

                <a
                    href="passenger/routes.php"
                    class="primary-button"
                >

                    Find a Route

                    <span>→</span>

                </a>


                <a
                    href="#services"
                    class="secondary-button"
                >

                    Explore the network →

                </a>

            </div>


            <div class="hero-trust">

                <div class="trust-check">
                    ✓
                </div>

                <div>

                    <strong>
                        Built for everyday journeys
                    </strong>

                    <small>
                        Routes · Schedules · Bus information
                    </small>

                </div>

            </div>

        </div>



        <!-- RIGHT -->

        <div class="hero-visual">


            <div class="floating-card floating-one">

                <div class="floating-icon">
                    ✓
                </div>

                <div>

                    <strong>
                        Smart routes
                    </strong>

                    <small>
                        Easy to discover
                    </small>

                </div>

            </div>



            <div class="city-card">


                <div class="sun"></div>


                <div class="buildings">

                    <div class="building b1"></div>

                    <div class="building b2"></div>

                    <div class="building b3"></div>

                    <div class="building b4"></div>

                    <div class="building b5"></div>

                    <div class="building b6"></div>

                    <div class="building b7"></div>

                </div>


                <div class="road">

                    <div class="road-line"></div>

                </div>


                <!-- BUS -->

                <div class="bus">

                    <div class="bus-top"></div>

                    <div class="bus-name">
                        SMART TRANSIT
                    </div>


                    <div class="bus-windows">

                        <div class="bus-window"></div>

                        <div class="bus-window"></div>

                        <div class="bus-window"></div>

                    </div>


                    <div class="bus-green-line"></div>

                    <div class="bus-door"></div>


                    <div class="wheel wheel-one"></div>

                    <div class="wheel wheel-two"></div>

                </div>


            </div>



            <div class="floating-card floating-two">

                <div class="floating-icon">
                    ↗
                </div>

                <div>

                    <strong>
                        Connected network
                    </strong>

                    <small>
                        Plan your journey
                    </small>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =========================================================
     ROUTE SEARCH
========================================================= -->

<section class="search-section">

    <div class="container">

        <form
            class="search-box"
            action="passenger/routes.php"
            method="GET"
        >


            <div class="search-title">

                <strong>
                    Where are you going?
                </strong>

                <small>
                    Find a route between two places
                </small>

            </div>


            <div class="input-box">

                <label>
                    FROM
                </label>

                <input
                    type="text"
                    name="from"
                    placeholder="Starting point"
                >

            </div>


            <div class="input-box">

                <label>
                    TO
                </label>

                <input
                    type="text"
                    name="to"
                    placeholder="Destination"
                >

            </div>


            <button
                type="submit"
                class="search-button"
            >

                Search Route →

            </button>


        </form>

    </div>

</section>



<!-- =========================================================
     STATISTICS
========================================================= -->

<section class="stats">

    <div class="container">

        <div class="stats-grid">


            <div class="stat">

                <div class="stat-icon">
                    🚌
                </div>

                <div>

                    <strong>
                        50+
                    </strong>

                    <small>
                        Active buses
                    </small>

                </div>

            </div>


            <div class="stat">

                <div class="stat-icon">
                    ↝
                </div>

                <div>

                    <strong>
                        25+
                    </strong>

                    <small>
                        Routes
                    </small>

                </div>

            </div>


            <div class="stat">

                <div class="stat-icon">
                    📍
                </div>

                <div>

                    <strong>
                        100+
                    </strong>

                    <small>
                        Stops
                    </small>

                </div>

            </div>


            <div class="stat">

                <div class="stat-icon">
                    ◷
                </div>

                <div>

                    <strong>
                        24/7
                    </strong>

                    <small>
                        Information access
                    </small>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =========================================================
     SERVICES
========================================================= -->

<section
    class="services"
    id="services"
>

    <div class="container">


        <div class="section-label">
            EXPLORE SMARTTRANSIT
        </div>


        <h2 class="section-title">
            Everything you need for your journey
        </h2>


        <p class="section-description">

            Quick access to the information passengers
            use most.

        </p>



        <div class="service-grid">


            <!-- ROUTES -->

            <a
                href="passenger/routes.php"
                class="service-card featured"
            >

                <div class="service-icon">
                    ↝
                </div>

                <span class="service-number">
                    01
                </span>

                <h3>
                    Find Routes
                </h3>

                <p>
                    Explore available routes,
                    stops and connections.
                </p>

                <div class="service-arrow">
                    ↗
                </div>

            </a>



            <!-- BUS -->

            <a
                href="passenger/buses.php"
                class="service-card"
            >

                <div class="service-icon">
                    🚌
                </div>

                <span class="service-number">
                    02
                </span>

                <h3>
                    Bus Fleet
                </h3>

                <p>
                    See buses, capacity and
                    service information.
                </p>

                <div class="service-arrow">
                    ↗
                </div>

            </a>



            <!-- SCHEDULE -->

            <a
                href="passenger/schedules.php"
                class="service-card"
            >

                <div class="service-icon">
                    ◷
                </div>

                <span class="service-number">
                    03
                </span>

                <h3>
                    Schedules
                </h3>

                <p>
                    Check planned departure
                    and arrival times.
                </p>

                <div class="service-arrow">
                    ↗
                </div>

            </a>



            <!-- NOTICE -->

            <a
                href="passenger/notices.php"
                class="service-card"
            >

                <div class="service-icon">
                    !
                </div>

                <span class="service-number">
                    04
                </span>

                <h3>
                    Service Notices
                </h3>

                <p>
                    Stay informed about important
                    transit updates.
                </p>

                <div class="service-arrow">
                    ↗
                </div>

            </a>


        </div>

    </div>

</section>



<!-- =========================================================
     NETWORK
========================================================= -->

<section class="network">

    <div class="container network-grid">


        <div>

            <div class="section-label">
                A BETTER WAY TO PLAN
            </div>


            <h2>

                Simple information.<br>

                <span>
                    Smarter journeys.
                </span>

            </h2>


            <p class="network-description">

                SmartTransit brings essential public
                transportation information together so
                passengers can understand their options
                before they travel.

            </p>


            <ul class="network-list">

                <li>
                    ✓ Route and stop information
                </li>

                <li>
                    ✓ Bus and schedule information
                </li>

                <li>
                    ✓ Passenger service notices
                </li>

                <li>
                    ✓ Foundation ready for live maps
                </li>

            </ul>


            <a
                href="about.php"
                class="primary-button"
            >

                Learn about the project →

            </a>

        </div>



        <!-- NETWORK CARD -->

        <div class="network-card">


            <div class="network-header">

                <strong>
                    🟢 Network overview
                </strong>

                <small>
                    PART 1
                </small>

            </div>



            <div class="route">

                <div class="route-dot"></div>

                <div>

                    <strong>
                        Mirpur
                    </strong>

                    <small>
                        R-01
                    </small>

                </div>

                <div class="route-line"></div>

                <div>

                    <strong>
                        Motijheel
                    </strong>

                    <small>
                        5 stops
                    </small>

                </div>

            </div>



            <div class="route">

                <div class="route-dot blue"></div>

                <div>

                    <strong>
                        Uttara
                    </strong>

                    <small>
                        R-02
                    </small>

                </div>

                <div class="route-line"></div>

                <div>

                    <strong>
                        Farmgate
                    </strong>

                    <small>
                        5 stops
                    </small>

                </div>

            </div>



            <div class="route">

                <div class="route-dot purple"></div>

                <div>

                    <strong>
                        Mohammadpur
                    </strong>

                    <small>
                        R-03
                    </small>

                </div>

                <div class="route-line"></div>

                <div>

                    <strong>
                        Gulistan
                    </strong>

                    <small>
                        5 stops
                    </small>

                </div>

            </div>



            <div class="network-footer">

                <span>
                    More routes available
                </span>

                <a href="passenger/routes.php">
                    View all →
                </a>

            </div>


        </div>

    </div>

</section>



<!-- =========================================================
     NOTICE
========================================================= -->

<section class="notice-section">

    <div class="container">


        <div class="section-label">
            STAY INFORMED
        </div>


        <h2 class="section-title">
            Latest service notice
        </h2>


        <div class="notice">


            <div class="notice-icon">
                !
            </div>


            <div>

                <small>
                    SERVICE INFORMATION
                </small>

                <h3>
                    Welcome to SmartTransit
                </h3>

                <p>
                    Check the routes and schedules before
                    starting your journey.
                </p>

            </div>


        </div>

    </div>

</section>



<!-- =========================================================
     CTA
========================================================= -->

<section class="cta">

    <div class="container">

        <div class="cta-box">


            <div>

                <div class="section-label">
                    READY TO TRAVEL?
                </div>

                <h2>
                    Start with your destination.
                </h2>

                <p>
                    Search the network and discover
                    the route that works for you.
                </p>

            </div>


            <a
                href="passenger/routes.php"
                class="cta-button"
            >

                Search a Route →

            </a>


        </div>

    </div>

</section>



<!-- =========================================================
     FOOTER
========================================================= -->

<footer class="footer">

    <div class="container footer-grid">


        <div>

            <div class="footer-logo">

                Smart<span>Transit</span>

            </div>

            <p class="footer-description">

                A smart public transportation information
                system designed to make everyday journeys
                easier, clearer and more connected.

            </p>

        </div>



        <div>

            <h4>
                Navigation
            </h4>

            <a href="index.php">
                Home
            </a>

            <a href="about.php">
                About
            </a>

            <a href="passenger/routes.php">
                Routes
            </a>

            <a href="passenger/schedules.php">
                Schedules
            </a>

        </div>



        <div>

            <h4>
                Passenger
            </h4>

            <a href="passenger/buses.php">
                Bus Fleet
            </a>

            <a href="passenger/notices.php">
                Notices
            </a>

            <a href="login.php">
                Login
            </a>

            <a href="register.php">
                Register
            </a>

        </div>


    </div>


    <div class="footer-bottom">

        © 2026 SmartTransit.
        Smart Transportation Navigation System.

    </div>

</footer>



</body>
</html>