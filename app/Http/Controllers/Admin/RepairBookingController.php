<?php
// app/Http/Controllers/Admin/RepairBookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairBooking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RepairBookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = RepairBooking::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.repair-bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_keys(RepairBooking::STATUSES))],
        ]);

        RepairBooking::findOrFail($id)->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated.']);
    }

    public function destroy($id)
    {
        RepairBooking::findOrFail($id)->delete();

        return response()->json(['message' => 'Booking deleted successfully.']);
    }
}