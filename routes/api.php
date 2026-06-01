<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonorController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Site\PaymentController;
use App\Http\Controllers\Site\ProfileCardsController;
use App\Http\Controllers\Api\CharityProjectController;
use App\Http\Controllers\Api\CategoryProjectController;
use App\Http\Controllers\Api\Test\NotficationTestController;
use App\Http\Controllers\Api\Badal\Donors\Review\ReviewController;
use App\Http\Controllers\Api\Badal\Subsitue\Offer\OfferController;
use App\Http\Controllers\Api\Badal\Projects\RitualController;
use App\Http\Controllers\Api\Badal\Projects\CharityBadalProjectController;
use App\Http\Controllers\Api\Badal\RequestController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'as' => 'api.'
], function () {
    // payment apis
    Route::any('payfort-intital', [PaymentController::class, 'authorizateResponse'])->name('payfort-intital');
    Route::any('payfort-purchase', [PaymentController::class, 'purchaseResponse'])->name('payfort-purchase');


    Route::any('payfort-respond-card', [ProfileCardsController::class, 'payfortrespondSaveCard'])->name('profile.cards.payfortrespondSaveCard'); // save card [update status 1]

    // Test Notfication
    Route::POST('notfication-whatsapp', [NotficationTestController::class, 'whatsapp']);
    Route::POST('notfication-sms', [NotficationTestController::class, 'sms']);
    Route::POST('notfication-email', [NotficationTestController::class, 'email']);



    // Api Application kafara --------------------------------------------
    Route::prefix('donors')->group(function () {
        Route::controller(DonorController::class)->group(function () {
            Route::POST('login', 'login')->name('login');
            Route::post('register', 'register');
            Route::post('validateOTP', 'validateOtp');
            Route::post('donations', 'getDonations');
        });
    });

    Route::prefix('projects')->group(function () {
        Route::controller(CategoryProjectController::class)->group(function () {
            Route::post('categories', 'index');
        });
        
        Route::controller(CharityProjectController::class)->group(function () {
            Route::post('list', 'showByCategoryId');
            Route::post('view', 'show');
        });

        Route::controller(CharityBadalProjectController::class)->group(function () {  // not reviewd
            Route::post('albadal', 'index');
            Route::post('checkbadal', 'getbadalProjects');
            Route::post('selectedProjects', 'getSelectedProjectsBadal');
            Route::post('umrah', 'getUmrahProject');
            Route::post('hajj', 'getHajjProject');
        });
    });

    Route::prefix('articles')->group(function () {
        Route::controller(ArticleController::class)->group(function () {
            Route::post('view', 'show');
            Route::post('list', 'index');

        });
    });

    Route::prefix('sections')->group(function () {
        Route::controller(SectionController::class)->group(function () {
            Route::post('view', 'show');
            Route::post('list', 'index');
        });
    });

    Route::prefix('payment')->group(function () {
        Route::controller(PaymentMethodController::class)->group(function () {
            Route::post('methods', 'index');
            Route::post('bankAccounts', 'getBankAccounts');
            Route::post('tokenRequest', 'tokenRequest');
        });
    });


    Route::prefix('rituals')->group(function () {
        Route::controller(RitualController::class)->group(function () {
            Route::post('list', 'index');
            Route::post('orders', 'ritualsOrder');
            Route::post('update', 'updateRituals');
            Route::post('uploadVideo', 'uploadVideoRituals');
        });
    });

    
    Route::prefix('orders')->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::post('cart', 'checkout');
            Route::post('pending', 'pending');
            Route::post('start', 'start');
            Route::post('completed', 'completeOrder');
            Route::post('donor', 'getOrderDonor');
            Route::post('substitute', 'getOrderSubstitute');
            Route::post('form', 'badalFormInfo');
        });
    });

    Route::prefix('requests')->group(function () {
        Route::controller(RequestController::class)->group(function () {
            Route::post('list', 'list');
            Route::post('myRequests', 'myRequests');
            Route::post('add', 'create');
            Route::post('select', 'select');
            Route::post('cancel', 'cancel');
            Route::post('cancelOrderRequest', 'cancelOrderRequest');
        });
    });


    
    Route::prefix('offers')->group(function () {
        Route::controller(OfferController::class)->group(function () {
            Route::post('add', 'store');
            Route::post('substitute', 'substituteOffers');
            Route::post('cancel', 'destroy');
            Route::post('list', 'index');
        });
    });

    Route::prefix('reviews')->group(function () {
        Route::controller(ReviewController::class)->group(function () {
            Route::post('list', 'list');
            Route::post('add', 'store');
        });
    });

    Route::prefix('settings')->group(function () {
        Route::controller(SettingController::class)->group(function () {
            Route::post('appintro', 'appintro');
        });
    });

    // End Api Application kafara --------------------------------------------





  


 


});
