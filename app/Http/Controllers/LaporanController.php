<?php

namespace App\Http\Controllers;
use App\Obat;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;
class LaporanController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

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

    public function excelpenerimaan (Request $request)
    {
      $spreadsheet = IOFactory::load('template/pengeluaran.xlsx');
      $sheet = $spreadsheet->getSheet(0);
      $date = "01-".$request->input('tgl');
      $dates = date("Y-m-t", strtotime($date));
      $lastmonth = date("Y-m-t", strtotime($date."-1 month"));
      $startrow = 9;
      $penerimaans = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan', 'mutasis.masuk', 'mutasis.keluar' ,
        DB::raw(('SUM(CASE WHEN  mutasis.tgl_mutasi >  DATE("'.$lastmonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$dates.'")
          THEN (mutasis.masuk)
          ELSE 0 end) AS jumlah')))
        ->Join('satuans','obats.id_satuan','=','satuans.id')
        ->Join('mutasis','obats.kode_obat','=','mutasis.kode_obat')
        ->groupBy('obats.kode_obat')->get();
      $i=0;

      foreach ($penerimaans as $penerimaan) {
        $row = $startrow+$i;
        $sheet->getCell('A'.$row)->setValue($penerimaan->kode);
        $sheet->getStyle('A'.$row)
        ->getNumberFormat()
        ->setFormatCode( NumberFormat::FORMAT_TEXT );
        $sheet->getCell('B'.$row)->setValue($i+1);
        $sheet->getCell('C'.$row)->setValue($penerimaan->nama_obat);
        $sheet->getCell('D'.$row)->setValue($penerimaan->satuan);
        $sheet->getCell('E'.$row)->setValue($penerimaan->jumlah);
        $sheet->insertNewRowBefore($row+2, 1);
        $i++;
      }

        $filename='penerimaan-'.$request->input('tgl').'.xls';
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$writer = IOFactory::createWriter($spreadsheet, 'Xls');
				$writer->save('php://output');
    }



    public function excelpengeluaran (Request $request)
    {
      $spreadsheet = IOFactory::load('template/pengeluaran.xlsx');
      $sheet = $spreadsheet->getSheet(0);
      $date = "01-".$request->input('tgl');
      $dates = date("Y-m-t", strtotime($date));
      $lastmonth = date("Y-m-t", strtotime($date."-1 month"));
      $startrow = 9;
      $penerimaans = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan', 'mutasis.masuk', 'mutasis.keluar' ,
      DB::raw(('  SUM(CASE WHEN  mutasis.tgl_mutasi >  DATE("'.$lastmonth.'") AND  mutasis.tgl_mutasi <=  DATE("'.$dates.'")
          THEN (mutasis.keluar)
          ELSE 0 end) AS jumlah')))
      ->Join('satuans','obats.id_satuan','=','satuans.id')
      ->Join('mutasis','obats.kode_obat','=','mutasis.kode_obat')
      ->groupBy('obats.kode_obat')->get();
      $i=0;

      foreach ($penerimaans as $penerimaan) {
        $row = $startrow+$i;
        $sheet->getCell('A'.$row)->setValue($penerimaan->kode);
        $sheet->getStyle('A'.$row)
        ->getNumberFormat()
        ->setFormatCode( NumberFormat::FORMAT_TEXT );
        $sheet->getCell('B'.$row)->setValue($i+1);
        $sheet->getCell('C'.$row)->setValue($penerimaan->nama_obat);
        $sheet->getCell('D'.$row)->setValue($penerimaan->satuan);
        $sheet->getCell('E'.$row)->setValue($penerimaan->jumlah);
        $sheet->insertNewRowBefore($row+2, 1);
        $i++;
      }

        $filename='pengeluaran-'.$request->input('tgl').'.xls';
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$writer = IOFactory::createWriter($spreadsheet, 'Xls');
				$writer->save('php://output');
    }


    public function excelbulanan (Request $request)
    {
      setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
      Carbon::setLocale('id');
      $spreadsheet = IOFactory::load('template/bulanan.xlsx');
      $sheet = $spreadsheet->getSheet(0);
      $startrow = 13;
      $date = "01-".$request->input('tgl');
      $dates = date("Y-m-t", strtotime($date));
      $tanggal = Carbon::createFromFormat('d-m-Y', $date);
      $lastmonth = date("Y-m-t", strtotime($date."-1 month"));
      $lasttwomonth = date("Y-m-t", strtotime($date."-2 month"));
      $lastthreemonth = date("Y-m-t", strtotime($date."-3 month"));
      $laporans = Obat::select('obats.id as ido','obats.kode_obat as kode','obats.nama_obat', 'satuans.satuan','obats.stok',
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
      ->groupBy('obats.kode_obat')->get();

      $i=0;
      $sheet->getCell('B6')->setValue('PELAPORAN BULAN / PERIODE : '.$tanggal->formatLocalized('%B %Y') );
      foreach ($laporans as $laporan) {
      $persediaan = $laporan->stok_awal + $laporan->penerimaan;
      $stok_opt = ($laporan->pemakaian + $laporan->pemakaiansebulan + $laporan->pemakaianduabulan)/3*3.5;
        $row = $startrow+$i;
        $sheet->getCell('A'.$row)->setValue($laporan->kode);
        $sheet->getCell('B'.$row)->setValue($i+1);
        $sheet->getCell('C'.$row)->setValue($laporan->nama_obat);
        $sheet->getCell('D'.$row)->setValue($laporan->satuan);
        $sheet->getCell('E'.$row)->setValue($laporan->stok_awal);
        $sheet->getCell('F'.$row)->setValue($laporan->penerimaan);
        $sheet->getCell('G'.$row)->setValue($persediaan);
        $sheet->getCell('H'.$row)->setValue($laporan->pemakaian);
        $sheet->getCell('I'.$row)->setValue($laporan->stok_akhir);
        $sheet->getCell('J'.$row)->setValue($stok_opt);
        $sheet->getStyle('J'.$row)
        ->getNumberFormat()
        ->setFormatCode( NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 );
        $sheet->insertNewRowBefore($row+2, 1);
        $i++;
      }

        $filename='laporan-'.$request->input('tgl').'.xls';
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$writer = IOFactory::createWriter($spreadsheet, 'Xls');
				$writer->save('php://output');
    }


}
