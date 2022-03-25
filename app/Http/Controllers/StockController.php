<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;

class StockController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $cabang = Cabang::all();
        return view('admin.stok')->with(['cabang' => $cabang]);
    }

    public function getList()
    {
        try {
            $cabang = $this->field('cabang');
            $barang = Barang::with([
                'jenis:id,nama',
                'stock' => function ($query) use ($cabang) {
                    return $query->where('cabang_id', $cabang)
                        ->select('id', 'barang_id', 'cabang_id', 'qty');
                },
            ])
                ->where('nama', 'LIKE', '%' . $this->field('nama') . '%')
                ->get()->append(['total_stock']);

            return $this->basicDataTables($barang);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }
}
