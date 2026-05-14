<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use Tymon\JWTAuth\Facades\JWTAuth;

class MessagesController extends Controller
{
    public function store(Request $request){

        $user = JWTAuth::parseToken()->authenticate();
        
        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required',
            'message_content' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ],400);
        }

        // jika validasi berhasil
        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content
        ]);

        return response()->json([
            'success' => true,
            'message'=> 'Berhasil mengirim pesan',
            'data' => $message
        ]);
    }

    public function show(int $id)
    {
        $message = Message::find($id);

        return response()->json([
            'success' => true,
            'message'=> 'Berhasil mengambil pesan',
            'data' => $message
        ]);

    }

    public function getMessages(int $user_id)
    {
        $messages = Message::where('receiver_id', $user_id)->get();

        return response()->json([
            'success' => true,
            'message'=> 'Berhasil mengambil pesan berdasarkan user id',
            'data' => $messages
        ]);

    }
    public function destroy(int $id)
    {
        Message::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'message berhasil di hapus'
        ]);
    }

}