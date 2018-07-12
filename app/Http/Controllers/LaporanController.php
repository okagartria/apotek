<?php

namespace App\Http\Controllers;
use App\Obat;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class LaporanController extends Controller
{
    //buat lapora penerimaan
    public function penerimaan(Request $request)
    {
        //check if ajax
        if (request()->ajax()) {
          $date = "01-".$request->input('tgl');
          $dates = date("Y-m-t", strtotime($date));
          $lastmonth = date("Y-m-t", strtotime($date."-1 month"));
            $penerimaan = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan', 'mutasis.masuk', 'mutasis.keluar' ,
            DB::raw(('SUM(CASE WHEN  mutasis.tgl_mutasi >  DATE("'.$lastmonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$dates.'")
              THEN (mutasis.masuk)
              ELSE 0 end) AS jumlah')))
            ->Join('satuans','obats.id_satuan','=','satuans.id')
            ->Join('mutasis','obats.kode_obat','=','mutasis.kode_obat')
            ->groupBy('obats.kode_obat');

            return Datatables::of($penerimaan)
                  ->make(true);
        }
        $data = array('page_title' => "Laporan Penerimaan Obat" );

        return view('admin/laporan.penerimaan',$data);
    }

    //buat laporan pengeluaran
    public function pengeluaran(Request $request)
    {
        //check if ajax
        if (request()->ajax()) {
          $date = "01-".$request->input('tgl');
          $dates = date("Y-m-t", strtotime($date));
          $lastmonth = date("Y-m-t", strtotime($date."-1 month"));
            $penerimaan = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan', 'mutasis.masuk', 'mutasis.keluar' ,
            DB::raw(('  SUM(CASE WHEN  mutasis.tgl_mutasi >  DATE("'.$lastmonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$dates.'")
                THEN (mutasis.keluar)
                ELSE 0 end) AS jumlah')))
            ->Join('satuans','obats.id_satuan','=','satuans.id')
            ->Join('mutasis','obats.kode_obat','=','mutasis.kode_obat')
            ->groupBy('obats.kode_obat');

            return Datatables::of($penerimaan)
                  ->make(true);
        }
        $data = array('page_title' => "Laporan Penerimaan Obat" );

        return view('admin/laporan.pengeluaran',$data);
    }

    //buat laporan bulanan
    public function bulanan(Request $request)
    {
        //check if ajax
        if (request()->ajax()) {
            $date = "01-".$request->input('tgl');
            $dates = date("Y-m-t", strtotime($date));
            $lastmonth = date("Y-m-t", strtotime($date."-1 month"));
            $lasttwomonth = date("Y-m-t", strtotime($date."-2 month"));
            $lastthreemonth = date("Y-m-t", strtotime($date."-3 month"));
            $laporan = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan','obats.stok',
            DB::raw(
              ('SUM(CASE WHEN mutasis.tgl_mutasi <= DATE("'.$lastmonth.'")
                  THEN (mutasis.masuk - mutasis.keluar)
                  ELSE 0 end) AS stok_awal,
                SUM(CASE WHEN  mutasis.tgl_mutasi >  DATE("'.$lastmonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$dates.'")
                  THEN (mutasis.masuk)
                  ELSE 0 end) AS penerimaan,
                SUM(CASE WHEN  mutasis.tgl_mutasi >  DATE("'.$lastmonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$dates.'")
                  THEN (mutasis.keluar)
                  ELSE 0 end) AS pemakaian,
                SUM(CASE WHEN mutasis.tgl_mutasi >  DATE("'.$lasttwomonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$lastmonth.'")
                  THEN (mutasis.keluar)
                  ELSE 0 end) AS pemakaiansebulan,
                SUM(CASE WHEN mutasis.tgl_mutasi >  DATE("'.$lastthreemonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$lasttwomonth.'")
                  THEN (mutasis.keluar)
                  ELSE 0 end) AS pemakaianduabulan,
                SUM(CASE WHEN mutasis.tgl_mutasi <= DATE("'.$dates.'")
                    THEN (mutasis.masuk - mutasis.keluar)
                  ELSE 0 end) AS stok_akhir

                ')
              )
            )
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
