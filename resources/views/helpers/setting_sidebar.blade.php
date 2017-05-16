@include('components.sidebarmenu',[
	'title' => 'Menu',
	'lists' => [
		'Akun'		=>[
			'url' 	=> route('akun.edit', $acl_logged_user['id']),
			'icon' 	=> 'fa-user'
		],
		'Kantor'		=>[
			'url' 	=> route('kantor.edit', ['id' => $acl_active_office['kantor']['id']]),
			'icon' 	=> 'fa-building'
		],
		'User' 	=> [
			'url' 	=> route('user.index'),
			'icon' 	=> 'fa-users'
		],
		'Tagihan' 	=> [
			'url' 	=> route('billing.index'),
			'icon' 	=> 'fa-money'
		]
	]
])