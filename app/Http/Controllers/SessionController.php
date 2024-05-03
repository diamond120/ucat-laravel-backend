<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\Session;

class SessionController extends Controller
{
    public function create(Request $request) {
        $package = Package::find($request->package_id);
        $section = $package->sections()->first();
        $question = $section->questions()->first();

        $session = Session::create([
            'package_id' => $package->id,
            'user_id' => $request->user_id,
            'completed' => false,
            'score' => null,
            'section_id' => $section->id,
            'question_id' => $question->id,
            'started_at' => now(),
            'finished_at' => null
        ]);

        return response()->json([
            'id' => $session->id
        ]);
    }

    public function get($id) {
        $session = $session = Session::with(['package', 'section', 'question'])->find($id);

        return response()->json([
            'completed' => $session->completed,
            'started_at' => $session->started_at,
            'finished_at' => $session->finished_at,
            'package' => $session->package,
            'section' => $session->section,
            'question' => $session->question
        ]);
    }
}
