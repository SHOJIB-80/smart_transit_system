<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$selectedBus = (int)($_GET['bus_id'] ?? 0);
$buses = $pdo->query("SELECT id,bus_number,bus_type,status FROM buses WHERE status <> 'inactive' ORDER BY bus_number")->fetchAll();
$pageTitle = 'Live Bus Tracking';
require __DIR__ . '/../includes/header.php';
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIINfQ3QX9sK5x+2YqF3KfH1t1bV2jQ7kM=" crossorigin="" />

<main class="section tracking-page">
<div class="container">
    <div class="page-heading tracking-heading">
        <div>
            <span class="eyebrow">PART 2 · LIVE TRACKING</span>
            <h1>Live Bus Tracking</h1>
            <p>See the latest driver/device location updates on the demonstration network.</p>
        </div>
        <div class="tracking-status"><span class="live-dot"></span> Auto refresh: 10 seconds</div>
    </div>

    <div class="tracking-layout">
        <aside class="tracking-panel panel">
            <label class="tracking-label" for="busSelect">TRACK A BUS</label>
            <select id="busSelect">
                <option value="0">All active locations</option>
                <?php foreach ($buses as $bus): ?>
                    <option value="<?= (int)$bus['id'] ?>" <?= $selectedBus === (int)$bus['id'] ? 'selected' : '' ?>><?= e($bus['bus_number']) ?> · <?= e($bus['bus_type']) ?></option>
                <?php endforeach; ?>
            </select>

            <div id="trackingList" class="tracking-list">
                <div class="empty">Loading live locations…</div>
            </div>

            <div class="tracking-note">
                <strong>Demonstration data</strong>
                <p>Locations are updated by the driver dashboard or seeded demo data. This project does not claim to be connected to a physical GPS device.</p>
            </div>
        </aside>

        <section class="map-panel panel">
            <div id="trackingMap"></div>
            <div class="map-footer">
                <span id="mapUpdated">Waiting for first update…</span>
                <span>Leaflet + OpenStreetMap</span>
            </div>
        </section>
    </div>
</div>
</main>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
const selectedBusId = <?= $selectedBus ?>;
const map = L.map('trackingMap').setView([23.7806, 90.4070], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const markerLayer = L.layerGroup().addTo(map);
const routeLayer = L.layerGroup().addTo(map);
let firstLoad = true;
let currentLocations = [];

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

function haversineKm(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2-lat1) * Math.PI/180;
    const dLon = (lon2-lon1) * Math.PI/180;
    const a = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLon/2)**2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function etaText(location) {
    const stops = (location.stops || []).filter(s => s.latitude !== null && s.longitude !== null);
    if (!stops.length) return 'ETA unavailable';
    let nearest = null;
    let nearestDistance = Infinity;
    stops.forEach(stop => {
        const d = haversineKm(location.latitude, location.longitude, Number(stop.latitude), Number(stop.longitude));
        if (d < nearestDistance) { nearestDistance = d; nearest = stop; }
    });
    if (!nearest) return 'ETA unavailable';
    if (nearestDistance < 0.15) return `At/near ${nearest.stop_name}`;
    const minutes = Math.max(1, Math.ceil((nearestDistance / 22) * 60));
    return `~${minutes} min to ${nearest.stop_name}`;
}

function relativeTime(timestamp) {
    const seconds = Math.max(0, Math.floor((Date.now() - new Date(timestamp.replace(' ', 'T')).getTime()) / 1000));
    if (seconds < 60) return `${seconds}s ago`;
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes} min ago`;
    return `${Math.floor(minutes/60)}h ago`;
}

function renderList(locations) {
    const list = document.getElementById('trackingList');
    if (!locations.length) {
        list.innerHTML = '<div class="empty">No live bus locations are available yet.</div>';
        return;
    }
    list.innerHTML = locations.map((bus, index) => `
        <button class="tracking-item ${index === 0 ? 'selected' : ''}" data-bus-id="${bus.bus_id}">
            <span class="tracking-bus-icon">🚌</span>
            <span class="tracking-item-main">
                <strong>${escapeHtml(bus.bus_number)}</strong>
                <small>${escapeHtml(bus.route_code)} · ${escapeHtml(bus.route_name)}</small>
                <small>${escapeHtml(etaText(bus))}</small>
            </span>
            <span class="tracking-item-status">${escapeHtml(bus.status.replace('_',' '))}</span>
        </button>
    `).join('');
    list.querySelectorAll('.tracking-item').forEach(btn => btn.addEventListener('click', () => {
        const id = Number(btn.dataset.busId);
        const loc = currentLocations.find(x => Number(x.bus_id) === id);
        if (loc) focusBus(loc);
    }));
}

function focusBus(bus) {
    map.setView([bus.latitude, bus.longitude], 14);
    showPopup(bus);
}

function showPopup(bus) {
    const popup = `
        <div class="map-popup">
            <strong>${escapeHtml(bus.bus_number)}</strong>
            <span>${escapeHtml(bus.route_name)}</span>
            <span>Status: ${escapeHtml(bus.status.replace('_',' '))}</span>
            <span>Last updated: ${escapeHtml(relativeTime(bus.updated_at))}</span>
            <span>ETA: ${escapeHtml(etaText(bus))}</span>
        </div>`;
    L.popup().setLatLng([bus.latitude,bus.longitude]).setContent(popup).openOn(map);
}

async function loadLocations() {
    try {
        const url = selectedBusId > 0 ? `../api/live-location.php?bus_id=${selectedBusId}` : '../api/live-location.php';
        const response = await fetch(url, {cache:'no-store'});
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Unable to load locations');
        currentLocations = data.locations || [];
        markerLayer.clearLayers();
        routeLayer.clearLayers();
        renderList(currentLocations);

        const bounds = [];
        currentLocations.forEach(bus => {
            const marker = L.marker([bus.latitude,bus.longitude]).addTo(markerLayer);
            marker.bindTooltip(bus.bus_number, {permanent:false});
            marker.on('click', () => showPopup(bus));
            bounds.push([bus.latitude,bus.longitude]);

            const stops = (bus.stops || []).filter(s => s.latitude !== null && s.longitude !== null);
            if (stops.length) {
                const line = stops.map(s => [Number(s.latitude), Number(s.longitude)]);
                L.polyline(line, {color:'#087f5b', weight:4, opacity:.65, dashArray:'8 7'}).addTo(routeLayer);
                stops.forEach(stop => L.circleMarker([Number(stop.latitude),Number(stop.longitude)], {radius:5,color:'#087f5b',fillColor:'#fff',fillOpacity:1,weight:2}).bindTooltip(stop.stop_name).addTo(routeLayer));
            }
        });

        if (firstLoad && bounds.length) {
            map.fitBounds(bounds, {padding:[30,30], maxZoom:14});
            firstLoad = false;
        }
        document.getElementById('mapUpdated').textContent = `Last refresh: ${new Date().toLocaleTimeString()}`;
    } catch (error) {
        document.getElementById('trackingList').innerHTML = `<div class="alert error">${escapeHtml(error.message)}</div>`;
    }
}

loadLocations();
setInterval(loadLocations, 10000);

document.getElementById('busSelect').addEventListener('change', function() {
    const id = Number(this.value);
    window.location.href = id ? `live-tracking.php?bus_id=${id}` : 'live-tracking.php';
});
</script>
<?php require __DIR__ . '/../includes/footer.php'; ?>
