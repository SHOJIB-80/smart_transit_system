<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About | SmartTransit</title>

    <style>

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

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }


        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 76px;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid #e3ebe7;

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

            display: flex;
            align-items: center;
            justify-content: center;

            background: linear-gradient(
                135deg,
                #087f5b,
                #19b77d
            );

            color: white;

            border-radius: 13px;

            box-shadow:
                0 8px 20px rgba(8,127,91,.25);
        }

        .logo span {
            color: #087f5b;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
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
            padding: 10px 17px;

            border: 1px solid #087f5b;

            border-radius: 9px;

            color: #087f5b !important;
        }

        .nav-register {
            padding: 11px 18px;

            background: #087f5b;

            color: white !important;

            border-radius: 9px;
        }


        /* =========================
           HERO
        ========================= */

        .about-hero {
            min-height: 500px;

            display: flex;
            align-items: center;

            position: relative;
            overflow: hidden;

            background:

                radial-gradient(
                    circle at 80% 15%,
                    rgba(39,205,133,.18),
                    transparent 30%
                ),

                linear-gradient(
                    135deg,
                    #f1faf6,
                    #e8f6f0
                );
        }

        .hero-circle {
            position: absolute;

            border-radius: 50%;

            pointer-events: none;
        }

        .circle-one {
            width: 430px;
            height: 430px;

            right: -170px;
            top: -150px;

            background: rgba(8,127,91,.06);
        }

        .circle-two {
            width: 240px;
            height: 240px;

            left: -130px;
            bottom: -130px;

            background: rgba(8,127,91,.06);
        }

        .about-hero-content {
            position: relative;
            z-index: 2;

            display: grid;

            grid-template-columns:
                1.05fr
                .95fr;

            gap: 80px;

            align-items: center;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;

            padding: 8px 14px;

            border-radius: 30px;

            background: white;

            border: 1px solid #d9ebe4;

            color: #087f5b;

            font-size: 11px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .hero-label span {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #19c879;
        }

        .about-hero h1 {
            margin-top: 22px;

            font-size: 62px;

            line-height: 1.02;

            letter-spacing: -3px;
        }

        .about-hero h1 span {
            color: #087f5b;
        }

        .hero-text {
            margin-top: 20px;

            max-width: 550px;

            color: #697a73;

            font-size: 16px;

            line-height: 1.8;
        }

        .hero-actions {
            display: flex;

            gap: 15px;

            margin-top: 28px;
        }

        .primary-btn {
            padding: 14px 21px;

            border-radius: 10px;

            background: #087f5b;

            color: white;

            font-size: 13px;

            font-weight: 700;

            box-shadow:
                0 10px 25px rgba(8,127,91,.2);
        }

        .secondary-btn {
            padding: 14px 21px;

            border-radius: 10px;

            color: #087f5b;

            font-size: 13px;

            font-weight: 700;
        }


        /* =========================
           HERO VISUAL
        ========================= */

        .about-visual {
            height: 350px;

            position: relative;
        }

        .visual-card {
            position: absolute;

            inset: 15px 0 15px 30px;

            background: white;

            border-radius: 25px;

            border: 1px solid #dfeae5;

            box-shadow:
                0 30px 65px rgba(17,65,49,.13);

            overflow: hidden;
        }

        .visual-top {
            height: 55px;

            padding: 0 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            border-bottom: 1px solid #e8efec;
        }

        .visual-title {
            font-size: 12px;
            font-weight: 800;
        }

        .live-status {
            display: flex;
            align-items: center;
            gap: 6px;

            color: #087f5b;

            font-size: 9px;
            font-weight: 700;
        }

        .live-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #20c77c;
        }

        .map-area {
            height: calc(100% - 55px);

            position: relative;

            background:

                linear-gradient(
                    30deg,
                    transparent 47%,
                    #dcece5 48%,
                    #dcece5 50%,
                    transparent 51%
                ),

                linear-gradient(
                    120deg,
                    transparent 48%,
                    #dcece5 49%,
                    #dcece5 51%,
                    transparent 52%
                ),

                #f2f8f5;
        }

        .map-route {
            position: absolute;

            width: 70%;

            height: 4px;

            left: 15%;
            top: 50%;

            background: #087f5b;

            transform:
                rotate(-15deg);

            border-radius: 5px;

            box-shadow:
                0 0 0 6px rgba(8,127,91,.08);
        }

        .map-stop {
            position: absolute;

            width: 14px;
            height: 14px;

            border-radius: 50%;

            background: white;

            border: 4px solid #087f5b;

            z-index: 3;
        }

        .stop-one {
            left: 18%;
            top: 58%;
        }

        .stop-two {
            left: 43%;
            top: 51%;
        }

        .stop-three {
            left: 69%;
            top: 44%;
        }

        .stop-four {
            left: 83%;
            top: 35%;
        }

        .map-bus {
            position: absolute;

            left: 51%;
            top: 47%;

            width: 45px;
            height: 27px;

            border-radius: 7px;

            background: #087f5b;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 14px;

            box-shadow:
                0 8px 18px rgba(8,127,91,.3);

            transform: rotate(-15deg);
        }

        .floating-info {
            position: absolute;

            right: -5px;
            bottom: 10px;

            padding: 12px 15px;

            background: white;

            border-radius: 12px;

            box-shadow:
                0 15px 30px rgba(15,60,45,.12);
        }

        .floating-info strong {
            display: block;

            font-size: 11px;
        }

        .floating-info small {
            color: #8a9892;

            font-size: 9px;
        }


        /* =========================
           STATS
        ========================= */

        .stats {
            padding: 45px 0;

            background: white;
        }

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4,1fr);

            border: 1px solid #e2ebe7;

            border-radius: 16px;

            overflow: hidden;
        }

        .stat {
            padding: 24px;

            display: flex;
            align-items: center;

            gap: 13px;

            border-right: 1px solid #e2ebe7;
        }

        .stat:last-child {
            border-right: none;
        }

        .stat-icon {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #e3f7ef;

            color: #087f5b;

            border-radius: 11px;

            font-size: 18px;
        }

        .stat strong {
            display: block;

            font-size: 22px;
        }

        .stat small {
            color: #899691;

            font-size: 10px;
        }


        /* =========================
           ABOUT SECTION
        ========================= */

        .story {
            padding: 100px 0;

            background: #fff;
        }

        .story-grid {
            display: grid;

            grid-template-columns:
                .85fr
                1.15fr;

            gap: 80px;

            align-items: center;
        }

        .section-label {
            color: #087f5b;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 2px;
        }

        .story h2 {
            margin-top: 10px;

            font-size: 42px;

            line-height: 1.1;

            letter-spacing: -2px;
        }

        .story h2 span {
            color: #087f5b;
        }

        .story-text {
            margin-top: 20px;

            color: #74827d;

            font-size: 14px;

            line-height: 1.9;
        }


        /* STORY CARDS */

        .story-cards {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 14px;
        }

        .story-card {
            padding: 25px;

            border: 1px solid #e1eae6;

            border-radius: 16px;

            background: white;

            transition: .25s;
        }

        .story-card:hover {
            transform: translateY(-5px);

            box-shadow:
                0 18px 40px rgba(15,60,45,.09);
        }

        .story-card.large {
            grid-column: span 2;

            background:
                linear-gradient(
                    135deg,
                    #087f5b,
                    #075c44
                );

            color: white;

            border: none;
        }

        .card-number {
            font-size: 10px;

            color: #9aa8a2;

            font-weight: 800;

            letter-spacing: 1px;
        }

        .large .card-number {
            color: #a7dec9;
        }

        .story-card h3 {
            margin-top: 12px;

            font-size: 18px;
        }

        .story-card p {
            margin-top: 7px;

            color: #899691;

            font-size: 11px;

            line-height: 1.7;
        }

        .large p {
            color: #c2e6d9;
        }


        /* =========================
           MISSION
        ========================= */

        .mission {
            padding: 100px 0;

            background:

                radial-gradient(
                    circle at 80% 20%,
                    #dff5eb,
                    transparent 28%
                ),

                #f1f7f4;
        }

        .mission-header {
            text-align: center;

            max-width: 650px;

            margin: auto;
        }

        .mission-header h2 {
            margin-top: 10px;

            font-size: 40px;

            letter-spacing: -1.5px;
        }

        .mission-header p {
            margin-top: 12px;

            color: #7a8983;

            font-size: 13px;

            line-height: 1.8;
        }

        .mission-grid {
            margin-top: 40px;

            display: grid;

            grid-template-columns:
                repeat(3,1fr);

            gap: 17px;
        }

        .mission-card {
            padding: 30px;

            background: white;

            border: 1px solid #e0eae5;

            border-radius: 17px;

            transition: .25s;
        }

        .mission-card:hover {
            transform: translateY(-6px);

            box-shadow:
                0 20px 45px rgba(15,60,45,.09);
        }

        .mission-icon {
            width: 47px;
            height: 47px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #e3f7ef;

            color: #087f5b;

            border-radius: 12px;

            font-size: 20px;
        }

        .mission-card h3 {
            margin-top: 18px;

            font-size: 17px;
        }

        .mission-card p {
            margin-top: 8px;

            color: #899691;

            font-size: 11px;

            line-height: 1.8;
        }


        /* =========================
           TECHNOLOGY
        ========================= */

        .technology {
            padding: 100px 0;

            background: white;
        }

        .technology-grid {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 70px;

            align-items: center;
        }

        .technology h2 {
            margin-top: 10px;

            font-size: 40px;

            line-height: 1.1;
        }

        .technology h2 span {
            color: #087f5b;
        }

        .technology p {
            margin-top: 15px;

            color: #7d8b85;

            font-size: 13px;

            line-height: 1.8;
        }

        .tech-list {
            margin-top: 25px;

            display: grid;

            gap: 12px;
        }

        .tech-item {
            display: flex;

            align-items: center;

            gap: 12px;

            font-size: 12px;

            font-weight: 700;
        }

        .tech-check {
            width: 27px;
            height: 27px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: #e3f7ef;

            color: #087f5b;
        }


        /* TECHNOLOGY CARD */

        .tech-panel {
            padding: 25px;

            border-radius: 20px;

            background: #102b22;

            color: white;

            box-shadow:
                0 25px 55px rgba(10,40,29,.18);
        }

        .tech-panel-top {
            display: flex;

            justify-content: space-between;

            padding-bottom: 17px;

            border-bottom: 1px solid #28463b;
        }

        .tech-panel-top strong {
            font-size: 12px;
        }

        .tech-panel-top span {
            color: #4ee495;

            font-size: 9px;

            font-weight: 800;
        }

        .code-line {
            margin-top: 15px;

            padding: 11px 13px;

            border-radius: 8px;

            background: #17382d;

            color: #9bd8c0;

            font-family: monospace;

            font-size: 10px;
        }


        /* =========================
           CTA
        ========================= */

        .cta {
            padding: 0 0 90px;

            background: white;
        }

        .cta-box {
            padding: 48px;

            border-radius: 22px;

            background:

                radial-gradient(
                    circle at 85% 20%,
                    rgba(65,230,146,.25),
                    transparent 28%
                ),

                linear-gradient(
                    120deg,
                    #064e3b,
                    #087f5b
                );

            color: white;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 30px;
        }

        .cta-box h2 {
            margin-top: 8px;

            font-size: 31px;
        }

        .cta-box p {
            margin-top: 6px;

            color: #bce5d7;

            font-size: 12px;
        }

        .cta-btn {
            padding: 14px 20px;

            background: white;

            color: #087f5b;

            border-radius: 10px;

            font-size: 12px;

            font-weight: 800;

            white-space: nowrap;
        }


        /* =========================
           FOOTER
        ========================= */

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

            font-size: 11px;

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


        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 900px) {

            .nav-links {
                display: none;
            }

            .about-hero-content {
                grid-template-columns: 1fr;
            }

            .about-hero {
                padding: 70px 0;
            }

            .about-hero h1 {
                font-size: 53px;
            }

            .about-visual {
                height: 320px;
            }

            .story-grid {
                grid-template-columns: 1fr;
            }

            .technology-grid {
                grid-template-columns: 1fr;
            }

            .mission-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stat:nth-child(2) {
                border-right: none;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

        }


        @media(max-width: 600px) {

            .about-hero h1 {
                font-size: 43px;

                letter-spacing: -2px;
            }

            .hero-text {
                font-size: 14px;
            }

            .about-visual {
                height: 280px;
            }

            .visual-card {
                inset: 5px 0 5px 0;
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

            .story-cards {
                grid-template-columns: 1fr;
            }

            .story-card.large {
                grid-column: span 1;
            }

            .mission-grid {
                grid-template-columns: 1fr;
            }

            .cta-box {
                flex-direction: column;

                align-items: flex-start;

                padding: 35px 25px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

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



<!-- =========================
     HERO
========================= -->

<section class="about-hero">

    <div class="hero-circle circle-one"></div>
    <div class="hero-circle circle-two"></div>


    <div class="container about-hero-content">


        <div>

            <div class="hero-label">

                <span></span>

                ABOUT SMARTTRANSIT

            </div>


            <h1>

                Moving people.<br>

                <span>Connecting cities.</span>

            </h1>


            <p class="hero-text">

                SmartTransit is a smart public transportation
                navigation system designed to make everyday
                journeys easier by bringing routes, buses,
                schedules and transportation information
                together in one connected platform.

            </p>


            <div class="hero-actions">

                <a
                    href="passenger/routes.php"
                    class="primary-btn"
                >

                    Explore Routes →

                </a>

                <a
                    href="#mission"
                    class="secondary-btn"
                >

                    Our Mission ↓

                </a>

            </div>

        </div>



        <!-- VISUAL -->

        <div class="about-visual">

            <div class="visual-card">


                <div class="visual-top">

                    <div class="visual-title">
                        SmartTransit Network
                    </div>

                    <div class="live-status">

                        <span class="live-dot"></span>

                        CONNECTED

                    </div>

                </div>


                <div class="map-area">


                    <div class="map-route"></div>


                    <div class="map-stop stop-one"></div>

                    <div class="map-stop stop-two"></div>

                    <div class="map-stop stop-three"></div>

                    <div class="map-stop stop-four"></div>


                    <div class="map-bus">
                        🚌
                    </div>


                    <div class="floating-info">

                        <strong>
                            Bus ST-101
                        </strong>

                        <small>
                            On Route · Live
                        </small>

                    </div>


                </div>

            </div>

        </div>

    </div>

</section>



<!-- =========================
     STATS
========================= -->

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
                        Buses supported
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



<!-- =========================
     STORY
========================= -->

<section class="story">

    <div class="container story-grid">


        <div>

            <div class="section-label">
                THE PROJECT
            </div>


            <h2>

                Built around the way
                people <span>actually travel.</span>

            </h2>


            <p class="story-text">

                Finding public transportation information
                should not be complicated. SmartTransit
                brings important travel information into
                one easy-to-use platform.

            </p>


            <p class="story-text">

                Passengers can explore routes, check buses,
                view schedules and access transportation
                information. The system is designed to
                gradually support live bus tracking and
                driver-side operations.

            </p>

        </div>



        <div class="story-cards">


            <div class="story-card large">

                <div class="card-number">
                    01 — VISION
                </div>

                <h3>
                    Make public transportation information
                    simple and accessible.
                </h3>

                <p>

                    SmartTransit aims to create a connected
                    transportation information environment
                    where passengers, drivers and future
                    administrators can interact through
                    one system.

                </p>

            </div>



            <div class="story-card">

                <div class="card-number">
                    02
                </div>

                <h3>
                    Passenger First
                </h3>

                <p>

                    Clear routes, schedules and bus
                    information help passengers make
                    better travel decisions.

                </p>

            </div>



            <div class="story-card">

                <div class="card-number">
                    03
                </div>

                <h3>
                    Connected System
                </h3>

                <p>

                    The platform connects passengers,
                    drivers and transportation data.

                </p>

            </div>


        </div>

    </div>

</section>



<!-- =========================
     MISSION
========================= -->

<section
    class="mission"
    id="mission"
>

    <div class="container">


        <div class="mission-header">

            <div class="section-label">
                WHAT WE FOCUS ON
            </div>


            <h2>
                Designed with a clear purpose.
            </h2>


            <p>

                Every part of SmartTransit is designed
                around making transportation information
                easier to understand and use.

            </p>

        </div>



        <div class="mission-grid">


            <div class="mission-card">

                <div class="mission-icon">
                    🧭
                </div>

                <h3>
                    Easier Navigation
                </h3>

                <p>

                    Help passengers discover routes,
                    stops and transportation options
                    without unnecessary complexity.

                </p>

            </div>



            <div class="mission-card">

                <div class="mission-icon">
                    📡
                </div>

                <h3>
                    Better Information
                </h3>

                <p>

                    Bring bus, route, schedule and
                    operational information together
                    in one platform.

                </p>

            </div>



            <div class="mission-card">

                <div class="mission-icon">
                    🔗
                </div>

                <h3>
                    Connected Operations
                </h3>

                <p>

                    Create a foundation for communication
                    between passengers, drivers and
                    transportation management.

                </p>

            </div>


        </div>

    </div>

</section>



<!-- =========================
     TECHNOLOGY
========================= -->

<section class="technology">

    <div class="container technology-grid">


        <div>

            <div class="section-label">
                TECHNOLOGY
            </div>


            <h2>

                Simple technology.<br>

                <span>Practical results.</span>

            </h2>


            <p>

                SmartTransit is built using straightforward
                web technologies so that the system remains
                understandable, maintainable and suitable
                for future expansion.

            </p>


            <div class="tech-list">


                <div class="tech-item">

                    <div class="tech-check">
                        ✓
                    </div>

                    HTML5 & CSS3 frontend

                </div>


                <div class="tech-item">

                    <div class="tech-check">
                        ✓
                    </div>

                    Vanilla JavaScript

                </div>


                <div class="tech-item">

                    <div class="tech-check">
                        ✓
                    </div>

                    PHP backend

                </div>


                <div class="tech-item">

                    <div class="tech-check">
                        ✓
                    </div>

                    MySQL database

                </div>


                <div class="tech-item">

                    <div class="tech-check">
                        ✓
                    </div>

                    Leaflet & OpenStreetMap

                </div>


            </div>

        </div>



        <div class="tech-panel">


            <div class="tech-panel-top">

                <strong>
                    SMARTTRANSIT SYSTEM
                </strong>

                <span>
                    ONLINE
                </span>

            </div>


            <div class="code-line">
                Passenger → Routes → Bus → Destination
            </div>

            <div class="code-line">
                Driver → Trip → Location → Database
            </div>

            <div class="code-line">
                Map → Stops → Route → Live Position
            </div>

            <div class="code-line">
                PHP → MySQL → SmartTransit
            </div>


        </div>

    </div>

</section>



<!-- =========================
     CTA
========================= -->

<section class="cta">

    <div class="container">

        <div class="cta-box">


            <div>

                <div class="section-label">
                    START EXPLORING
                </div>

                <h2>
                    Your next journey starts here.
                </h2>

                <p>
                    Explore routes and discover the
                    SmartTransit network.
                </p>

            </div>


            <a
                href="passenger/routes.php"
                class="cta-btn"
            >

                Explore Routes →

            </a>


        </div>

    </div>

</section>



<!-- =========================
     FOOTER
========================= -->

<footer class="footer">

    <div class="container footer-grid">


        <div>

            <div class="footer-logo">
                Smart<span>Transit</span>
            </div>

            <p class="footer-description">

                A smart public transportation navigation
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
                Buses
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

        © 2026 SmartTransit · Smart Transportation
        Navigation System

    </div>

</footer>


</body>
</html>