<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Package;

class PackageController extends Controller
{
    public function list() {
        return response()->json(Package::all());
    }
}
