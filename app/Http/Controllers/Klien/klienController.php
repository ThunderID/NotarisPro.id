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
    public function create($id = null)
    {
        if(!is_null($id)){
            // init
            $this->page_attributes->title   = 'Edit Data Klien';
            $this->page_datas->id           = $id;          

            //get data from database
            $this->page_datas->datas        = $this->query->detailed($id);
        }else{
            // init
            $this->page_attributes->title   = 'Tambah Data Klien';
            $this->page_datas->id           = null;          

            $this->page_datas->datas        = null;
        }

        //initialize view
        $this->view                         = view('pages.klien.create');

        //function from parent to generate view
        return $this->generateView();           
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id = null, Request $request)
    {
        try {
            // get data
            $input                              = $request->only(
                                                        'nama', 
                                                        'tempat_lahir', 
                                                        'tanggal_lahir', 
                                                        'pekerjaan', 
                                                        'nomor_ktp', 
                                                        'alamat'
                                                    );

            //is edit?
            if(!is_null($id)){
                $input['id']                     = $id;
            }
            
            // save
            $data                               = new \TCommands\Klien\SimpanKlien($input);
            $data->handle();            
        } catch (Exception $e) {
            $this->page_attributes->msg['error']       = $e->getMesssage();
        }

        //return view
        if($id == null){
            $this->page_attributes->msg['success']         = ['Data klien telah ditambahkan'];
            return $this->generateRedirect(route('klien.index'));
        }else{
            $this->page_attributes->msg['success']         = ['Data klien telah diperbarui'];
            return $this->generateRedirect(route('klien.show', ['id' => $id]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get data from database
        $this->page_datas->datas            = $this->query->detailed($id);

        //set id
        $this->page_datas->id               = $id;

        // init
        $this->page_attributes->title       = 'Data Klien ' . $this->page_datas->datas['nama'] ;        

        //initialize view
        $this->view                         = view('pages.klien.show');


        //function from parent to generate view
        return $this->generateView(); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->create($id);
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
        return $this->store($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cek apa password benar

        // hapus
        try {
            $klien                                      = new \TCommands\Klien\HapusKlien($id);
            $klien                                      = $klien->handle();
        } catch (Exception $e) {
            $this->page_attributes->msg['error']        = $e->getMesssage();
        }            

        $this->page_attributes->msg['success']         = ['Data klien telah dihapus'];

        //return view
        return $this->generateRedirect(route('klien.index'));
    }
}
