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
			$text 	= Session::get('texteddd');

			foreach ($text as $key => $value) 
			{
				$new_text[$key] = $value;
				$text_length 	= strlen($value);

				if($text_length%72!=0)
				{
					$minus 	= 72 - $text_length;
					$left 	= ceil($minus/2);
					$right 	= floor($minus/2);

					foreach (range(0, $left-1) as $key2) 
					{
						$new_text[$key] = '-'.$new_text[$key];
					}
					foreach (range(0, $right-1) as $key2) 
					{
						$new_text[$key] = $new_text[$key].'-';
					}

				}

				$new_text[$key]	= str_replace('&nbsp;', '--', $new_text[$key]);
				$new_text[$key]	= str_replace('<br>', '--', $new_text[$key]);
			}
		}

		return view('temporary.show')->with('new_text', $new_text);
	}

}
