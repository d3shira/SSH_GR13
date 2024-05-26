<?php

namespace App\Http\Controllers;

use App\Models\Careers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Properties;

class StaffDashboardController extends Controller
{
    public function getSalesReport()
    {
        // Get the start and end dates of the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        // Query properties sold within the current week
        $salesData = Properties::where('status', 'sold')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get()
            ->groupBy(function($property) {
                return $property->created_at->format('l'); // Group by day name
            })
            ->map->count();

        return response()->json($salesData);
    }


    public function getPropertyStatus()
    {
        $forRentCount = Properties::where('for_rent', true)->count();
        $forSaleCount = Properties::where('for_sale', true)
            ->where('status', 'available')
            ->count();


        return response()->json([
            'forRentCount' => $forRentCount,
            'forSaleCount' => $forSaleCount
        ]);
    }

    public function getJobApplicationsReport()
    {
        // Get the start and end dates of the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        // Query job applications submitted within the current week
        $jobApplicationsData = Careers::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get()
            ->groupBy(function($application) {
                return $application->created_at->format('l'); // Group by day name
            })
            ->map->count();

        return response()->json($jobApplicationsData);
    }

}
