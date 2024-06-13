<?php

namespace PacificDev\SocialLogin;

use App\Http\Controllers\SocialLogin\SocialController;

Route::get('linkedin/auth', [SocialController::class, 'handleLinkedinAuthentication'])->name('linkedin.auth');
Route::get('linkedin/auth/callback', [SocialController::class, 'handleLinkedinCallback']);
