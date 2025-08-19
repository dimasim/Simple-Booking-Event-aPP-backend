<?php


namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'quantity' =>'required|integer|min:1',
            'total_price' =>'required|numeric|min:0',
            'status' =>'required|string|in:pending,confirmed,cancelled',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $event = Event::find($request->event_id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }   

        if ($event->total_ticket < $request->ticket_quantity) {
            return response()->json(['error' => 'Not enough tickets available'], 400);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        // Update the total_ticket count in the event
        $event->total_ticket -= $request->ticket_quantity;
        $event->save();

        return response()->json(['message' => 'Booking successful', 'booking' => $booking], 201);
    }
    //
    public function myBookings()
    {
        $user = Auth::user();
        $bookings = $user->bookings;
        return response()->json($bookings);
    }

}
