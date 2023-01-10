<?php

Route::prefix('smartkarobar')->group(function () {
    Route::post('verify/security-key', 'Api\SmartKarobar\VerificationController@verifySecutityKey');
    Route::prefix('logs')->group(function () {
        Route::prefix('organization')->group(function () {
            Route::post('create', 'Api\LogController@createOrganizationLog');
        });
    });
});
