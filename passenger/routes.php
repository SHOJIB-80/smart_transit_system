<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$from = trim($_GET['from'] ?? '');
$to = trim($_GET['to'] ?? '');

$sql = "SELECT r.*, COUNT(s.id) AS stop_count
        FROM routes r
        LEFT JOIN stops s ON s.route_id = r.id
        WHERE r.status = 'active'";

$params = [];

if ($from !== '') {
    $sql .= " AND r.starting_point LIKE ?";
    $params[] = "%$from%";
}

if ($to !== '') {
    $sql .= " AND r.ending_point LIKE ?";
    $params[] = "%$to%";
}

$sql .= " GROUP BY r.id ORDER BY r.route_name";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$routes = $stmt->fetchAll();

$pageTitle = 'Routes';

require __DIR__ . '/../includes/header.php';

?>

<style>

/* =========================================================
   ROUTES PAGE
========================================================= */

main.routes-page {
    background: #f5f8f6;
    min-height: calc(100vh - 80px);
}


/* =========================================================
   HERO
========================================================= */

.routes-hero {
    position: relative;
    overflow: hidden;

    padding: 70px 0 85px;

    background:
        radial-gradient(
            circle at 85% 20%,
            rgba(30, 190, 125, .16),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #effaf5,
            #e8f6f0
        );
}

.routes-hero::before {
    content: "";

    position: absolute;

    width: 380px;
    height: 380px;

    border-radius: 50%;

    right: -180px;
    top: -180px;

    background: rgba(8,127,91,.05);
}

.routes-hero::after {
    content: "";

    position: absolute;

    width: 240px;
    height: 240px;

    border-radius: 50%;

    left: -130px;
    bottom: -160px;

    background: rgba(8,127,91,.04);
}

.routes-container {
    width: 90%;
    max-width: 1200px;

    margin: auto;

    position: relative;
    z-index: 2;
}

.routes-hero-grid {
    display: grid;

    grid-template-columns:
        1.1fr
        .9fr;

    align-items: center;

    gap: 70px;
}

.routes-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 8px 13px;

    background: white;

    border: 1px solid #d9ebe4;

    border-radius: 30px;

    color: #087f5b;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: 1.5px;
}

.routes-eyebrow-dot {
    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #18c77c;
}

.routes-hero h1 {
    margin-top: 20px;

    font-size: 58px;

    line-height: 1.03;

    letter-spacing: -3px;

    color: #10231d;
}

.routes-hero h1 span {
    color: #087f5b;
}

.routes-hero-description {
    max-width: 560px;

    margin-top: 18px;

    color: #71817a;

    font-size: 15px;

    line-height: 1.8;
}


/* =========================================================
   HERO VISUAL
========================================================= */

.route-visual {
    height: 285px;

    position: relative;
}

.route-visual-card {
    position: absolute;

    inset: 0;

    background: white;

    border: 1px solid #deebe5;

    border-radius: 24px;

    box-shadow:
        0 25px 55px rgba(17,65,49,.12);

    overflow: hidden;
}

.visual-header {
    height: 53px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 0 18px;

    border-bottom: 1px solid #e8efec;
}

.visual-header strong {
    font-size: 12px;
}

.visual-live {
    display: flex;
    align-items: center;
    gap: 6px;

    color: #087f5b;

    font-size: 9px;

    font-weight: 800;
}

.visual-live span {
    width: 7px;
    height: 7px;

    border-radius: 50%;

    background: #19c77c;
}

.visual-map {
    height: calc(100% - 53px);

    position: relative;

    background:
        linear-gradient(
            30deg,
            transparent 47%,
            #dcebe5 48%,
            #dcebe5 50%,
            transparent 51%
        ),
        linear-gradient(
            120deg,
            transparent 48%,
            #dcebe5 49%,
            #dcebe5 51%,
            transparent 52%
        ),
        #f2f8f5;
}

.route-line {
    position: absolute;

    height: 5px;

    width: 72%;

    left: 14%;
    top: 50%;

    background: #087f5b;

    border-radius: 10px;

    transform: rotate(-12deg);

    box-shadow:
        0 0 0 7px rgba(8,127,91,.07);
}

