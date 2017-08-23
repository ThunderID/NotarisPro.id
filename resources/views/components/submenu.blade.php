<?php
	/*
	===================================================================
	Readme
	===================================================================
	Component Name 	:  Submenu (2nd layered menu)
	Author  		:  Budi - budi-purnomo@outlook.com
	Description 	:  Basic 2nd layered menu that optimized to this 
					   theme only
	===================================================================
	Usage
	===================================================================
	Fill this following variable.

	List of parameter:
	1. 	title
		required 	: yes (or you don't want display any title)
		value 		: text with html compatibility. i.e: you want to 
					  add <span> tag 
		description : displaying the title
	2. 	back_route
		required 	: yes (or you want to disable back button)
		value 		: pure url. Not route name.
		description : url redirect back address.	
	3. 	back_button_caption
		required 	: No
		value 		: string
		description : displayed button back caption	
	4. 	menus
		required 	: yes (or you want to display nothing)
		value 		: [
			title 			=> title of the menu (string)	
			class 			=> custom class of following menu 
							   item (string)	
			hide_on 		=> bootstrap class to hide this menu item	
			trigger_modal 	=> data-target of modal. Set null if you 
							   don't want trigger modal, and use this 
							   menu to redirect instead.
			icon 			=> fa icon class you want
			id 				=> element id
			route 			=> url routing Not the route it self. 
							   This will not working if you set 
							   trigger_modal parameter
		]
	*/
?>		

{{-- V1 --}}
<?php
/*
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{-- COMPONENT MENUBAR --}}
			<div class="row bg-faded">

				{{-- Back Button md up --}}
				<div class="hidden-sm-down col-md-3 col-lg-4 pl-md-0 pl-lg-0 pl-xl-0">
					@if(isset($back_route))
					<ul class="nav menu-content justify-content-start">
						<li class="nav-item">
							<a class="nav-link" href="{{ isset($back_route) ? $back_route : '#' }}">
								<i class="fa fa-angle-left"></i>
								 {{ isset($back_button_title) ? $back_button_title : 'Kembali' }}
							</a>
						</li>
					</ul>
					@endif		
				</div>

				{{-- Title mobile, tablet, md screens --}}
				<div class="col-12 col-md-6 col-lg-4 text-center text-md-center text-lg-center text-xl-center">
					<div style="text-overflow:ellipsis; width:100%;">
						<span class="navbar-text mb-0 text-muted">				
							{!! isset($title) ? $title : '' !!}
						</span>
					</div>
				</div>

				{{-- Back Button sm down --}}
				<div class="hidden-md-up col-4 pl-1">
					@if(isset($back_route))
					<ul class="nav menu-content justify-content-start">
						<li class="nav-item">
							<a class="nav-link" href="{{ isset($back_route) ? $back_route : '#' }}">
								<i class="fa fa-angle-left"></i>
								 {{ isset($back_button_title) ? $back_button_title : 'Kembali' }}
							</a>
						</li>
					</ul>
					@endif
				</div>


				{{-- Menu Buttons --}}
				<div class="col-8 col-md-3 col-lg-4 pr-2">
					<ul class="nav menu-content justify-content-end">
						@foreach($menus as $key => $menu)
						
							{{-- Fuze --}}
							<?php
								$route = "";
								if(isset($menu['route'])){
									$route = $menu['route'];
								}							
							?>

							<li class="nav-item {{ isset($menu['hide_on']) ? $menu['hide_on'] : '' }}">
								<a class="nav-link text-center {{ isset($menu['class']) ? $menu['class'] : '' }}"
									href="{{ isset($menu['trigger_modal']) ? 'javascript:void(0);' : $route }}" 
									{{ isset($menu['trigger_modal']) ? 'data-toggle=modal data-target=' . $menu['trigger_modal'] : '' }}
								>
									<i class="fa {{ isset($menu['icon']) ? $menu['icon'] : '' }}"></i>&nbsp;
									<span class="hidden-md-down"> {{ isset($menu['title']) ? $menu['title'] : '' }}</span>
									<span class="hidden-md-up"> {{ isset($menu['title']) ? $menu['title'] : '' }}</span>
								</a>
							</li>
						@endforeach
					</ul>
				</div>

			</div>
			{{-- END COMPONENT MENUBAR --}}
		</div>
*/
?>

{{-- V2 --}}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{-- COMPONENT MENUBAR --}}
			<div class="row bg-faded">

				{{-- Title --}}
				<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-10">
					<div style="text-overflow:ellipsis; width:100%;">
						<span id="judul_akta" class="navbar-text mb-0 text-muted">				
							{!! isset($title) ? $title : '' !!}
						</span>
					</div>
				</div>


				{{-- Menu Buttons --}}
				<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-2 pr-0">
					<ul class="nav menu-content justify-content-end">
						@foreach($menus as $key => $menu)
						
							{{-- Fuze --}}
							<?php
								$route = "";
								if(isset($menu['route'])){
									$route = $menu['route'];
								}							
							?>

							<li class="nav-item {{ isset($menu['hide_on']) ? $menu['hide_on'] : '' }}">
								<a id="{{ isset($menu['id']) ? $menu['id'] : ''}}" class="nav-link text-center {{ isset($menu['class']) ? $menu['class'] : '' }}"
									href="{{ isset($menu['trigger_modal']) ? 'javascript:void(0);' : $route }}" 
									{{ isset($menu['trigger_modal']) ? 'data-toggle=modal data-target=' . $menu['trigger_modal'] : '' }}
								>
									<i class="fa {{ isset($menu['icon']) ? $menu['icon'] : '' }}"></i>
									@if(isset($menu['title']) && $menu['title'] !== '')
									<span class="hidden-md-down"> {{ isset($menu['title']) ? $menu['title'] : '' }}</span>
									<span class="hidden-md-up"> {{ isset($menu['title']) ? $menu['title'] : '' }}</span>
									@endif
								</a>
							</li>
						@endforeach
					</ul>
				</div>

			</div>
			{{-- END COMPONENT MENUBAR --}}
		</div>