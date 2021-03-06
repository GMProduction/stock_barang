<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\JenisBarang;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

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
                'barcode' => rand(1000000000, 9999999999),
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
        $barang = Barang::find($this->postField('id-edit'));
        $nama = $this->postField('nama-edit');
        $data = [
            'nama' => $nama,
            'satuan' => $this->postField('satuan-edit'),
            'harga' => $this->postField('harga-edit'),
            'jenis_barang_id' => $this->postField('jenis_barang-edit'),
        ];
        if ($gambar = $this->request->file('gambar-edit')) {
            $ext = $gambar->getClientOriginalExtension();
            $photoTarget = uniqid( 'image-') . '.' . $ext;
            $data['gambar'] = '/gambar/' . $photoTarget;
            $this->uploadImage('gambar-edit', $photoTarget, 'gambar');
        }
        $barang->update($data);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            Barang::destroy($this->postField('id'));
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
