<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function nosotros()
    {
        return view('nosotros');
    }
    public function servicios()
    {
        return view('servicios');
    }
    public function citas()
    {
        return view('citas');
    }
    public function mascotas()
    {
        return view('mascotas');
    }
}
