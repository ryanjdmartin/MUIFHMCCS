 <div class="main">
@include('navbars.main-nav', array('level' => 'hood', 'object' => $hood))
<?php $hood_id = $hood->id;?>
	<div class="main-view">
		<h1>Fumehood {{$hood_id}} detailed info</h1>

	</div>
</div>