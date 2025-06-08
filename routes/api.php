<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', function () {
    /* $user = User::latest('id');
   
    return $user; */
    return (User::latest('id'))->toJson();
});
