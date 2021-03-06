<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Stock;
use Carbon\Carbon;
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
            if ($this->request->method() === 'POST') {
                $barang_id = $this->postField('barang');
                $user = Auth::id();
                $tanggal = Carbon::now();
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
                return $this->jsonResponse('success', 200);
            }
            $data = BarangKeluar::with(['barang', 'cabang'])
                ->where('cabang_id', '=', $cabang_id)
                ->orderBy('tanggal', 'DESC')
                ->get();
            $grouped = $data->groupBy('tanggal');
            $result = [];
            setlocale(LC_TIME, 'id_ID');
            Carbon::setLocale('id');
            foreach ($grouped as $key => $item) {
                $tmp['tanggal'] = Carbon::parse($key)->isoFormat('D MMMM Y');
                $tmp['data'] = $item;
                array_push($result, $tmp);
            }
            return $this->jsonResponse('success', 200, $result);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
