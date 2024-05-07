<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\Response;
use App\Models\Session;
use App\Models\Question;

class ResponseController extends Controller
{
    public function read($sid, $qid) {
        Session::find($sid)->update([
            'section_id' => Question::find($qid)->section_id,
            'question_id' => $qid,
        ]);

        $response = Response::firstOrCreate(
            [
                'session_id' => (int)$sid,
                'question_id' => (int)$qid
            ],
            [
                'value' => null,
                'flagged' => false,
                'score' => null
            ]
        );
        $response->load('question');
        
        return response()->json($response);
    }

    public function write($sid, $qid, Request $request) {
        $resposne = Response::updateOrCreate(
            [
                'session_id' => $sid,
                'question_id' => $qid
            ],
            [
                'value' => $request->value ?? null,
                'flagged' => $request->flagged,
                'score' => null
            ]
        );
        return response()->json($resposne);
    }
}
