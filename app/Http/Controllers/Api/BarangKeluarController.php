<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\BarangKeluar;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $cabang_id = Auth::user()->cabang_id;
            $barang_id = $this->postField('barang_id');
            $user = Auth::id();
            $tanggal = $this->postField('tanggal');
            $qty = $this->postField('qty');
            $keterangan = $this->postField('keterangan');
            DB::beginTransaction();
            BarangKeluar::create([
                'barang_id' => $barang_id,
                'cabang_id' => $cabang_id,
                'user_id' => $user,
                'tanggal' => $tanggal,
                'qty' => $qty,
                'keterangan' => $keterangan
            ]);
            $stock = Stock::where('barang_id', '=', $barang_id)
                ->where('cabang_id', '=', $cabang_id)
                ->first();
            if (!$stock) {
                Stock::create([
                    'barang_id' => $barang_id,
                    'cabang_id' => $cabang_id,
                    'qty' => (0 - $qty)
                ]);
            } else {
                $stock->qty = ($stock->qty - $qty);
                $stock->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
