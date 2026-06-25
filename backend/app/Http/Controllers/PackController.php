<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackController extends Controller
{
    public function index(){
        return view("admin.packs.index");
    }


    public function create(){
        return view("admin.packs.add");
    }
}
