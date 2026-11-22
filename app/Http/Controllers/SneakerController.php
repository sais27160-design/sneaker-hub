<?php

namespace App\Http\Controllers;

use App\Models\Sneaker;

class SneakerController extends Controller
{
    public function index()
    {
        $sneakers = Sneaker::all();

        return view('sneakers.index', compact('sneakers'));
    }
}