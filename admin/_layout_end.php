
</main></div></div>
<script>
(function(){
 const b=document.getElementById('adminMenuBtn'),s=document.getElementById('adminSidebar');
 if(b) b.onclick=()=>s.classList.toggle('open');
})();
</script>
<?php if(!empty($adminMap)): ?><script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script><?php endif; ?>
</body></html>
