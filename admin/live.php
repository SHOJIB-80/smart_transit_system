<?php
require_once __DIR__.'/_common.php'; $adminTitle='Live Monitoring'; $adminMap=true;
$locations=$pdo->query("SELECT ll.*,COALESCE(ll.last_updated,ll.updated_at) AS last_updated,
    b.bus_number,b.bus_type,b.capacity,
    r.route_code,r.route_name,u.name driver,
    (SELECT COUNT(*) FROM bus_occupancy bo WHERE bo.bus_id=b.id AND bo.exited_at IS NULL) AS passengers
    FROM live_locations ll
    JOIN (SELECT bus_id,MAX(id) id FROM live_locations GROUP BY bus_id) x ON x.id=ll.id
    JOIN buses b ON b.id=ll.bus_id
    JOIN routes r ON r.id=ll.route_id
    LEFT JOIN driver_assignments da ON da.bus_id=ll.bus_id AND da.route_id=ll.route_id AND da.status='active'
    LEFT JOIN users u ON u.id=da.driver_id
    ORDER BY ll.last_updated DESC")->fetchAll();
require __DIR__.'/_layout.php';
?>
<div class="admin-page-head"><div><span class="admin-kicker">REAL-TIME NETWORK</span><h2>Live Bus Monitoring</h2><p>Current locations from the existing Part 2 live-location system.</p></div><button class="admin-btn" id="refreshLive">↻ Refresh</button></div>
<section class="admin-panel admin-map-panel"><div id="adminLiveMap"></div></section>
<section class="admin-panel"><div class="admin-panel-head"><h3>Active location feed</h3><span id="liveUpdated">Loaded <?= date('H:i:s') ?></span></div><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Bus</th><th>Route</th><th>Status</th><th>Driver</th><th>Coordinates</th><th>GPS Accuracy</th><th>Density</th><th>Last Updated</th></tr></thead><tbody id="liveRows"><?php foreach($locations as $l): ?><tr><td><strong><?= e($l['bus_number']) ?></strong></td><td><?= e($l['route_code']) ?></td><td><?= statusBadge($l['status']) ?></td><td><?= e($l['driver']??'—') ?></td><td><?= e($l['latitude'].', '.$l['longitude']) ?></td><td><?= $l['accuracy']!==null ? e(round((float)$l['accuracy'],1).' m') : '—' ?></td><?php $cap=max(1,(int)$l['capacity']);$pp=(int)$l['passengers'];$pct=min(100,(int)round(($pp/$cap)*100));$den=$pct<50?'LOW':($pct<80?'MEDIUM':'HIGH'); ?><td><?= $pp ?>/<?= $cap ?> · <span class="density-<?= strtolower($den) ?>"><?= $den ?></span></td><td><?= e($l['last_updated'] ?? $l['updated_at']) ?></td></tr><?php endforeach; ?></tbody></table></div></section>
<script>
const initialLocations=<?= json_encode($locations) ?>;let map,markers={};
function renderMap(data){if(!map){map=L.map('adminLiveMap').setView([23.8103,90.4125],12);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'&copy; OpenStreetMap contributors'}).addTo(map);}
Object.values(markers).forEach(m=>m.remove());markers={};data.forEach(x=>{const m=L.marker([+x.latitude,+x.longitude]).addTo(map).bindPopup('<b>'+x.bus_number+'</b><br>'+x.route_code+' · '+x.status+'<br>GPS accuracy: '+(x.accuracy!==null?Math.round(x.accuracy)+' m':'—')+'<br>Occupancy: '+x.passengers+'/'+x.capacity+'<br>Updated: '+(x.last_updated||x.updated_at));markers[x.bus_id]=m;});}
renderMap(initialLocations);
async function refresh(){try{const r=await fetch('<?= BASE_URL ?>/api/live-location.php');const d=await r.json();if(d.success){renderMap(d.locations);document.getElementById('liveUpdated').textContent='Updated '+new Date().toLocaleTimeString();}}catch(e){}}
document.getElementById('refreshLive').onclick=refresh;setInterval(refresh,30000);
</script>
<?php require __DIR__.'/_layout_end.php'; ?>
