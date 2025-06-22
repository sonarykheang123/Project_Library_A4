<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;

class MemberController extends Controller
{
    public function index(){
        $members = new Members();
        return response()->json([
            "message"=> "Here is the list of all member",
            "data"=> $members::all(),
        ], 200);
    }

    public function get(int $id) {
        $member = Members::find($id);

        if ($member) {
            return response()->json([
                'data' => $member,
            ], 200);
        }
        return response() ->json([
            'message' => 'Member not found',
        ], 200);
    }

    public function add(Request $request) {
        $member = Members::create([
            'name' => $request->name, 
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        if($member) {
            return response()->json([
                "message"=> "Create member successfully",
                "data"=> $member,
            ], 200);
        }
        return response()->json([
            "message" => "Failed to create member",
        ], 203);
    }

    public function update(Request $request, int $id) {
        $member = Members::where('id', $id)
                ->update([
                    'name' => $request->name, 
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
        if ($member) {
            $member = Members::find($id);
            return response()->json([
                'message' => "Member updated successfully",
                'data' => $member,
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to update member',
        ], 203);
    }

    public function delete(int $id) {
        $member = Members::where('id', $id)->delete();
        if($member){
            return response()->json([
                'message' => "Member deleted successfully",
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Failed to delete member',
            ], 203);
        };
    }
}
