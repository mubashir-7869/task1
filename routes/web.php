<?php
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemRevenueController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Subscription\ProdutController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/search', [ProfileController::class, 'search'])->name('search');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });
    // Item
    Route::resource('item', ItemController::class);
    Route::prefix('item')->name('item.')->group(function () {
        Route::get('/search', [ItemController::class, 'show'])->name('show');
        Route::get('/search/model', [ItemController::class, 'searchModel'])->name('search_model');
        Route::get('/top/items', [ItemController::class, 'topItems'])->name('top.items');
        Route::get('/destroy/{id}', [ItemController::class, 'destroy'])->name('destroy');
        Route::post('/restore/{id}', [ItemController::class, 'restore'])->name('restore');
        Route::delete('/forceDelete/{id}', [ItemController::class, 'forceDelete'])->name('forceDelete');
    });

    // Models
    Route::resource('models', ModelController::class);
    Route::prefix('models')->name('models.')->group(function () {
        Route::get('/show', [ModelController::class, 'show'])->name('show');
        Route::get('/destroy/{id}', [ModelController::class, 'destroy'])->name('destroy');
        Route::post('/restore/{id}', [ModelController::class, 'restore'])->name('restore');
        Route::delete('/forceDelete/{id}', [ModelController::class, 'forceDelete'])->name('forceDelete');
    });

    // Brand
    Route::resource('brands', BrandController::class);
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/show', [BrandController::class, 'show'])->name('show');
        Route::get('/destroy/{id}', [BrandController::class, 'destroy'])->name('destroy');
        Route::post('/restore/{id}', [BrandController::class, 'restore'])->name('restore');
        Route::delete('/forceDelete/{id}', [BrandController::class, 'forceDelete'])->name('forceDelete');
    });

    Route::resource('email', EmailController::class);
    // Route::resource('sms', SMSController::class);

    Route::middleware(['can:edit user'])->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::prefix('permission')->name('permission.')->group(function () {
            Route::get('/show', [PermissionController::class, 'show'])->name('show');
            Route::get('/destroy/{id}', [PermissionController::class, 'destroy'])->name('destroy');
        });

        Route::resource('roles', RoleController::class);
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/show', [RoleController::class, 'show'])->name('show');
            Route::get('/destroy/{id}', [RoleController::class, 'destroy'])->name('destroy');
        });
        Route::resource('users', UserController::class);
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/show', [UserController::class, 'show'])->name('show');
            Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/restore/{id}', [UserController::class, 'restore'])->name('restore');
            Route::delete('/forceDelete/{id}', [UserController::class, 'forceDelete'])->name('forceDelete');
        });
    });
    Route::resource('services', ServiceController::class);
    Route::prefix('service')->name('service.')->group(function () {
        Route::get('/show', [ServiceController::class, 'show'])->name('show');
        Route::get('/destroy/{id}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::get('/purchase/{id}', [ServiceController::class, 'purchase'])->name('purchase');
        Route::post('/handlePayment', [ServiceController::class, 'handlePayment'])->name('handlePayment');
    });

    Route::resource('items-revenue', ItemRevenueController::class);
    Route::prefix('item-report')->name('item-revenue.')->group(function () {
        Route::get('/show', [ItemRevenueController::class, 'show'])->name('show');
    });
    Route::resource('audit/logs', AuditLogController::class);

    Route::middleware(['can:edit user'])->group(function () {
        Route::resource('support/messages', SupportController::class);
        Route::prefix('support/message')->name('support.messages.')->group(function () {
            Route::get('/show', [SupportController::class, 'show'])->name('show');
            Route::get('/history/{id}', [SupportController::class, 'history'])->name('history');

        });
    });

    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe.index');
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe.store');
    Route::post('/store', [SubscriptionController::class, 'store'])->name('stripe_products.store');
    Route::get('/subscribe/show', [SubscriptionController::class, 'show'])->name('subscribe.plan.show');
    Route::get('/cancel', [SubscriptionController::class, 'cancel'])->name('subscribe.cancel');
    Route::post('/resume', [SubscriptionController::class, 'resume'])->name('subscribe.update');

    Route::middleware(['can:edit user'])->group(function () {
        Route::resource('stripe/product', ProdutController::class);
        Route::prefix('stripe/products')->name('products.')->group(function () {
            Route::get('/show', [ProdutController::class, 'show'])->name('show');
            Route::get('/destroy/{id}', [ProdutController::class, 'destroy'])->name('destroy');
            Route::get('/restore/{id}', [ProdutController::class, 'restore'])->name('restore');
        });
    });
});

require __DIR__ . '/auth.php';
