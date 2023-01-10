<?php

Route::prefix('upasthiti')->group(function () {
    Route::post('verify/security-key', 'Api\Upasthiti\VerificationController@verifySecutityKey');
    Route::prefix('logs')->group(function () {
        Route::prefix('organization')->group(function () {
            Route::post('create', 'Api\LogController@createOrganizationLog');
        });
    });
});
