<?php

use App\Http\Controllers\CarTypeController;
use App\Http\Controllers\CarwashBoxController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ParkingFeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasherController;
use App\Http\Controllers\WashPriceController;
use App\Http\Controllers\WashQueueController;
use App\Http\Controllers\WashTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->hasAnyRole(['admin', 'manager'])) {
            return redirect(route('queue_dashboard'));
        }

        if ($user->hasAnyRole(['cashier'])) {
            return redirect(route('payment_dashboard'));
        }
    }

    return view('auth.login');
});

Route::group(['middleware' => ['auth', 'tenant_required']], function () {

    Route::controller(WashQueueController::class)->group(function () {
        Route::get('/queue', 'index')->name('queue_dashboard');
        Route::get('/history', 'history')->name('washes_history');
        Route::get('/queue/create', 'create')->name('queue_create');
        Route::post('/queue/store', 'store')->name('queue_store');
        Route::get('/queue/{queue}/edit', 'edit')->name('queue_edit');
        Route::post('/queue/{queue}/update', 'update')->name('queue_update');
        Route::post('/queue/{queue}/delete', 'destroy')->name('queue_delete');
        Route::post('/queue/{queue}/pay', 'markPaid')->name('queue_mark_paid');
        Route::post('/queue/{queue}/mark-washed', 'markWashed')->name('queue_mark_washed');
        Route::post('/queue/{queue}/unmark-washed', 'unmarkWashed')->name('queue_unmark_washed');
    });

    Route::controller(WasherController::class)->group(function () {
        Route::get('/washers', 'index')->name('washer_dashboard');
        Route::post('/washer/store', 'store')->name('washer.store');
        Route::get('/washer/single', 'singleWasher')->name('washer.single');
        Route::post('/washer/{washer}/commission', 'updateCommission')->name('washer.update_commission');
        Route::post('/washer/{washer}/name', 'updateName')->name('washer.update_name');
        Route::post('/washer/{washer}/toggle-active', 'toggleActive')->name('washer.toggle_active');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::get('/payments', 'index')->name('payment_dashboard');
        Route::get('/payments/history', 'paymentHistory')->name('payment.history');
        Route::post('/queue/{queue}/payment', 'payment')->name('queue.payment');
        Route::post('/payment/{payment}/update', 'updatePayment')->name('queue.payment.update');
    });

    Route::controller(ParkingController::class)->group(function () {
        Route::get('/parkings', 'index')->name('parkings.index');
        Route::post('/parkings', 'store')->name('parkings.store');
        Route::post('/parkings/{parking}/update', 'update')->name('parkings.update');
        Route::post('/parkings/{parking}/exit', 'markExit')->name('parkings.exit');
        Route::post('/parkings/{parking}/delete', 'destroy')->name('parkings.destroy');
        Route::post('/parkings/{parking}/payment', 'pay')->name('parkings.payment');
    });

    Route::controller(ParkingFeeController::class)->group(function () {
        Route::post('/parking-fees', 'store')->name('parking-fees.store');
        Route::post('/parking-fees/{parkingFee}/update', 'update')->name('parking-fees.update');
        Route::post('/parking-fees/{parkingFee}/delete', 'destroy')->name('parking-fees.destroy');
    });

    Route::controller(ProductsController::class)->group(function () {
        Route::get('/products', 'index')->name('products.index');
        Route::post('/products', 'store')->name('products.store');
        Route::post('/products/{product}/update', 'update')->name('products.update');
        Route::post('/products/{product}/delete', 'destroy')->name('products.destroy');
        Route::post('/products/{product}/payment', 'pay')->name('products.payment');
    });

    Route::controller(ContractorController::class)->group(function () {
        Route::get('/contractors', 'index')->name('contractors.index');
        Route::post('/contractors', 'store')->name('contractors.store');
        Route::post('/contractors/{contractor}/update', 'update')->name('contractors.update');
        Route::post('/contractors/{contractor}/delete', 'destroy')->name('contractors.destroy');
    });

    Route::controller(CarwashBoxController::class)->group(function () {
        Route::post('/boxes', 'store')->name('box.store');
        Route::post('/boxes/{box}/update', 'update')->name('box.update');
        Route::post('/boxes/{box}/delete', 'destroy')->name('box.destroy');
        Route::post('/boxes/{box}/washer', 'assignWasher')->name('box.washer');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::post('/users', 'store')->name('users.store');
        Route::post('/users/{user}/update', 'update')->name('users.update');
        Route::post('/users/{user}/delete', 'destroy')->name('users.destroy');
    });

    Route::get('/dashboard2', function () {
        return view('pages.boxes_dashboard2');
    });

    Route::group(['middleware' => ['auth']], function () {

        Route::controller(TenantController::class)->group(function () {
            Route::get('/tenants', 'index')->name('tenants');
            Route::post('/tenants', 'store')->name('tenants.store');
            Route::post('/tenants/switch', 'switchTenant')->name('tenants.switch');
            Route::post('/tenants/{tenant}/update', 'update')->name('tenants.update');
            Route::post('/tenants/{tenant}/delete', 'destroy')->name('tenants.destroy');
        });

        Route::controller(CarTypeController::class)->group(function () {
            Route::post('/car-types', 'store')->name('car-types.store');
            Route::post('/car-types/{carType}/update', 'update')->name('car-types.update');
            Route::post('/car-types/{carType}/delete', 'destroy')->name('car-types.destroy');
        });

        Route::controller(WashTypeController::class)->group(function () {
            Route::post('/wash-types', 'store')->name('wash-types.store');
            Route::post('/wash-types/{washType}/update', 'update')->name('wash-types.update');
            Route::post('/wash-types/{washType}/delete', 'destroy')->name('wash-types.destroy');
        });

        Route::controller(WashPriceController::class)->group(function () {
            Route::post('/wash-prices', 'store')->name('wash-prices.store');
            Route::post('/wash-prices/{washPrice}/update', 'update')->name('wash-prices.update');
            Route::post('/wash-prices/{washPrice}/delete', 'destroy')->name('wash-prices.destroy');
        });

    });

});
