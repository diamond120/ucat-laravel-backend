<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\Session;
use App\Models\Response;

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

    public function get($sid) {
        $session = $session = Session::with(['package'])->find($sid);
        $sections = [];
        foreach($session->package->sections as $section) {
            $section_temp = [
                'id' => $section->id,
                'questions' => []
            ];
            foreach($section->questions as $question) {
                $response = Response::where(
                    [
                        'session_id' => (int)$sid,
                        'question_id' => (int)$question->id,
                    ],
                )->first();
                
                $status = 'UnSeen';
                if($response) {
                    if($response->flagged) $status = 'Flagged';
                    if($response->value) $status = 'Completed';
                    else $status = 'InComplete';            
                }

                $section_temp['questions'][] = [
                    'id' => $question->id,
                    'status' => $status
                ];
            }

            $sections[] = $section_temp;
        }

        return response()->json([
            'completed' => $session->completed,
            'started_at' => $session->started_at,
            'finished_at' => $session->finished_at,
            'section_id' => $session->section_id,
            'question_id' => $session->question_id,
            'sections' => $sections
        ]);
    }
}
