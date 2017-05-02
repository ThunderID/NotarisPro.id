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
		$this->ol     	       	= 0;
		$this->closeol			= 0;
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
		// login info
		$credentials 	= ['email' => 'admin@notaris.id', 'password' => 'admin'];

		$login 			= \TAuth::login($credentials);


		$klien 			= \TKlien\Klien\Models\Klien::first()->toArray();

		$akta 			= new \TQueries\Akta\DaftarAkta;
		$akta 			= $akta->detailed('AFEE0840-9371-4707-A48B-BD753E545A56');


		// $new_text		= $this->count_stripes($akta);

		foreach ($akta['paragraf'] as $key => $value) 
		{
			// $value['konten']					= str_replace('&nbsp;', ' ', $value['konten']);
			$akta['paragraf'][$key]['konten']	= $this->htmlwrap($value['konten'],72);

			if($key==12)
			{
				// dd($akta['paragraf'][$key]['konten']);
			}
		}

		return view('temporary.show')->with('new_text', $akta);
	}

	function htmlwrap(&$str, $maxLength, $char='<br/>')
	{
		//count indent
		$ol 		= substr_count($str, '<ol>');
		$closeol  	= substr_count($str, '</ol>');

		if($ol > 0 && $this->ol > 0)
		{
			$this->ol 	= $this->ol + 1;
			$maxLength 	= $maxLength - ($this->ol* 5);
		}
		
		if($closeol > 0 && $this->ol > 0)
		{
			$maxLength = $maxLength - ($this->ol* 5);
			$this->ol 	= 0;
		}

		if($ol > 0 && $this->ol == 0)
		{
			$maxLength = $maxLength - (5);
			$this->ol 	= $this->ol + 1;
		}

		$str 	= strip_tags($str,"<p><h1><h2><h3><ul><ol><li><b><i>"); 
		// $str 	= str_replace('</span>', ' ', $str);
		$str 	= str_replace('&nbsp;', ' ', $str);
	    $count 	= 0;
	    $newStr = '';
	    $openTag 	= false;
	    $lenstr 	= strlen($str);
	    for($i=0; $i<$lenstr; $i++){
	        $newStr .= $str{$i};
	        if($str{$i} == '<'){
	            $openTag = true;
	            continue;
	        }
	        if(($openTag) && ($str{$i} == '>')){
	            $openTag = false;
	            continue;
	        }
	        if(!$openTag){
	            if($str{$i} == ' '){
	                if ($count == 0) {
	                    $newStr = substr($newStr,0, -1);
	                    continue;
	                } else {
	                    $lastspace = $count + 1;
	                }
	            }
	            $count++;
	            if($count==$maxLength){
	                if ($str{$i+1} != ' ' && $lastspace && ($lastspace < $count)) {
	                    $tmp = ($count - $lastspace)* -1;
	                	$stripes = '';
	                    foreach (range(0, $tmp * 1) as $key) 
	                    {
	                    	$stripes = $stripes.'-';
	                    }
	                    
	                    $newStr = substr($newStr,0, $tmp).$stripes . $char . substr($newStr,$tmp);

	                    if($tmp==0)
	                    {
	                    	dd(substr($newStr,0, $tmp));
	                    }
	                    $count = $tmp * -1;
	                } else {
	                	foreach (range(0, ($maxLength - $count)) as $key) 
	                    {
	                    	$newStr .= '-';
	                    }
	                    
	                    $newStr .= $char;
	                    $count = 0;
	                }
	                $lastspace = 0;
	            }
	        }  
	    }

	    return $newStr;
	}
}
