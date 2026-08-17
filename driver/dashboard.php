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

<section class="panel location-card"><div class="location-header"><div><div class="card-kicker">LOCATION UPDATE</div><h2>Share Current Location</h2><p>Browser geolocation is preferred. Manual coordinates are available as a demonstration fallback.</p></div><span class="location-time" id="locationTime"><?= $latestLocation ? 'Last: '.e($latestLocation['updated_at']) : 'No update yet' ?></span></div><div class="location-controls"><button class="btn" id="shareLocationBtn" <?= $trip ? '' : 'disabled' ?>>Use Browser Location</button><label>Latitude<input id="manualLat" type="number" step="0.0000001" placeholder="23.7806000"></label><label>Longitude<input id="manualLng" type="number" step="0.0000001" placeholder="90.4070000"></label><button class="btn btn-outline" id="manualLocationBtn" <?= $trip ? '' : 'disabled' ?>>Send Manual Location</button></div><div id="locationMessage" class="form-message"></div></section>

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
async function sendLocation(lat,lng){try{const d=await postJson('live-location.php',{bus_id:Number(assignment.bus_id),route_id:Number(assignment.route_id),latitude:lat,longitude:lng,status:'on_route'});message('locationMessage',d.message,true);document.getElementById('locationTime').textContent='Updated: '+new Date().toLocaleTimeString();}catch(e){message('locationMessage',e.message,false);}}
const share=document.getElementById('shareLocationBtn');
if(share) share.addEventListener('click',()=>{if(!navigator.geolocation){message('locationMessage','Browser geolocation is unavailable. Use manual coordinates.',false);return;}message('locationMessage','Requesting browser location…',true);navigator.geolocation.getCurrentPosition(p=>sendLocation(p.coords.latitude,p.coords.longitude),err=>message('locationMessage','Location permission failed: '+err.message,false),{enableHighAccuracy:true,timeout:10000,maximumAge:0});});
const manual=document.getElementById('manualLocationBtn');
if(manual) manual.addEventListener('click',()=>{const lat=Number(document.getElementById('manualLat').value),lng=Number(document.getElementById('manualLng').value);if(!Number.isFinite(lat)||lat<-90||lat>90||!Number.isFinite(lng)||lng<-180||lng>180){message('locationMessage','Enter valid latitude and longitude.',false);return;}sendLocation(lat,lng);});
const emergency=document.getElementById('emergencyForm');
if(emergency) emergency.addEventListener('submit',async e=>{e.preventDefault();const f=new FormData(emergency);try{const d=await postJson('emergency.php',Object.fromEntries(f.entries()));message('emergencyMessage',d.message,true);emergency.reset();}catch(e){message('emergencyMessage',e.message,false);}});
</script>
<?php require __DIR__ . '/../includes/footer.php'; ?>
