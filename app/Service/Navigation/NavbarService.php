<?php

namespace App\Service\Navigation;

/**
 * Kelas Navbar
 *
 * Digunakan generate Navbar berdasarkan policy.
 *
 * @author     Budi P <budi@thunderlab.id>
 */
class NavbarService 
{
	/**
	 * Membuat object asset baru dari data array
	 *
	 * @return array $nav
	 */
	public static function all()
	{
		// Menu navigation manifests
		// Build your sitemap using this data structure bellow
		// Structure
		/*
			$nav =	[
					$nav_caption	=> 	[
											route 	=> $nav_routing,
											sub 	=> 	[
															$sub_nav_caption => $sub_nav_routing
														]
										]
				]
		*/
		// note: if menu have sub's, route parameter should be assigned with null. this will prevent menu from redirecting rather than showing it's sub's navigation menu.
		return [
				'dashboard' => 	[
									'route' => route('dashboard.index'),
									'sub'	=> []
								],
				'akta'		=>	[
									'route' => null,
									'sub'	=> 	[
													'drafting' 		=> [
														'route'		=> route('dashboard.index'),
														'sub'	=> []
													],
													'data_akta'		=> [
														'route'		=> route('dashboard.index'),
														'sub'	=> []
													],
												]
								],
				'klien'		=>	[
									'route' => null,
									'sub'	=> 	[
													'appointment' 	=> [
														'route'		=> route('dashboard.index'),
														'sub'	=> []
													],
												]
								],
				'keuangan'	=>	[
									'route' => null,
									'sub'	=> 	[
													'tagihan' 		=> [
														'route'		=> route('tagihan.index'),
														'sub'		=> []
													],
													'tagihan_baru' 	=> [
														'route'		=> route('tagihan.create'),
														'sub'		=> []
													],
												]				
								],
			]; 
	}
}