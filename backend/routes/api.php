<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Books 
Route::prefix("/books")->group(function() {
    Route::get("/", [BookController::class, "index"])->name("allBooks");
    Route::get("/{id}", [BookController::class, "get"]);
    Route::post("/add", [BookController::class, "add"]);
    Route::put("/update/{id}", [BookController::class, "update"]);
    Route::delete("delete/{id}", [BookController::class, "delete"]);
});

//Authors
Route::prefix("/authors")->group(function() {
    Route::get("/", [AuthorController::class, "index"])->name("allAuthors");
    Route::get("/{id}", [AuthorController::class, "show"]);
    Route::post("/store", [AuthorController::class, "store"]);
    Route::put("/update/{id}", [AuthorController::class, "update"]);
    Route::delete("/destroy/{id}", [AuthorController::class, "destroy"]);
});

//Members
Route::prefix("/members")->group(function(){
    Route::get("/", [MemberController::class, "index"])->name("allUsers");
    Route::get("/{id}", [MemberController::class, "get"]);
    Route::post("/add", [MemberController::class, "add"]);
    Route::put("/update/{id}", [MemberController::class, "update"]);
    Route::delete("delete/{id}", [MemberController::class, "delete"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
