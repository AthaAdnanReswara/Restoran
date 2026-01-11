<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.dashboard', compact('user'));
        }elseif($user->role === 'pegawai'){
            return view('pegawai.dashboard', compact('user'));
        }else{
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk membuka halaman ini .');
        }
    }
}
