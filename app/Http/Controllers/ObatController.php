<?php

namespace App\Http\Controllers;
use App\Satuan;
use App\Obat;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if (request()->ajax()) {
            $obat = Obat::Join('satuans','obats.id_satuan','=','satuans.id')->select(['obats.*','satuan']);
            return Datatables::of($obat)
                ->addColumn('action',function($row) {
            return '<a href="/obat/'. $row->id .'/edit" class="btn btn-warning">Edit</a>
                    <button class="link btn btn-danger" data-remote="obat/' . $row->id . '">Hapus</button>

                    ';})
                  ->rawColumns(['action'])
                  ->make(true);
        }
        $data = array('page_title' => "Master Obat" );

        return view('admin/obat.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $satuan = Satuan::all();
         return view('admin.obat.create')->with('satuan', $satuan);
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
        request()->validate([
            'kode_obat' => 'required',
            'nama_obat' => 'required',
            'id_satuan' => 'required',
        ]);
        $obat = Obat::create($request->all());
        return redirect()->route('obat.index')
        ->with('success','Berhasil menambah data obat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function show(Obat $obat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function edit(Obat $obat)
    {
        //
        $satuan = Satuan::all();
        return view('admin.obat.edit')->with('obat', $obat)->with('satuan', $satuan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obat $obat)
    {
        //
        request()->validate([
            'kode_obat' => 'required',
            'nama_obat' => 'required',
            'id_satuan' => 'required',
        ]);

        $obat->kode_obat = $request->get('kode_obat');
        $obat->nama_obat = $request->get('nama_obat');
        $obat->stok = $request->get('stok');
        $obat->id_satuan = $request->get('id_satuan');
        $obat->save();
        return redirect('obat')->with('success','Data obat berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Obat  $obat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obat $obat)
    {
        //
        $obat = $obat->delete();
        //$obat = Obat::Join('satuans','obats.id_satuan','=','satuans.id')->select(['obats.*','satuan']);
        return "data berhasil di hapus";
    }
}
