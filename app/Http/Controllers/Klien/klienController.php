<?php

namespace App\Http\Controllers\Klien;

use Illuminate\Http\Request;
use TQueries\Klien\DaftarKlien as Query;

use App\Http\Controllers\Controller;

class klienController extends Controller
{
    public function __construct(Query $query)
    {
        parent::__construct();
        
        $this->query            = $query;
    }    

	public function index()
    {
        // init
        $this->page_attributes->title       = 'Klien';

        // filter & search
        $query                              = $this->getQueryString(['q', 'urutkan', 'page']);
        $query['per_page']                  = (int)env('DATA_PERPAGE');

        //get data from database
        $this->page_datas->datas            = $this->query->get($query);

        //initialize view
        $this->view                         = view('pages.klien.index');

        //paginate
        $this->paginate(null, $this->query->count($query), (int)env('DATA_PERPAGE'));        


        //function from parent to generate view
        return $this->generateView(); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
