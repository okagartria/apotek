<?php

namespace App\Http\Controllers;

use App\Mutasi;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
class MutasiController extends Controller
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
            $mutasi = Mutasi::query();
            return Datatables::of($mutasi)
                ->addColumn('action',function($row) {
            return '<a href="/mutasi/'. $row->id .'/edit" class="btn btn-warning">Edit</a>
            ';})
            ->editColumn('jenis_mutasi', function ($mutasi) {
                if ($mutasi->jenis_mutasi == 0) return 'Penerimaan';
                if ($mutasi->jenis_mutasi == 1) return 'Pengeluaran';
            })
                ->make(true);
        }
        $data = array('page_title' => "Mutasi Obat" );

        return view('admin/mutasi.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.mutasi.create');
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
            'tgl_mutasi' => 'required',
            'jenis_mutasi' => 'required',
            'kode_obat' => 'required',
        ]);
        $obat = Mutasi::create($request->all());
        //kalau penerimaan
        if ($request->input('jenis_mutasi') == 0) {
          DB::table('obats')->where('kode_obat', $request->input('kode_obat'))->increment('stok',$request->input('masuk'));
        } else {
          //kalau pengeluaran
          DB::table('obats')->where('kode_obat', $request->input('kode_obat'))->decrement('stok',$request->input('keluar'));
        }
        return redirect()->route('mutasi.index')
        ->with('success','Berhasil menambah mutasi obat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mutasi  $mutasi
     * @return \Illuminate\Http\Response
     */
    public function show(Mutasi $mutasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mutasi  $mutasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Mutasi $mutasi)
    {
        //
          return view('admin.mutasi.edit')->with('mutasi', $mutasi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mutasi  $mutasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mutasi $mutasi)
    {
        //
        request()->validate([
            'tgl_mutasi' => 'required',
            'jenis_mutasi' => 'required',
            'kode_obat' => 'required',
        ]);
        $mutasi->tgl_mutasi = $request->get('tgl_mutasi');
        $mutasi->jenis_mutasi = $request->get('jenis_mutasi');
        $mutasi->kode_obat = $request->get('kode_obat');
        $mutasi->masuk = $request->get('masuk');
        $mutasi->keluar = $request->get('keluar');
        $mutasi->keterangan = $request->get('keterangan');
        $mutasi->save();
        //kalau penerimaan
        if ($request->input('jenis_mutasi') == 0) {
          DB::table('obats')->where('kode_obat', $request->input('kode_obat'))->increment('stok',$request->input('masuk'));
        } else {
          //kalau pengeluaran
          DB::table('obats')->where('kode_obat', $request->input('kode_obat'))->decrement('stok',$request->input('keluar'));
        }
        return redirect('mutasi')->with('success','Data mutasi berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mutasi  $mutasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mutasi $mutasi)
    {
        //
    }
}
