<?php
namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class BookingController extends Controller
{

public function store(Request $request)
    {
        $validated = $request->validate([
            'estate_object_id' => 'required|exists:estate_objects,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'guest_name' => 'required|string',
            'guests' => 'required|integer|min:1',
        ]);

        $exists = Booking::isBooked(
            $validated['estate_object_id'],
            $validated['from_date'],
            $validated['to_date']
        );
        if ($exists) {
            return back()->withErrors(['dates' => 'Эти даты уже заняты']);
        }
        Booking::create([
            'user_id' => Auth::id(),
            'guest_name' => $validated['guest_name'],
            'from_date' => $validated['from_date'],
            'to_date' => $validated['to_date'],
            'guests' => $validated['guests'],
            'status' => 'pending',
            'estate_object_id' => $validated['estate_object_id'],
        ]);

        return back();

    }
}
