<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Cabang;
use Illuminate\Http\Request;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function laporanBarangMasukPage()
    {
        $cabang = Cabang::all();
        return view('admin.laporanbarangmasuk')->with(['cabang' => $cabang]);
    }

    public function laporanBarangMasukList()
    {
        try {
            $cabang = $this->field('cabang');
            $start = $this->field('start');
            $end = $this->field('end');
            $model = BarangMasuk::with(['barang.jenis', 'cabang']);
            if ($cabang !== '') {
                $model->where('cabang_id', '=', $cabang);
            }
            $data = $model
                ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))])
                ->orderBy('tanggal', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporanBarangMasukPrint()
    {
        $cabang = $this->field('cabang');
        $start = $this->field('start');
        $end = $this->field('end');
        $model = BarangMasuk::with(['barang.jenis', 'cabang']);
        if ($cabang !== '') {
            $model->where('cabang_id', '=', $cabang);
        }
        $data = $model
            ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))])
            ->orderBy('tanggal', 'DESC')
            ->get();
        return $this->convertToPdf('admin.cetakbarangmasuk', ['data'=> $data, 'start' => $start, 'end' => $end]);
    }

    public function laporanBarangKeluarPage()
    {
        $cabang = Cabang::all();
        return view('admin.laporanbarangkeluar')->with(['cabang' => $cabang]);
    }

    public function laporanBarangKeluarList()
    {
        try {
            $cabang = $this->field('cabang');
            $start = $this->field('start');
            $end = $this->field('end');
            $model = BarangKeluar::with(['barang.jenis', 'cabang']);
            if ($cabang !== '') {
                $model->where('cabang_id', '=', $cabang);
            }
            $data = $model
                ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))])
                ->orderBy('tanggal', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function laporanBarangKeluarPrint()
    {
        $cabang = $this->field('cabang');
        $start = $this->field('start');
        $end = $this->field('end');
        $model = BarangKeluar::with(['barang.jenis', 'cabang']);
        if ($cabang !== '') {
            $model->where('cabang_id', '=', $cabang);
        }
        $data = $model
            ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))])
            ->orderBy('tanggal', 'DESC')
            ->get();
        return $this->convertToPdf('admin.cetakbarangkeluar', ['data'=> $data, 'start' => $start, 'end' => $end]);
    }

//    public function cetakLaporanTransaksi()
//    {
//        $pdf = \App::make('dompdf.wrapper');
//        $pdf->loadHTML($this->dataTransaksi())->setPaper('f4', 'potrait');
//
//        return $pdf->stream();
//    }
//
//    public function dataTransaksi()
//    {
//
//        $data = [
//            'data' => "data",
//            'start' => "2012-01-01",
//            'end' => "2012-01-01",
//        ];
//
//        return view('admin/cetaktransaksi')->with($data);
//    }
//
//    public function cetakLaporanPemasukan()
//    {
//        $pdf = \App::make('dompdf.wrapper');
//        $pdf->loadHTML($this->dataPemasukan())->setPaper('f4', 'potrait');
//
//        return $pdf->stream();
//    }
//
//    public function dataPemasukan()
//    {
//
//        $data = [
//            'data' => "data",
//            'start' => "2012-01-01",
//            'end' => "2012-01-01",
//        ];
//
//        return view('admin/cetakpemasukan')->with($data);
//    }

}
