<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->get();
        return response()->json($events);
    }
    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }
        return response()->json($event);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'price' => 'required|numeric|min:0',
            'total_ticket' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'user_id' => 'required|exists:users,id
            
            'location' => 'required|string|max:50',
        ]);
        // $table->bigIncrements('id');
        //     $table->unsignedBigInteger('user_id');
        //     $table->string('name');
        //     $table->text('description')->nullable();
        //     $table->string('location');
        //     $table->dateTime('start_time');
        //     $table->dateTime('end_time');
        //     $table->decimal('price', 10, 2)->default(0.00);
        //     $table->integer('total_ticket')->default(0);
        //     $table->string('image')->nullable();
        //     $table->timestamps();

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $event = Event::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'price' => $request->price,
            'total_ticket' => $request->total_ticket,
            'image' => $request->image ? $request->file('image')->store('images', 'public') : null,
            // 'user_id' => Auth::id(), //

            'location' => $request->location,
             // Assuming the user is authenticated
        ]);

        return response()->json($event, 201);

    }
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after_or_equal:start_time',
            'price' => 'sometimes|required|numeric|min:0',
            'total_ticket' => 'sometimes|required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'user_id' => 'required|exists:users,id'
            'location' => 'sometimes|required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $event->update($request->all());

        return response()->json(['message' => 'Event updated successfully', 'data' => $event]);
    }
    //
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }
        

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
