<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WasherController;
use App\Http\Controllers\WashQueueController;
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


Route::group(['middleware' => ['auth']], function () {

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
        Route::get('/washer/single', 'singleWasher')->name('washer.single');
        Route::post('/washer/{washer}/commission', 'updateCommission')->name('washer.update_commission');
        Route::post('/washer/{washer}/name', 'updateName')->name('washer.update_name');
        Route::post('/washer/{washer}/toggle-active', 'toggleActive')->name('washer.toggle_active');
    });

    Route::controller(PaymentController::class)->group(function () {
        route::get('/payments', 'index')->name('payment_dashboard');
        route::get('/payments/history', 'paymentHistory')->name('payment.history');
        route::post('/queue/{queue}/payment', 'payment')->name('queue.payment');
        route::post('/payment/{payment}/update', 'updatePayment')->name('queue.payment.update');
    });

    Route::get('/dashboard2', function () {
        return view('pages.boxes_dashboard2');
    });


});