.route-node {
    position: absolute;

    width: 15px;
    height: 15px;

    border-radius: 50%;

    background: white;

    border: 4px solid #087f5b;

    z-index: 3;
}

.node-1 {
    left: 13%;
    top: 57%;
}

.node-2 {
    left: 36%;
    top: 52%;
}

.node-3 {
    left: 61%;
    top: 47%;
}

.node-4 {
    left: 83%;
    top: 37%;
}

.route-bus {
    position: absolute;

    left: 49%;
    top: 43%;

    width: 44px;
    height: 28px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    background: #087f5b;

    color: white;

    font-size: 14px;

    box-shadow:
        0 8px 20px rgba(8,127,91,.3);

    transform: rotate(-12deg);

    z-index: 4;
}

.route-label {
    position: absolute;

    left: 13%;
    top: 25%;

    padding: 9px 12px;

    background: white;

    border-radius: 9px;

    box-shadow:
        0 8px 20px rgba(20,60,45,.09);

    font-size: 9px;

    font-weight: 700;
}

.route-label small {
    display: block;

    margin-top: 3px;

    color: #8a9892;

    font-size: 8px;

    font-weight: 400;
}


/* =========================================================
   SEARCH SECTION
========================================================= */

.route-search-wrap {
    margin-top: -35px;

    position: relative;
    z-index: 10;
}

.route-search {
    background: white;

    padding: 18px;

    border-radius: 17px;

    border: 1px solid #e1eae6;

    box-shadow:
        0 20px 45px rgba(15,60,45,.10);
}

.search-title {
    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 13px;
}

.search-title strong {
    font-size: 13px;
}

.search-title span {
    color: #899791;

    font-size: 10px;
}

.search-form {
    display: grid;

    grid-template-columns:
        1fr
        1fr
        auto
        auto;

    gap: 10px;
}

.search-field {
    position: relative;
}

.search-field-icon {
    position: absolute;

    left: 14px;
    top: 50%;

    transform: translateY(-50%);

    color: #087f5b;

    font-size: 14px;
}

.search-field input {
    width: 100%;

    height: 48px;

    border: 1px solid #dce7e2;

    border-radius: 10px;

    padding: 0 14px 0 38px;

    outline: none;

    font-family: inherit;

    font-size: 12px;

    color: #24332e;

    background: #fafcfb;

    transition: .2s;
}

.search-field input:focus {
    border-color: #087f5b;

    background: white;

    box-shadow:
        0 0 0 3px rgba(8,127,91,.08);
}

.search-button {
    height: 48px;

    padding: 0 22px;

    border: none;

    border-radius: 10px;

    background: #087f5b;

    color: white;

    cursor: pointer;

    font-family: inherit;

    font-size: 12px;

    font-weight: 700;

    transition: .2s;
}

.search-button:hover {
    background: #076c4e;

    transform: translateY(-1px);
}

.clear-button {
    height: 48px;

    padding: 0 18px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f0f4f2;

    color: #52635d;

    font-size: 12px;

    font-weight: 700;

    transition: .2s;
}

.clear-button:hover {
    background: #e5ece9;
}


/* =========================================================
   ROUTES CONTENT
========================================================= */

.routes-content {
    padding: 65px 0 90px;
}

.routes-heading {
    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    margin-bottom: 25px;
}

.routes-heading h2 {
    margin-top: 6px;

    font-size: 28px;

    letter-spacing: -1px;
}

.routes-heading p {
    color: #84918c;

    font-size: 11px;
}

.route-count {
    padding: 9px 13px;

    background: #e3f7ef;

    color: #087f5b;

    border-radius: 30px;

    font-size: 10px;

    font-weight: 800;
}


/* =========================================================
   ROUTE GRID
========================================================= */

.route-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 17px;
}

.route-card {
    position: relative;

    padding: 23px;

    background: white;

    border: 1px solid #e1eae6;

    border-radius: 17px;

    transition:
        transform .25s,
        box-shadow .25s,
        border-color .25s;

    overflow: hidden;
}

.route-card::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;

    width: 100%;
    height: 3px;

    background: #087f5b;

    transform: scaleX(0);

    transform-origin: left;

    transition: .25s;
}

