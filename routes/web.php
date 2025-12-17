<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('/admin');
// });

Route::get('/', function () {
    return redirect('/admin/login');
});
