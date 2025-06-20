<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index(){
        $authors = new Authors;
        return response()->json([
            "message"=> "Here is the list of all authors",
            "data"=> $authors::all(),
        ], 200);
    }

    public function get(int $id) {
        $author = Authors::find($id);

        if ($author) {
            return response()->json([
                'data' => $author,
            ], 200);
        }
        return response() ->json([
            'message' => 'Author not found',
        ], 200);
    }

    public function add(Request $request) {
        $authors = Authors::create([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'number_of_books_written' => $request->number_of_books_written ?? 0,
            'nationality' => $request->nationality,
            ]);
        if($book) {
            return response()->json([
                "message"=> "Created Author successfully",
                "data"=> $author,
            ], 200);
        }
        return response()->json([
            "message" => "Failed to create author",
        ], 203);
    }

    public function update(Request $request, int $id) {
        $author = Authors::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'date_of_birth' => $request->date_of_birth,
                    'number_of_books_written' => $request->number_of_books_written ?? 0,
                    'nationality' => $request->nationality,
                ]);
        if ($author) {
            $author = Authors::find($id);
            return response()->json([
                'message' => "Author updated successfully",
                'data' => $author,
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to update author',
        ], 203);
    }

    public function delete(int $id) {
        $author = Authors::where('id', $id)->delete();
        if($author){
            return response()->json([
                'message' => "Name deleted successfully",
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Failed to delete author name',
            ], 203);
        };
    } 
}
