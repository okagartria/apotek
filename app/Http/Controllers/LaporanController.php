<?php

namespace App\Http\Controllers;
use App\Obat;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class LaporanController extends Controller
{
    //buat lapora penerimaan
    public function penerimaan()
    {
        //check if ajax
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

    //buat laporan pengeluaran
    public function pengeluaran()
    {
        //check if ajax
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

    //buat laporan bulanan
    public function bulanan()
    {
        //check if ajax
        if (request()->ajax()) {
            $laporan = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan','obats.stok',
            DB::raw(
              ('SUM(CASE WHEN MONTH(mutasis.tgl_mutasi)<=MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
                  THEN (mutasis.masuk - mutasis.keluar)
                  ELSE 0 end) AS stok_awal,
                SUM(CASE WHEN MONTH(mutasis.tgl_mutasi)=MONTH(CURRENT_DATE) AND YEAR(mutasis.tgl_mutasi)=YEAR(CURRENT_DATE)
                  THEN (mutasis.masuk)
                  ELSE 0 end) AS penerimaan,
                SUM(CASE WHEN MONTH(mutasis.tgl_mutasi)=MONTH(CURRENT_DATE) AND YEAR(mutasis.tgl_mutasi)=YEAR(CURRENT_DATE)
                  THEN (mutasis.keluar)
                  ELSE 0 end) AS pemakaian,
                SUM(CASE WHEN MONTH(mutasis.tgl_mutasi)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(mutasis.tgl_mutasi)=YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
                  THEN (mutasis.keluar)
                  ELSE 0 end) AS pemakaiansebulan,
                SUM(CASE WHEN MONTH(mutasis.tgl_mutasi)=MONTH(CURRENT_DATE - INTERVAL 2 MONTH) AND YEAR(mutasis.tgl_mutasi)=YEAR(CURRENT_DATE - INTERVAL 2 MONTH)
                  THEN (mutasis.keluar)
                  ELSE 0 end) AS pemakaianduabulan')
              ))
            ->Join('satuans','obats.id_satuan','=','satuans.id')
            ->Join('mutasis','obats.kode_obat','=','mutasis.kode_obat')
            ->groupBy('obats.kode_obat');

            return Datatables::of($laporan)
                  ->addColumn('persediaan', '{{$stok_awal + $penerimaan}}')
                  ->addColumn('stok_opt', '{{($pemakaian + $pemakaiansebulan + $pemakaianduabulan)/3*3.5}}')
                  ->make(true);
        }
        $data = array('page_title' => "Laporan Bulanan" );

        return view('admin/laporan.laporbulan',$data);
    }


}
