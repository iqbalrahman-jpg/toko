<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreviewController extends Controller
{
    public function show()
    {
        return view("pages.preview");
    }
}
