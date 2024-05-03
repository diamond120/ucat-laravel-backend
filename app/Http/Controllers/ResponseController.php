<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\Response;

class ResponseController extends Controller
{
    public function read($sid, $qid) {
        $response = Response::with(['question'])->firstOrCreate(
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

        return response()->json($response);
    }

    public function write(Request $request) {
        $resposne = Response::updateOrCreate(
            [
                'session_id' => $request->session_id,
                'question_id' => $request->question_id
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
