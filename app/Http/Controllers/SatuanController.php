<?php

namespace App\Http\Controllers;

use App\Satuan;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class SatuanController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (request()->ajax()) {
            return Datatables::of(Satuan::query())
                ->addColumn('action',function($row) {
            return '<a href="/satuan/'. $row->id .'/edit" class="btn btn-warning">Edit</a>
            <button class="link btn btn-danger" data-remote="/satuan/' . $row->id . '">Hapus</button>
              ';})
              ->rawColumns(['action'])
                ->make(true);
        }
        $data = array('page_title' => "Master Satuan" );

        return view('admin/satuan.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

         return view('admin.satuan.create');
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
            'satuan' => 'required',
        ]);
        $room = Satuan::create($request->all());
        return redirect()->route('satuan.index')
        ->with('success','Berhasil menambah data satuan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Satuan $satuan)
    {
        //
        return view('admin.satuan.edit')->with('satuan', $satuan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Satuan $satuan)
    {
        //

        $this->validate(request(), [
            'satuan' => 'required',
        ]);

        $satuan->satuan = $request->get('satuan');
        $satuan->save();
        return redirect('satuan')->with('success','Data satuan berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Satuan $satuan)
    {
        //
        $satuan = $satuan->delete();
        //$obat = Obat::Join('satuans','obats.id_satuan','=','satuans.id')->select(['obats.*','satuan']);
        return "data berhasil di hapus";
    }
}
