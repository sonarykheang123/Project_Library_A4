<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get("/{id}", [BookController::class, "show"]);
    Route::post("/store", [BookController::class, "store"]);
    Route::put("/update/{id}", [BookController::class, "update"]);
    Route::delete("destroy/{id}", [BookController::class, "destroy"]);
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
Route::prefix("/users")->group(function(){
    Route::get("/", [UserController::class, "index"])->name("allUsers");
    Route::get("/{id}", [UserController::class, "show"]);
    Route::post("/store", [UserController::class, "store"]);
    Route::put("/update/{id}", [UserController::class, "update"]);
    Route::delete("destroy/{id}", [UserController::class, "destroy"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
