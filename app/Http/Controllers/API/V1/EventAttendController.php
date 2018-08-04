<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\EventAttend;

class EventAttendController extends Controller
{
    /**
     * get
     *
     * @param Illuminate\Http\Request; $request
     * @param int $event_id
     * @return Illuminate\Http\Response;
     */
    public function get(Request $request, int $event_id) 
    {
        $participant = Event::find($event_id)->participant;

        $data = [];

        foreach($participant as $p) {            
            array_push($data, ['id' => $p->id, 'event_id' => $p->event_id, 'user_id' => $p->user_id]);
        }

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    $data         
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);                
    }

    /**
     * store
     *
     * @param Request $request
     * @return Illuminate\Http\Response;
     */
    public function store(Request $request) 
    {
        $id = EventAttend::create($request->all())->id;

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    $id                    
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);        
    }    
}
