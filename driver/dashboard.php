<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireRole('driver');
$user=currentUser();

$stmt=$pdo->prepare("SELECT da.id AS assignment_id,da.bus_id,da.route_id,b.bus_number,b.bus_type,b.registration_number,r.route_code,r.route_name,r.starting_point,r.ending_point FROM driver_assignments da JOIN buses b ON b.id=da.bus_id JOIN routes r ON r.id=da.route_id WHERE da.driver_id=? AND da.status='active' LIMIT 1");
$stmt->execute([(int)$user['id']]);
$assignment=$stmt->fetch();
$trip=null;
if($assignment){
    $stmt=$pdo->prepare("SELECT * FROM trips WHERE driver_id=? AND bus_id=? AND route_id=? AND status='active' ORDER BY id DESC LIMIT 1");
    $stmt->execute([(int)$user['id'],(int)$assignment['bus_id'],(int)$assignment['route_id']]);
    $trip=$stmt->fetch();
}
$condition=null;
if($assignment){
    $stmt=$pdo->prepare("SELECT * FROM vehicle_conditions WHERE bus_id=? ORDER BY reported_at DESC LIMIT 1");
    $stmt->execute([(int)$assignment['bus_id']]);
    $condition=$stmt->fetch();
}
$latestLocation=null;
if($assignment){
    $stmt=$pdo->prepare("SELECT * FROM live_locations WHERE bus_id=? ORDER BY updated_at DESC LIMIT 1");
    $stmt->execute([(int)$assignment['bus_id']]);
    $latestLocation=$stmt->fetch();
}
$pageTitle='Driver Dashboard'; require __DIR__ . '/../includes/header.php';
?>
<main class="section driver-page"><div class="container">
<div class="page-heading"><div><span class="eyebrow">DRIVER AREA · PART 2</span><h1>Welcome, <?= e($user['name']) ?></h1><p>Manage your assigned trip, vehicle condition and driver location.</p></div><div class="driver-status <?= $trip ? 'active' : '' ?>"><span></span><?= $trip ? 'Trip active' : 'No active trip' ?></div></div>

<?php if(!$assignment): ?>
<div class="alert error"><strong>No active assignment.</strong><br>Your account does not currently have an assigned bus and route. Part 3 can expand assignment management.</div>
<?php else: ?>
<div class="driver-grid">
<section class="panel assignment-card"><div class="card-kicker">ASSIGNED VEHICLE</div><h2><?= e($assignment['bus_number']) ?></h2><p><?= e($assignment['bus_type']) ?> · <?= e($assignment['registration_number']) ?></p><div class="assignment-route"><strong><?= e($assignment['route_code']) ?></strong><span><?= e($assignment['starting_point']) ?> → <?= e($assignment['ending_point']) ?></span><small><?= e($assignment['route_name']) ?></small></div><a class="btn btn-small" href="../passenger/live-tracking.php?bus_id=<?= (int)$assignment['bus_id'] ?>">View passenger map</a></section>
<section class="panel trip-card"><div class="card-kicker">TRIP STATUS</div><h2><?= $trip ? 'Active trip' : 'Ready to start' ?></h2><?php if($trip): ?><p>Started: <?= e($trip['start_time']) ?></p><button class="btn danger-btn" id="endTripBtn">End Trip</button><?php else: ?><p>Start the trip before sending GPS/browser location updates.</p><button class="btn" id="startTripBtn">Start Trip</button><?php endif; ?><div id="tripMessage" class="form-message"></div></section>
<section class="panel condition-card"><div class="card-kicker">VEHICLE CONDITION</div><h2><?= $condition ? e($condition['condition_status']) : 'Not reported' ?></h2><p><?= $condition ? e($condition['notes']) : 'Submit a condition report before or during service.' ?></p><form id="conditionForm" class="form-grid compact-form"><select name="condition_status" required><option value="">Select condition</option><option>Good</option><option>Needs Attention</option><option>Maintenance Required</option></select><input name="notes" maxlength="500" placeholder="Notes (optional)"><button class="btn btn-small">Save condition</button></form><div id="conditionMessage" class="form-message"></div></section>
</div>

