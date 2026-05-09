<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index(){
        $posts = Post::get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]); 

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'content' => 'required|string|max:255',
            'image_url' => 'nullable'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ],400);
        }

        //jika validasi berhasil, lanjut

        $post = Post::create([
            'user_id' => $request->user_id,
            'content' => $request->content,
            'image_url' => $request->image_url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil membuat post baru',
            'data' => $post
        ],201);
    }
}