.route-card:hover {
    transform: translateY(-6px);

    border-color: #cce2d9;

    box-shadow:
        0 20px 40px rgba(15,60,45,.10);
}

.route-card:hover::before {
    transform: scaleX(1);
}


/* route code */

.route-card-top {
    display: flex;

    align-items: center;

    justify-content: space-between;
}

.route-code {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 6px 10px;

    border-radius: 7px;

    background: #e3f7ef;

    color: #087f5b;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: .5px;
}

.route-status {
    display: flex;

    align-items: center;

    gap: 5px;

    color: #7b8a84;

    font-size: 9px;
}

.route-status span {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: #20c77c;
}


/* title */

.route-card h3 {
    margin-top: 17px;

    font-size: 18px;

    color: #13271f;

    line-height: 1.3;
}


/* path */

.route-path {
    margin-top: 17px;

    display: flex;

    align-items: center;

    gap: 8px;
}

.route-point {
    flex: 1;

    min-width: 0;
}

.route-point small {
    display: block;

    color: #9aa69f;

    font-size: 8px;

    text-transform: uppercase;

    letter-spacing: .7px;

    margin-bottom: 4px;
}

.route-point strong {
    display: block;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    font-size: 11px;

    color: #4a5b54;
}

.route-arrow {
    width: 25px;
    height: 25px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #edf5f1;

    color: #087f5b;

    font-size: 12px;
}


/* bottom */

.route-card-bottom {
    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-top: 22px;

    padding-top: 16px;

    border-top: 1px solid #edf1ef;
}

.route-meta {
    display: flex;

    align-items: center;

    gap: 6px;

    color: #7c8b85;

    font-size: 10px;
}

.route-meta-icon {
    color: #087f5b;

    font-size: 13px;
}

.view-route {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 9px 12px;

    background: #087f5b;

    color: white;

    border-radius: 8px;

    font-size: 10px;

    font-weight: 700;

    transition: .2s;
}

.view-route:hover {
    background: #076c4e;

    transform: translateX(2px);
}


/* =========================================================
   EMPTY STATE
========================================================= */

.routes-empty {
    padding: 70px 20px;

    text-align: center;

    background: white;

    border: 1px solid #e1eae6;

    border-radius: 18px;
}

.empty-icon {
    width: 55px;
    height: 55px;

    margin: auto;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #e3f7ef;

    color: #087f5b;

    font-size: 23px;
}

.routes-empty h3 {
    margin-top: 15px;

    font-size: 17px;
}

.routes-empty p {
    margin-top: 7px;

    color: #8b9893;

    font-size: 11px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 950px) {

    .routes-hero-grid {
        grid-template-columns: 1fr;

        gap: 40px;
    }

    .routes-hero h1 {
        font-size: 50px;
    }

    .route-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }

}


@media (max-width: 700px) {

    .search-form {
        grid-template-columns: 1fr;
    }

    .search-button,
    .clear-button {
        width: 100%;
    }

    .route-grid {
        grid-template-columns: 1fr;
    }

    .routes-hero {
        padding: 55px 0 70px;
    }

    .routes-hero h1 {
        font-size: 43px;

        letter-spacing: -2px;
    }

    .routes-heading {
        align-items: flex-start;

        flex-direction: column;

        gap: 12px;
    }

    .route-visual {
        height: 250px;
    }

}

</style>


