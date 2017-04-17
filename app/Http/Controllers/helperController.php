<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TQueries\Tags\TagService;

class helperController extends Controller
{
    private function list_widgets() {
		// $id 			= request()->input('id');

		$call 			= new TagService;
		$call 			= $call::all();
console.log($call);
        return response()->json($regensi);
    }
}
