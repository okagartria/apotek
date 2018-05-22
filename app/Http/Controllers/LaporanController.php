<?php

namespace App\Http\Controllers;
use App\Obat;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class LaporanController extends Controller
{
    //
    public function penerimaan()
    {
        //
        if (request()->ajax()) {
            $penerimaan = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan', 'mutasis.masuk', 'mutasis.keluar' , DB::raw(('SUM(mutasis.masuk) As jumlah')))
            ->Join('satuans','obats.id_satuan','=','satuans.id')
            ->leftJoin('mutasis','obats.kode_obat','=','mutasis.kode_obat')
            ->groupBy('obats.kode_obat');

            return Datatables::of($penerimaan)
                  ->make(true);
        }
        $data = array('page_title' => "Laporan Penerimaan Obat" );

        return view('admin/laporan.penerimaan',$data);
    }

    //
    public function pengeluaran()
    {
        //
        if (request()->ajax()) {
            $penerimaan = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan', 'mutasis.masuk', 'mutasis.keluar' , DB::raw(('SUM(mutasis.keluar) As jumlah')))
            ->Join('satuans','obats.id_satuan','=','satuans.id')
            ->leftJoin('mutasis','obats.kode_obat','=','mutasis.kode_obat')
            ->groupBy('obats.kode_obat');

            return Datatables::of($penerimaan)
                  ->make(true);
        }
        $data = array('page_title' => "Laporan Penerimaan Obat" );

        return view('admin/laporan.pengeluaran',$data);
    }
}
