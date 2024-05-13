<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\Session;
use App\Models\Response;
use App\Models\Section;

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
            'section_id' => null,
            'question_id' => null,
            'started_at' => now(),
            'finished_at' => null
        ]);

        return response()->json([
            'id' => $session->id
        ]);
    }

    public function get($sid) {
        $session = $session = Session::with(['package', 'section'])->find($sid);
        $sections = [];
        foreach($session->package->sections as $section) {
            $section_temp = [
                'id' => $section->id,
                'name' => $section->name,
                'type' => $section->type,
                'time' => $section->time,
                'questions' => []
            ];
            foreach($section->questions as $question) {
                $response = Response::where(
                    [
                        'session_id' => (int)$sid,
                        'question_id' => (int)$question->id,
                    ],
                )->first();
                
                $status = $response
                    ? $response->value ? 'Completed' : 'InComplete'
                    : 'UnSeen';

                $section_temp['questions'][] = [
                    'id' => $question->id, 
                    'status' => $status,
                    'flagged' => $response->flagged ?? false,
                ];
            }

            $sections[] = $section_temp;
        }

        $remaining_time = null;
        if(!$session->completed && $session->section && $session->section->time)
            $remaining_time = $session->section->time - ($session->last_time - $session->first_time);

        return response()->json([
            'package' => $section->package,
            'completed' => $session->completed,
            'started_at' => $session->started_at,
            'finished_at' => $session->finished_at,
            'section_id' => $session->section_id,
            'question_id' => $session->question_id,
            'remaining_time' => $remaining_time,
            'sections' => $sections
        ]);
    }

    public function navigate($sid, $nid) {
        $session = Session::find($sid);
        ResponseController::time_track($session);

        $session->update([
            'section_id' => $nid,
            'question_id' => null,
            'first_time' => null,
            'last_time' => null
        ]);

        return response()->json(Section::find($nid));
    }

    public function finish($sid) {
        $session = Session::find($sid);
        ResponseController::time_track($session);

        $session->update([
            'completed' => true,
            'finished_at' => now()
        ]);
        
        return response()->json([
            'id' => $sid
        ]);
    }
}
