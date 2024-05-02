<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Support\Facades\Gate;

class AttendeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $event->attendees()->latest();
        return AttendeeResource::collection($attendees->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendeeRequest $request , Event $event)
    {
        $newAttendee = $event->attendees()->create($request->validated());
        return AttendeeResource::make($newAttendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event , Attendee $attendee)
    {
        return AttendeeResource::make($attendee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event , Attendee $attendee)
    {
        if(Gate::denies('delete-attendee', [$event , $attendee])){
            abort(403 , 'You are not authorized to delete this attendee');
        }

        $attendee->delete();
        return response()->noContent();
    }
}
