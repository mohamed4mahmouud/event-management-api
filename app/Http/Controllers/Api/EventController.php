<?php

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;


class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EventResource::collection(Event::with('user')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $eventData = array_merge($request->validated(), ['user_id' => $request->user()->id]);
        $event = Event::create($eventData);
        return EventResource::make($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('user','attendees');
        return EventResource::make($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        if(Gate::denies('update-event', $event)){
            abort(403 , 'You are not authorized to update this event');
        }

        $event->update($request->validated());

        return EventResource::make($event);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {

        if(Gate::denies('update-event', $event)){
            abort(403 , 'You are not authorized to delete this event');
        }
        
        $event->delete();
        return response()->noContent();
    }
}
