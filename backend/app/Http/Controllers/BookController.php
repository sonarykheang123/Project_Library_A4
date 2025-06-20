<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class BookController extends Controller
{
    public function index(){
        $books = new Books;
        return response()->json([
            "message"=> "Here is the list of all books",
            "data"=> $books::all(),
        ], 200);
    }

    public function get(int $id) {
        $book = Books::find($id);

        if ($book) {
            return response()->json([
                'data' => $book,
            ], 200);
        }
        return response() ->json([
            'message' => 'Post not found',
        ], 200);
    }

    public function add(Request $request) {
        $book = Books::create([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'publication_year' => $request->publicationYear, 
            'number_of_copies' => $request->availableCopies, 
            'categories' => $request->genre,
            ]);
        if($book) {
            return response()->json([
                "message"=> "Create book successfully",
                "data"=> $book,
            ], 200);
        }
        return response()->json([
            "message" => "Failed to create post",
        ], 203);
    }

    public function update(Request $request, int $id) {
        $book = Books::where('id', $id)
                ->update([
                    'title' => $request->title,
                    'isbn' => $request->isbn,
                    'publication_year' => $request->publicationYear, 
                    'number_of_copies' => $request->availableCopies, 
                    'categories' => $request->genre,
                ]);
        if ($book) {
            $book = Books::find($id);
            return response()->json([
                'message' => "Post updated successfully",
                'data' => $book,
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to update post',
        ], 203);
    }

    public function delete(int $id) {
        $book = Books::where('id', $id)->delete();
        if($book){
            return response()->json([
                'message' => "Post deleted successfully",
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Failed to delete post',
            ], 203);
        };
    } 
}
