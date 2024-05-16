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
        $session = Session::find($sid);
        ResponseController::time_track($session);

        $session->update([
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
                'score' => null,
                'duration' => 0
            ]
        );
        $response->load('question');
        
        return response()->json($response);
    }

    public function write($sid, $qid, Request $request) {
        ResponseController::time_track(Session::find($sid));

        $response = Response::with(['question'])->where([
            'session_id' => $sid,
            'question_id' => $qid
        ])->first();

        if($response) {
            $score = 0;
            switch($response->question->type){
            case 'MC':
                if($response->question->answer == $request->value)
                    $score = 1;
                break;
            case 'DD':
                $values = json_decode($request->value);
                $answers = json_decode($response->question->answer);
                $score = 2;
                for($i = 0; $i < count($values); $i++) {
                    if($values[$i] != $answers[$i])
                        $score--;
                }
                if($score < 0) $score = 0;
                break;
            }

            $response->update([
                'value' => $request->value ?? null,
                'flagged' => $request->flagged,
                'score' => $score
            ]);
        }

        return response()->json($response);
    }

    public static function time_track($session) {        
        if($session->completed) return;
        
        $last_time = time();
        $delta = $last_time - $session->last_time;
        $session->update([
            'first_time' => $session->first_time ? $session->first_time : $last_time,
            'last_time' => $last_time,
        ]);

        if($session->section_id && $session->question_id) {
            $response = Response::where([
                'session_id' => $session->id,
                'question_id' => $session->question_id
            ])->first();
            $response->update([
                'duration' =>  $response->duration + $delta
            ]);
        }
    }
}
