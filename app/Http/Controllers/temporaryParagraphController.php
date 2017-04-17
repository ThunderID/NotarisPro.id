<?php

namespace App\Http\Controllers;

use TQueries\Akta\DaftarAkta as Query;

use Request, Session, Response, Redirect;

class temporaryParagraphController extends Controller
{
	public function __construct(Query $query)
	{
		parent::__construct();
		
		$this->query            = $query;
	}    

	public function form()
	{
		return view('temporary.form');
	}

	public function post()
	{
		$paragraph 	= Request::get('text');

		preg_match_all('|<[^>]+>(.*)</[^>]+>|U', $paragraph, $match);

		//disable edit
		//strip path

		Session::put('texteddd', $match[1]);

		return Redirect::route('temp.graph.get');
	}

	public function mentioning()
	{
		$mentioning 	= Request::get('mentioning');

		$mentions 		= [['id' => 'klien.nama', 'name' => 'klien.nama'], ['id' => 'klien.alamat', 'name' => 'klien.alamat'], ['id' => 'klien.pekerjaan', 'name' => 'klien.pekerjaan']];

		return Response::json($mentions);
	}


	public function get()
	{
		if(Session::has('texteddd'))
		{
			$text 		= Session::get('texteddd');

			$new_text 	= [];

			foreach ($text as $key => $value) 
			{
				$text_length 	= strlen($value);
				$start_point 	= 0;
				$end_point 		= min(72, strlen($value));

				if($end_point < 72)
				{
					$dots 				= 72 - $end_point;
					$chunked 			= $value;

					foreach (range(0, $dots-1) as $key2) 
					{
						$chunked 		= $chunked.'-';
					}

					$new_text[$key][]	= $chunked;
				}
				else
				{
					//setiap karakter, 
					do
					{
						//jika spasi ketemu, tandai titik akhir
						if(isset($value[$end_point]) && str_is($value[$end_point], ' '))
						{

							$chunked			=  substr($value, $start_point, $end_point - $start_point);
							
							$dots 				= 72 - ($end_point - $start_point);

							if($dots > 0)
							{
								foreach (range(0, $dots-1) as $key2) 
								{
									$chunked 		= $chunked.'-';
								}
							}

							$new_text[$key][]	= $chunked;
							
							$start_point 		= $end_point+1;
							$end_point 			= $start_point + 72;
						}
						//jika titik akhir bukan spasi, mundur titik akhir sampai ketemu spasi
						else
						{
							$end_point  = $end_point - 1;
						}
					}
					while ($end_point < $text_length && $end_point >0); 
				}
			}
		}

		return view('temporary.show')->with('new_text', $new_text);
	}

}
