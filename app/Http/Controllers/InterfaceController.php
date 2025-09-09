<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InterfaceController extends Controller
{
    public function beranda() {
        return view('content.interface.beranda');
    }
}
