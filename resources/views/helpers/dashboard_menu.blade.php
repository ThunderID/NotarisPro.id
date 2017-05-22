<?php
	// Sidebar Menu List
	$list['Klien'] 		= 	[
								'url' 	=> route('home.dashboard'),
								'icon' 	=> 'fa-users'
							];
	$list['KPI'] 		= 	[
								'url' 	=> route('kpi.dashboard'),
								'icon' 	=> 'fa-vcard',
							];
	$list['Keuangan']	= 	[
								'url' 	=> route('finance.dashboard'),
								'icon' 	=> 'fa-money'
							];

	// Set Activate Menu
	// Readme : set $active parameter (sile including this section) set to $list's array index
	$list[$active]['active'] = 'active';								
?>

<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 sidebar hide-mobile sidebar subset-menu target-menu">

	<div class="panel hidden-md-up text-right">
		<a href="javascript:void(0);" class="btn btn-outline-primary btn-default btn-toggle-menu-off">
			<i class="fa fa-times" aria-hidden="true"></i>
		</a>
	</div>

	<div class="panel">
		@include('components.sidebarmenu',[
			'title' => 'Menu',
			'lists' => $list
		])
	</div>	
</div>