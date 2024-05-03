<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

use App\Models\Section;
class SectionController extends Controller
{
    public function get($id) {
        return response()->json(Section::find($id));
    }
}
