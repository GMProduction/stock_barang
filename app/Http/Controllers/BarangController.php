<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\JenisBarang;

class BarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $nama = $this->postField('nama');
            $data = [
                'nama' => $nama,
                'barcode' => uniqid(),
                'satuan' => $this->postField('satuan'),
                'harga' => $this->postField('harga'),
                'jenis_barang_id' => $this->postField('jenis_barang'),
                'gambar' => null,
            ];
            if ($gambar = $this->request->file('gambar')) {
                $ext = $gambar->getClientOriginalExtension();
                $photoTarget = uniqid( 'image-') . '.' . $ext;
                $data['gambar'] = '/gambar/' . $photoTarget;
                $this->uploadImage('gambar', $photoTarget, 'gambar');
            }
            Barang::create($data);
            return redirect()->back()->with('success');
        }
        $data = Barang::with(['jenis'])->get();
        $jenis = JenisBarang::all();
        return view('admin.barang')->with(['data' => $data, 'jenis' => $jenis]);
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
