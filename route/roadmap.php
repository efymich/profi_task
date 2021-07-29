<?php

use core\Router\Route;

Route::Get("/{shortUrl}", app\Controllers\BasicController::class, 'giveShortUrl');

Route::Put("/addUrl", app\Controllers\BasicController::class, 'addUrl');

