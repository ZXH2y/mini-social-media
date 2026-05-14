<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LikesController extends Controller
{
    public function store(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();

        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Like',
            'data' => $like
        ],201);
    }
    public function destroy(int $id)
    {
        Like::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus like ajg'
        ]);
    }
}
