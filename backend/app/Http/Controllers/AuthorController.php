<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    // Get all authors
    public function index() {
        $authors = Author::all();

        return response()->json([
            'message' => 'Authors retrieved successfully!',
            'data' => $authors
        ], 200);
    }

    // Get a single author by ID
    public function show(int $id) {
        $author = Author::find($id);

        if ($author) {
            return response()->json([
                'message' => 'Author found!',
                'data' => $author
            ], 200);
        }

        return response()->json([
            'message' => 'Author not found!'
        ], 404);
    }

    // Count all authors
    public function count() {
        $count = Author::count();

        return response()->json([
            'message' => 'Author count retrieved successfully!',
            'data' => $count
        ], 200);
    }

    // Create a new author
    public function create(Request $request) {
        // Just check if name is given, no formal validation
        if (!$request->name) {
            return response()->json([
                "message" => "Name field is required"
            ], 400);
        }

        $author = Author::create([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'number_of_books_written' => $request->number_of_books_written ?? 0,
            'nationality' => $request->nationality,
        ]);

        if ($author) {
            return response()->json([
                "message" => "Author created successfully",
                "data" => $author
            ], 201);
        }

        return response()->json([
            "message" => "Failed to create author"
        ], 400);
    }

    // Edit (update) an author
    public function edit(Request $request, int $id) {
        if (!$request->name) {
            return response()->json([
                "message" => "Name field is required"
            ], 400);
        }

        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                "message" => "Author not found"
            ], 404);
        }

        $updated = $author->update([
            'name' => $request->name,
        ]);

        if ($updated) {
            return response()->json([
                "message" => "Author updated successfully",
                "data" => $author
            ], 200);
        }

        return response()->json([
            "message" => "Failed to update author"
        ], 400);
    }

    // Delete an author
    public function delete(int $id) {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Author not found!'
            ], 404);
        }

        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully!',
            'id' => $id
        ], 200);
    }
}
