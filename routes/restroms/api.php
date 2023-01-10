<?php

Route::prefix('restroms')->group(function () {
    Route::post('verify/security-key', 'Api\RestroMS\VerificationController@verifySecutityKey');
    Route::prefix('logs')->group(function () {
        Route::prefix('organization')->group(function () {
            Route::post('create', 'Api\LogController@createOrganizationLog');
        });
    });
});
