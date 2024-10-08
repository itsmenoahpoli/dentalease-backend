<?php

use Illuminate\Support\Facades\Route;

Route::get('/mail/user-code/preview', function() {
    return new \App\Mail\UserCode(12345);
});
