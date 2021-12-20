<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $data = [
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'roles' => 'admin',
                'nama' => $this->postField('nama'),
                'alamat' => $this->postField('alamat'),
                'no_hp' => $this->postField('no_hp'),
                'cabang_id' => $this->postField('cabang'),
            ];
            User::create($data);
            return redirect()->back()->with('success');
        }
        $data = User::with(['cabang'])->get();
        $cabang = Cabang::all();
        return view('admin.admin')->with(['data' => $data, 'cabang' => $cabang]);
    }

    public function patch()
    {
        $user = User::find($this->postField('id-edit'));
        $data = [
            'username' => $this->postField('username-edit'),
            'nama' => $this->postField('nama-edit'),
            'alamat' => $this->postField('alamat-edit'),
            'no_hp' => $this->postField('no_hp-edit'),
            'cabang_id' => $this->postField('cabang-edit'),
        ];
        if ($this->postField('password-edit') !== '') {
            $data['password'] = Hash::make($this->postField('password-edit'));
        }
        $user->update($data);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            User::destroy($this->postField('id'));
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
