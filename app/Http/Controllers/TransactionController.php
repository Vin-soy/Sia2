<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\House;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function myApplications()
    {
        $applications = Transaction::with(['rental' => function($query) {
            $query->with('images');
        }])
        ->where('tenant_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('tenant.layouts.account', compact('applications'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'house_id' => 'required',
                'tenant_id' => 'required',
                'status' => 'required|string'
            ]);

            // Get the rental price
            $house = House::findOrFail($validated['house_id']);

            // Set rental period (1 year from today)
            $startDate = Carbon::now();
            $endDate = Carbon::now()->addYear();

            // Create the transaction
            $transaction = Transaction::create([
                'house_id' => $validated['house_id'],
                'tenant_id' => $validated['tenant_id'],
                'status' => $validated['status'],
                'rental_period_start' => $startDate,
                'rental_period_end' => $endDate,
                'total_amount' => $house->price
            ]);

            // Redirect back to the listings page with success message
            return redirect()->route('tenant.history')
                ->with('success', 'Your rental application has been submitted successfully! You can view its status in your account.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Transaction creation error: ' . $e->getMessage());
            
            // If something goes wrong, redirect back with error
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Check if the transaction belongs to the current user
        if ($transaction->tenant_id !== auth()->id()) {
            return redirect()->back()
                ->with('error', 'You are not authorized to cancel this application.');
        }

        // Check if the transaction is still pending
        if ($transaction->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Only pending applications can be cancelled.');
        }

        $transaction->delete();

        return redirect()->back()
            ->with('success', 'Your application has been cancelled successfully.');
    }

    public function landlordApplications()
    {
        $applications = Transaction::whereHas('rental', function($query) {
            $query->where('landlord_id', auth()->id());
        })->with(['tenant', 'rental.images'])->latest()->get();

        $pendingApplications = Transaction::whereHas('rental', function($query) {
            $query->where('landlord_id', auth()->id());
        })->where('status', 'pending')->count();

        return view('landlord.layouts.notifications', [
            'applications' => $applications,
            'pendingApplications' => $pendingApplications
        ]);
    }

    public function approveApplication($id)
    {
        try {
            $application = Transaction::with('rental')->findOrFail($id);
            
            // Check if the rental belongs to the authenticated landlord
            if ($application->rental->landlord_id !== auth()->id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            // Update application status
            $application->status = 'approved';
            $application->save();

            // Update rental status to rented
            $application->rental->status = 'rented';
            $application->rental->save();

            // Cancel all other pending applications for this rental
            Transaction::where('house_id', $application->house_id)
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update(['status' => 'cancelled']);

            return back()->with('success', 'Application approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve application. ' . $e->getMessage());
        }
    }

    public function rejectApplication($id)
    {
        try {
            $application = Transaction::with('rental')->findOrFail($id);
            
            // Check if the rental belongs to the authenticated landlord
            if ($application->rental->landlord_id !== auth()->id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            $application->status = 'cancelled';
            $application->save();

            return back()->with('success', 'Application cancelled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel application. ' . $e->getMessage());
        }
    }
} 