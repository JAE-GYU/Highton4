<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\EventAttend;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reqestQuery = request()->query();
        array_key_exists('page', $reqestQuery) ? $page = $reqestQuery['page'] : $page = 0;
        array_key_exists('perPage', $reqestQuery) ? $perPage = $reqestQuery['perPage'] : $perPage =15;
        array_key_exists('currentLocation', $reqestQuery) ? $currentLocation = $reqestQuery['currentLocation'] : $currentLocation = null;
        
        if($currentLocation != null) {
            $temp = explode(',',$currentLocation);

            $lat1 = $temp[0];
            $lng1 = $temp[1];
        }

        $totalNum = Event::count();
        $totalPage = ceil($totalNum/$perPage);      
        
        if ($totalPage < $page) {
            return response()->json([
                'error' => [
                    'code' => 400,
                    'message' => [
                        '잘못된 페이지 숫자'
                    ],
                ]
            ],400,[],JSON_UNESCAPED_UNICODE);    
        }

        $result = Event::where('id','>',(($page -1) * $perPage))->limit($perPage)->get();
        $result2 = [];

        foreach($result as $r) {
            $temp = explode(',',$r->location);
            $lat2 = $temp[0];
            $lng2 = $temp[1];

            if($currentLocation != null) {
                $distance = round($this->getDistance($lat1, $lng1, $lat2, $lng2),2);            
                $r->distance = $distance;
                array_push($result2,$r->getAttributes());
            }
        }

        if($currentLocation != null) {
            usort($result2, function($a, $b) {
                return $a['distance'] < $b['distance'] ? -1 : 1;
            });     
        }

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => $currentLocation != null ? $result2 : $result,
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * search
     *
     * @param @return \Illuminate\Http\Request $request
     * @param mixed $hash_tag
     * @return @return \Illuminate\Http\Response
     */
    public function search(Request $request, $search) 
    {        
        $event = Event::where('hash_tag', 'like', '%#'.$search.'%')->orWhere('title','like','%'.$search.'%')->get();

        $result = [];

        foreach($event as $r) {
            array_push($result,$r->getAttributes());
        }

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => $result
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Event::create($request->all())->id;

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    'success',
                    $id
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        $data = [
            'id' => $event->id,
            'creator_id' => $event->creator_id,
            'title' => $event->title,
            'description' => $event->description,
            'location' => $event->location,
            'hash_tag' => $event->hash_tag,
            'event_date' => $event->event_date,
            'event_pic' => $event->event_pic,
            'phone' => $event->phone,
            'created_at' => $event->created_at,
            'status' => $event->status
        ];

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $event->update($request->all());

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    $id                    
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return response()->json([
            'data' => [
                'code' => 200,
                'message' => [
                    'success',
                    $id                    
                ],
            ]
        ],200,[],JSON_UNESCAPED_UNICODE);

    }

   /**
    * getDistance
    *
    * @param mixed $lat1 위도1
    * @param mixed $lng1 경도1
    * @param mixed $lat2 위도2
    * @param mixed $lng2 경도2
    * @return double $d
    */
    function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earth_radius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lng2 - $lng1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;
        return $d;
    }
}
