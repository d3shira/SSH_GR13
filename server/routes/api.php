   <?php

    use App\Http\Controllers\AddPropertyController;
    use App\Http\Controllers\HomeController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\PropertyController;
    use App\Http\Controllers\AgentController;
    use App\Http\Controllers\CareersController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\ContactController;
    use App\Http\Controllers\ReviewController; // Add this line
    use App\Http\Controllers\FAQsController;
    use App\Http\Controllers\ClientsController;
    //use App\Http\Controllers\FavoriteController;

    use App\Models\Applications;
    use App\Http\Controllers\StaffDashboardController;


    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::get('/properties', [PropertyController::class, 'getProperties']);
    Route::get('/agents', [AgentController::class, 'getAgents']);
    Route::post('/home/properties/filter', [HomeController::class, 'filter']);
    Route::post('/careers', [CareersController::class, 'store']);
    Route::post('/properties/filter', [PropertyController::class, 'filterProperties']);
    Route::post('/contact', [ContactController::class, 'store']);
    Route::get('/properties/{id}', [PropertyController::class, 'show']);
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/user', [UserController::class, 'getAuthenticatedUser'])->middleware('auth:api');
    Route::get('/careers', [CareersController::class, 'getJobApplications']);
    Route::put('/careers/{id}/approve', [CareersController::class, 'approveApplication']); // Route for approving application
    Route::put('/careers/{id}/reject', [CareersController::class, 'rejectApplication']); // Route for rejecting application
    Route::put('/careers/{id}/undo', [CareersController::class, 'undoApplicationStatus']);
    Route::get('/property_types', [AddPropertyController::class, 'getPropertyTypes']);
    Route::post('/add_properties', [AddPropertyController::class, 'store']);
    Route::post('/registerStaff', [UserController::class, 'registerStaff']);
    Route::put('/editStaff/{id}', [AgentController::class, 'editAgent']);
    Route::delete('/deleteStaff/{id}', [AgentController::class, 'deleteAgent']);
    Route::post('/faqs', [FAQsController::class, 'store']);
    Route::get('/faqs', [FAQsController::class, 'getFaqs']);
    Route::get('/applications', function () { return Applications::all();});
    Route::get('/users', [ClientsController::class, 'index']);
    Route::delete('/users/{id}', [ClientsController::class, 'destroy']);
    Route::put('/users/{id}', [ClientsController::class, 'update']);    
    Route::put('/properties/{id}', [AddPropertyController::class, 'update']);    
    Route::delete('/properties/{id}', [AddPropertyController::class, 'delete']);                              
    Route::put('/users/{id}', [ClientsController::class, 'update']);   
    Route::post('/agentImage',[AgentController::class,'uploadAgentImage']);                                        
    Route::get('/cities', [PropertyController::class, 'getCities']);
    Route::get('/sales-report', [StaffDashboardController::class, 'getSalesReport']);
    Route::get('/property-status', [StaffDashboardController::class, 'getPropertyStatus']);
    Route::get('/job-applications-report', [StaffDashboardController::class, 'getJobApplicationsReport']);
    Route::middleware('auth:api')->post('/logout', [UserController::class, 'logout']);
    // Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::put('/faqs/{id}', [FaqsController::class, 'update']); 
    Route::get('/sales_agents', [AddPropertyController::class, 'getSalesAgents']);
    Route::put('/faqs/{id}', [FaqsController::class, 'update']); 
    Route::post('/registerAdmin',[UserController::class,'registerAdmin']);

                                 


