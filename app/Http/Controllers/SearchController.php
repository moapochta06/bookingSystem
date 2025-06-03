<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\EstateObject;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function results(Request $request)
    {
            $city = $request->query('city');
            $guests = $request->query('guests');
            $from = $request->query('from'); 
            $to = $request->query('to'); 

            $query = EstateObject::query();

            if ($city) {
                $query->where('city', 'like', "%$city%");
            }

            if ($guests) {
                $query->where('guests_count', '>=', $guests);
            }

            if ($from && $to) {
                $query->whereDoesntHave('bookings', function ($q) use ($from, $to) {
                    $q->where(function ($q) use ($from, $to) {
                        $q->whereBetween('from_date', [$from, $to])
                        ->orWhereBetween('to_date', [$from, $to])
                        ->orWhere(function ($q) use ($from, $to) {
                            $q->where('from_date', '<=', $from)
                                ->where('to_date', '>=', $to);
                        });
                    });
                });
            }

            $objects = $query->get();

        return Inertia::render('SearchResults', [
            'title' => 'Результаты поиска',
            'estateObjects' => $objects,
        ]);
    }
}
