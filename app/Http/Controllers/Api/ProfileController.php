<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $user = User::with('cabang')->where('id', Auth::id())->first();
            if (!$user) {
                return $this->jsonResponse('User not found', 202);
            }
            if ($this->request->method() === 'POST') {
                $data = [
                    'username' => $this->postField('username'),
                    'nama' => $this->postField('nama'),
                    'alamat' => $this->postField('alamat'),
                    'no_hp' => $this->postField('no_hp')
                ];
                if ($this->postField('password') !== '') {
                    $data['password'] = Hash::make($this->postField('password'));
                }
                $user->update($data);
                return $this->jsonResponse('success', 200);
            }
            return $this->jsonResponse('success', 200, $user);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
