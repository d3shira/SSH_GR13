<?php

namespace App\Http\Controllers;

use App\Models\Careers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Properties;

class StaffDashboardController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sales-report",
     *     summary="Get sales report for the current week",
     *      tags={"Reports"},
     *     @OA\Response(response="200", description="Sales data retrieved successfully"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/property-status",
     *     summary="Get count of properties for rent and for sale",
     *     tags={"Reports"},
     *     @OA\Response(response="200", description="Property status data retrieved successfully"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/job-applications-report",
     *     summary="Get job applications report for the current week",
     *     tags={"Reports"},
     *     @OA\Response(response="200", description="Job applications data retrieved successfully"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
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
