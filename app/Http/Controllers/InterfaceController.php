<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InterfaceController extends Controller
{
    public function beranda() {
        return view('content.interface.beranda');
    }
    
    public function profil() {
        return view('content.interface.profil');
    }

    public function kontak() {
        return view('content.interface.kontak');
    }

    public function testimonial_form() {
        return view('content.interface.testimoni-form');
    }
    
}
