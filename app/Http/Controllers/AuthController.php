<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use Illuminate\Support\Facades\Redirect;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $credentials = [
                'username' => $this->postField('username'),
                'password' => $this->postField('password'),
            ];
            if($this->isAuth($credentials)) {
                return redirect('/admin');
            }
            return Redirect::back()->withErrors(['failed', 'Periksa Kembali Username dan Password Anda']);
        }
        return view('login');
    }
}
