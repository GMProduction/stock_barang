<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class BarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $cabang = Auth::user()->cabang_id;
            $barang = Barang::with([
                'jenis:id,nama',
                'stock' => function ($query) use ($cabang) {
                    return $query->where('cabang_id', $cabang)
                        ->select('id', 'barang_id', 'cabang_id', 'qty');
                },
            ])
                ->where('nama', 'LIKE', '%' . $this->field('nama') . '%')
                ->get()->append(['total_stock']);
            return $this->jsonResponse('success', 200, $barang);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $cabang = Auth::user()->cabang_id;
            $barang = Barang::with(['jenis:id,nama', 'stock' => function ($query) use ($cabang) {
                return $query->where('cabang_id', $cabang)
                    ->select('id', 'barang_id', 'cabang_id', 'qty');
            }])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonResponse('success', 200, $barang);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
