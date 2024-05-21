<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Package;
use App\Models\Session;


class PackageController extends Controller
{
    public function list() {
        return response()->json(Package::whereNotIn(
            'id',
            Session::where('user_id', 1)->pluck('package_id')
        )->get());        
    }
}
