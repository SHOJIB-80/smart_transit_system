<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$id=(int)($_GET['id']??0);
$stmt=$pdo->prepare("SELECT * FROM buses WHERE id=?"); $stmt->execute([$id]); $bus=$stmt->fetch();
if(!$bus){http_response_code(404);die('Bus not found.');}
$stmt=$pdo->prepare("SELECT COUNT(*) FROM bus_occupancy WHERE bus_id=? AND exited_at IS NULL"); $stmt->execute([$id]); $currentPassengers=(int)$stmt->fetchColumn();
$capacity=max(1,(int)$bus['capacity']); $occupancyPct=min(100,(int)round(($currentPassengers/$capacity)*100)); $density=$occupancyPct<50?'LOW':($occupancyPct<80?'MEDIUM':'HIGH');
$myBoarding=null;
if(currentUser() && currentUser()['role']==='passenger'){
    $stmt=$pdo->prepare("SELECT id FROM bus_occupancy WHERE bus_id=? AND passenger_id=? AND exited_at IS NULL LIMIT 1");
    $stmt->execute([$id,(int)currentUser()['id']]); $myBoarding=$stmt->fetch();
}
$stmt=$pdo->prepare("SELECT s.*,r.route_name,r.route_code FROM schedules s JOIN routes r ON r.id=s.route_id WHERE s.bus_id=? ORDER BY s.departure_time");
$stmt->execute([$id]); $schedules=$stmt->fetchAll();

$pageTitle='Bus Details'; require __DIR__ . '/../includes/header.php';
?>
<main class="section"><div class="container">
<a class="back-link" href="buses.php">← Back to buses</a>
<div class="bus-detail panel"><div><span class="route-code"><?= e($bus['bus_number']) ?></span><h1><?= e($bus['bus_type']) ?></h1><p>Registration: <?= e($bus['registration_number']) ?></p></div><div class="detail-list"><div><span>Capacity</span><b><?= (int)$bus['capacity'] ?></b></div><div><span>Status</span><b><?= e(ucfirst($bus['status'])) ?></b></div><div><span>Women-only</span><b><?= $bus['women_only']?'Yes':'No' ?></b></div></div></div>
<section class="panel occupancy-panel" id="occupancy">
<div class="panel-heading-row"><div><span class="eyebrow">PASSENGER DENSITY</span><h2>Current Occupancy</h2></div><span class="density-<?= strtolower($density) ?> density-badge" id="densityBadge"><?= $density ?></span></div>
<div class="occupancy-detail-grid">
<div><strong id="passengerCount"><?= $currentPassengers ?></strong><span>Passengers</span></div>
<div><strong><?= $capacity ?></strong><span>Capacity</span></div>
<div><strong id="occupancyPercent"><?= $occupancyPct ?>%</strong><span>Occupancy</span></div>
</div>
<div class="occupancy-meter large"><i id="occupancyBar" style="width:<?= $occupancyPct ?>%"></i></div>
<?php if(currentUser() && currentUser()['role']==='passenger' && $bus['status']==='active'): ?>
<div class="occupancy-actions">
<button class="btn" id="boardBtn" <?= $myBoarding?'disabled':'' ?>>Board This Bus</button>
<button class="btn btn-outline" id="leaveBtn" <?= $myBoarding?'':'disabled' ?>>Leave This Bus</button>
</div>
<p id="occupancyMessage" class="form-message"></p>
<p class="muted">Your boarding state is stored in the database. Refreshing the page does not change the count.</p>
<?php elseif(!currentUser()): ?>
<p class="muted">Log in as a passenger to record boarding or leaving this bus.</p>
<?php endif; ?>
</section>
<section class="panel"><h2>Associated Schedules</h2>
<?php foreach($schedules as $s): ?><div class="schedule-row"><strong><?= e($s['route_code']) ?> · <?= e($s['route_name']) ?></strong><span><?= e($s['departure_time']) ?> → <?= e($s['arrival_time']) ?></span><small><?= e($s['operating_days']) ?></small></div><?php endforeach; ?>
<?php if(!$schedules): ?><div class="empty">No associated schedules.</div><?php endif; ?>
</section>
<a class="btn btn-small" href="live-tracking.php?bus_id=<?= (int)$bus['id'] ?>">Track This Bus Live</a>
</div></main>
<?php if(currentUser() && currentUser()['role']==='passenger' && $bus['status']==='active'): ?>
<script>
const occupancyCsrf=<?= json_encode(csrfToken()) ?>;
const busId=<?= (int)$bus['id'] ?>;
const boardBtn=document.getElementById('boardBtn'), leaveBtn=document.getElementById('leaveBtn'), occupancyMessage=document.getElementById('occupancyMessage');
function updateOccupancy(o){
    document.getElementById('passengerCount').textContent=o.passengers;
    document.getElementById('occupancyPercent').textContent=o.occupancy_percentage+'%';
    document.getElementById('occupancyBar').style.width=o.occupancy_percentage+'%';
    const badge=document.getElementById('densityBadge'); badge.textContent=o.density; badge.className='density-'+o.density.toLowerCase()+' density-badge';
}
async function occupancyAction(action){
    const btn=action==='board'?boardBtn:leaveBtn;
    btn.disabled=true;
    try{
        const r=await fetch('../api/occupancy.php',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-Token':occupancyCsrf},body:JSON.stringify({action,bus_id:busId})});
        const d=await r.json();
        if(!r.ok||!d.success) throw new Error(d.message||'Occupancy update failed.');
        updateOccupancy(d.occupancy);
        occupancyMessage.textContent=d.message;
        occupancyMessage.className='form-message ok';
        boardBtn.disabled=action==='board';
        leaveBtn.disabled=action==='leave';
    }catch(e){
        occupancyMessage.textContent=e.message;
        occupancyMessage.className='form-message error';
        await refreshOccupancy();
    }
}
async function refreshOccupancy(){
    try{
        const r=await fetch('../api/occupancy.php?bus_id='+busId,{cache:'no-store'}); const d=await r.json();
        if(d.success) updateOccupancy(d.occupancy);
    }catch(e){}
}
boardBtn.addEventListener('click',()=>occupancyAction('board'));
leaveBtn.addEventListener('click',()=>occupancyAction('leave'));
setInterval(refreshOccupancy,10000);
</script>
<?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>