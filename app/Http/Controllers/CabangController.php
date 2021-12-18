<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Cabang;

class CabangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $nama = $this->postField('nama');
            $alamat = $this->postField('alamat');
            Cabang::create([
                'nama' => $nama,
                'alamat' => $alamat
            ]);
            return redirect()->back()->with('success');
        }
        $data = Cabang::all();
        return view('admin.cabang')->with(['data' => $data]);
    }

    public function patch()
    {
        $cabang = Cabang::find($this->postField('id-edit'));
        $data = [
            'nama' => $this->postField('nama-edit'),
            'alamat' => $this->postField('alamat-edit')
        ];
        $cabang->update($data);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            Cabang::destroy($this->postField('id'));
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