<section class="panel location-card">
<div class="location-header"><div><div class="card-kicker">REAL GPS TRACKING</div><h2>Live Device Location</h2><p>Use this driver's phone GPS. Your browser will continuously send real latitude, longitude, accuracy and time while the trip is active.</p></div><span class="location-time" id="locationTime"><?= $latestLocation ? 'Last: '.e($latestLocation['last_updated'] ?? $latestLocation['updated_at']) : 'No GPS update yet' ?></span></div>
<div class="location-controls">
<button class="btn" id="startLiveBtn" <?= $trip ? '' : 'disabled' ?>>▶ Start Live Location</button>
<button class="btn btn-outline" id="stopLiveBtn" disabled>■ Stop Live Location</button>
</div>
<div class="gps-readout">
<div><span>Status</span><strong id="gpsStatus"><?= $trip ? 'Ready — GPS not started' : 'Start a trip first' ?></strong></div>
<div><span>Latitude</span><strong id="gpsLat">—</strong></div>
<div><span>Longitude</span><strong id="gpsLng">—</strong></div>
<div><span>Accuracy</span><strong id="gpsAccuracy">—</strong></div>
</div>
<div id="locationMessage" class="form-message"></div>
</section>
<section class="panel emergency-card"><div><div class="card-kicker">EMERGENCY</div><h2>Report an Emergency</h2><p>Use this form for a real driver-side project demonstration. No SMS/email is sent in Part 2.</p></div><form id="emergencyForm" class="form-grid emergency-form"><input name="title" maxlength="150" required placeholder="Emergency title"><textarea name="description" maxlength="2000" required placeholder="Describe what happened"></textarea><select name="severity"><option>Low</option><option selected>Medium</option><option>High</option><option>Critical</option></select><button class="btn danger-btn">Submit Emergency Report</button></form><div id="emergencyMessage" class="form-message"></div></section>
<?php endif; ?>
</div></main>
<script>
const apiBase = '../api/';
const assignment = <?= json_encode($assignment ?: null) ?>;
const csrfToken = <?= json_encode(csrfToken()) ?>;
async function postJson(endpoint,payload){const r=await fetch(apiBase+endpoint,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-Token':csrfToken},body:JSON.stringify(payload)});const d=await r.json();if(!r.ok||!d.success)throw new Error(d.message||'Request failed');return d;}
function message(id,text,ok=true){const el=document.getElementById(id);if(el){el.textContent=text;el.className='form-message '+(ok?'ok':'error');}}
const start=document.getElementById('startTripBtn');
if(start) start.addEventListener('click',async()=>{try{const d=await postJson('trip.php',{action:'start'});message('tripMessage',d.message,true);setTimeout(()=>location.reload(),700);}catch(e){message('tripMessage',e.message,false);}});
const end=document.getElementById('endTripBtn');
if(end) end.addEventListener('click',async()=>{if(!confirm('End the current trip?'))return;try{const d=await postJson('trip.php',{action:'end'});message('tripMessage',d.message,true);setTimeout(()=>location.reload(),700);}catch(e){message('tripMessage',e.message,false);}});
const conditionForm=document.getElementById('conditionForm');
if(conditionForm) conditionForm.addEventListener('submit',async e=>{e.preventDefault();const f=new FormData(conditionForm);try{const d=await postJson('vehicle-condition.php',Object.fromEntries(f.entries()));message('conditionMessage',d.message,true);setTimeout(()=>location.reload(),700);}catch(e){message('conditionMessage',e.message,false);}});
let watchId = null;
let lastGpsSend = 0;

function setGpsStatus(text, ok=true){
    const el=document.getElementById('gpsStatus');
    if(el){ el.textContent=text; el.style.color=ok ? '' : '#b42318'; }
}
function setGpsControls(running){
    const start=document.getElementById('startLiveBtn');
    const stop=document.getElementById('stopLiveBtn');
    if(start) start.disabled = running || !assignment;
    if(stop) stop.disabled = !running;
}

async function sendLocation(position){
    const now = Date.now();
    // Prevent an unusually chatty browser from flooding the API.
    if(now - lastGpsSend < 2000) return;
    lastGpsSend = now;

    const lat=position.coords.latitude;
    const lng=position.coords.longitude;
    const accuracy=position.coords.accuracy;

    document.getElementById('gpsLat').textContent=lat.toFixed(7);
    document.getElementById('gpsLng').textContent=lng.toFixed(7);
    document.getElementById('gpsAccuracy').textContent=Number.isFinite(accuracy) ? `${Math.round(accuracy)} m` : 'Unavailable';

    try{
        const d=await postJson('live-location.php',{
            bus_id:Number(assignment.bus_id),
            route_id:Number(assignment.route_id),
            latitude:lat,
            longitude:lng,
            accuracy:Number.isFinite(accuracy) ? accuracy : null,
            gps_timestamp:position.timestamp || Date.now(),
            status:'on_route'
        });
        message('locationMessage',d.message,true);
        document.getElementById('locationTime').textContent='Last GPS update: '+new Date().toLocaleTimeString();
        setGpsStatus('LIVE — sending real device GPS',true);
    }catch(e){
        message('locationMessage',e.message,false);
        setGpsStatus('GPS obtained, server update failed',false);
    }
}

function gpsError(error){
    let text='Unable to read device GPS.';
    if(error && error.code===1) text='GPS permission was denied. Allow location access for this site and try again.';
    else if(error && error.code===2) text='Device location is unavailable. Check the phone GPS/location setting.';
    else if(error && error.code===3) text='GPS request timed out. Move to an area with a clearer GPS signal and try again.';
    message('locationMessage',text,false);
    setGpsStatus('Tracking unavailable',false);
    stopLiveLocation(false);
}

function startLiveLocation(){
    if(!assignment){message('locationMessage','No active bus/route assignment.',false);return;}
    if(!navigator.geolocation){
        message('locationMessage','This browser does not provide GPS geolocation.',false);
        setGpsStatus('Tracking unavailable',false);
        return;
    }
    if(watchId!==null) return;

    message('locationMessage','Requesting real device GPS permission…',true);
    setGpsStatus('Requesting GPS permission…',true);

    watchId=navigator.geolocation.watchPosition(sendLocation,gpsError,{
        enableHighAccuracy:true,
        timeout:15000,
        maximumAge:5000
    });
    setGpsControls(true);
}

function stopLiveLocation(showMessage=true){
    if(watchId!==null){
        navigator.geolocation.clearWatch(watchId);
        watchId=null;
    }
    setGpsControls(false);
    if(showMessage){
        message('locationMessage','Live GPS sharing stopped on this device.',true);
        setGpsStatus('Stopped',true);
    }
}

const startLive=document.getElementById('startLiveBtn');
if(startLive) startLive.addEventListener('click',startLiveLocation);

const stopLive=document.getElementById('stopLiveBtn');
if(stopLive) stopLive.addEventListener('click',()=>stopLiveLocation(true));

window.addEventListener('beforeunload',()=>{ if(watchId!==null) navigator.geolocation.clearWatch(watchId); });

const emergency=document.getElementById('emergencyForm');
if(emergency) emergency.addEventListener('submit',async e=>{e.preventDefault();const f=new FormData(emergency);try{const d=await postJson('emergency.php',Object.fromEntries(f.entries()));message('emergencyMessage',d.message,true);emergency.reset();}catch(e){message('emergencyMessage',e.message,false);}});
</script>
<?php require __DIR__ . '/../includes/footer.php'; ?>
