<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;

class BarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $barang = Barang::with(['jenis'])
                ->where('nama', 'LIKE', '%' . $this->field('nama') . '%')
                ->get();
            return $this->jsonResponse('success', 200, $barang);
        }catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $barang = Barang::with(['jenis'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonResponse('success', 200, $barang);
        }catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