<main class="routes-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="routes-hero">

        <div class="routes-container">

            <div class="routes-hero-grid">


                <div>

                    <div class="routes-eyebrow">

                        <span class="routes-eyebrow-dot"></span>

                        SMART TRANSPORT NETWORK

                    </div>


                    <h1>

                        Explore your<br>

                        <span>next route.</span>

                    </h1>


                    <p class="routes-hero-description">

                        Discover available SmartTransit routes,
                        explore their stops and find the best
                        connection for your journey.

                    </p>

                </div>



                <!-- VISUAL -->

                <div class="route-visual">

                    <div class="route-visual-card">


                        <div class="visual-header">

                            <strong>
                                Route Network
                            </strong>

                            <div class="visual-live">

                                <span></span>

                                ACTIVE NETWORK

                            </div>

                        </div>


                        <div class="visual-map">

                            <div class="route-line"></div>


                            <div class="route-node node-1"></div>

                            <div class="route-node node-2"></div>

                            <div class="route-node node-3"></div>

                            <div class="route-node node-4"></div>


                            <div class="route-bus">
                                🚌
                            </div>


                            <div class="route-label">

                                Route Network

                                <small>
                                    Connected stops
                                </small>

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </section>



    <!-- =====================================================
         SEARCH
    ====================================================== -->

    <div class="route-search-wrap">

        <div class="routes-container">

            <div class="route-search">


                <div class="search-title">

                    <strong>
                        Find a route
                    </strong>

                    <span>
                        Search by starting point or destination
                    </span>

                </div>


                <form
                    class="search-form"
                    method="get"
                >


                    <div class="search-field">

                        <span class="search-field-icon">
                            ●
                        </span>

                        <input
                            type="text"
                            name="from"
                            value="<?= e($from) ?>"
                            placeholder="Starting point"
                        >

                    </div>



                    <div class="search-field">

                        <span class="search-field-icon">
                            ◆
                        </span>

                        <input
                            type="text"
                            name="to"
                            value="<?= e($to) ?>"
                            placeholder="Destination"
                        >

                    </div>



                    <button
                        class="search-button"
                        type="submit"
                    >

                        Search Routes

                    </button>



                    <a
                        class="clear-button"
                        href="routes.php"
                    >

                        Clear

                    </a>


                </form>

            </div>

        </div>

    </div>



    <!-- =====================================================
         ROUTES
    ====================================================== -->

    <section class="routes-content">

        <div class="routes-container">


            <div class="routes-heading">


                <div>

                    <div class="routes-eyebrow">

                        <span class="routes-eyebrow-dot"></span>

                        AVAILABLE ROUTES

                    </div>


                    <h2>
                        Bus routes
                    </h2>


                    <p>
                        Select a route to explore its complete journey.
                    </p>

                </div>


                <div class="route-count">

                    <?= count($routes) ?>

                    <?= count($routes) === 1 ? 'Route' : 'Routes' ?>

                </div>


            </div>



            <?php if ($routes): ?>


                <div class="route-grid">


                    <?php foreach ($routes as $r): ?>


                        <article class="route-card">


                            <div class="route-card-top">


                                <div class="route-code">

                                    <?= e($r['route_code']) ?>

                                </div>


                                <div class="route-status">

                                    <span></span>

                                    Active

                                </div>


                            </div>



                            <h3>

                                <?= e($r['route_name']) ?>

                            </h3>



                            <div class="route-path">


                                <div class="route-point">

                                    <small>
                                        From
                                    </small>

                                    <strong
                                        title="<?= e($r['starting_point']) ?>"
                                    >

                                        <?= e($r['starting_point']) ?>

                                    </strong>

                                </div>


                                <div class="route-arrow">
                                    →
                                </div>


                                <div class="route-point">

                                    <small>
                                        To
                                    </small>

                                    <strong
                                        title="<?= e($r['ending_point']) ?>"
                                    >

                                        <?= e($r['ending_point']) ?>

                                    </strong>

                                </div>


                            </div>



                            <div class="route-card-bottom">


                                <div class="route-meta">

                                    <span class="route-meta-icon">
                                        ●
                                    </span>

                                    <?= (int)$r['stop_count'] ?>

                                    <?= (int)$r['stop_count'] === 1
                                        ? 'stop'
                                        : 'stops'
                                    ?>

                                </div>


                                <a
                                    class="view-route"
                                    href="route-details.php?id=<?= (int)$r['id'] ?>"
                                >

                                    View Route

                                    <span>
                                        →
                                    </span>

                                </a>


                            </div>


                        </article>


                    <?php endforeach; ?>


                </div>


            <?php else: ?>


                <div class="routes-empty">


                    <div class="empty-icon">
                        🔎
                    </div>


                    <h3>
                        No routes found
                    </h3>


                    <p>
                        Try another starting point or destination.
                    </p>


                </div>


            <?php endif; ?>


        </div>

    </section>


</main>


<?php require __DIR__ . '/../includes/footer.php'; ?>