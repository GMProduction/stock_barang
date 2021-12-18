<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\JenisBarang;

class JenisBarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $nama = $this->postField('nama');
            JenisBarang::create([
                'nama' => $nama,
            ]);
            return redirect()->back()->with('success');
        }
        $data = JenisBarang::all();
        return view('admin.jenisbarang')->with(['data' => $data]);
    }

    public function patch()
    {
        $jenis = JenisBarang::find($this->postField('id-edit'));
        $data = [
            'nama' => $this->postField('nama-edit'),
        ];
        $jenis->update($data);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            JenisBarang::destroy($this->postField('id'));
            return response()->json([
                'msg' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'gagal ' . $e
            ], 500);
        }
    }
}
