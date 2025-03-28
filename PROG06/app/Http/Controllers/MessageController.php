<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function index($id){
        // Get messages from database
        $sent_messages = DB::table('message')->where('sender_id', $id)->get();
        $received_messages = DB::table('message')->where('receiver_id', $id)->get();
        
        // Process dates to ensure they're properly formatted
        $sent_msg = $sent_messages->map(function($message) {
            // Convert string dates to Carbon instances if they're strings
            if (is_string($message->created_at)) {
                $message->created_at = Carbon::parse($message->created_at);
            }
            if (is_string($message->updated_at)) {
                $message->updated_at = Carbon::parse($message->updated_at);
            }
            return $message;
        });
        
        $received_msg = $received_messages->map(function($message) {
            // Convert string dates to Carbon instances if they're strings
            if (is_string($message->created_at)) {
                $message->created_at = Carbon::parse($message->created_at);
            }
            if (is_string($message->updated_at)) {
                $message->updated_at = Carbon::parse($message->updated_at);
            }
            return $message;
        });
        
        return view('backend.message.index', compact('sent_msg', 'received_msg'));
    }
    
    // Update the send method to work with the form submission
    public function send(Request $request){
        // Validate the request
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'msg' => 'required|string'
        ]);

        // Get receiver ID from the form
        $rid = $request->receiver_id;
        // Get sender ID from currently authenticated user
        $sid = Auth::id();
        
        // Get user records, with error checking
        $receiver = DB::table('users')->where('id', $rid)->first();
        $sender = DB::table('users')->where('id', $sid)->first();
        
        // Check if both users exist
        if (!$receiver || !$sender) {
            return redirect()->back()->with('error', 'User not found. Message could not be sent.');
        }
        
        $msg = DB::table('message')->where('sender_id', $sender->id)
                                  ->where('receiver_id', $receiver->id)
                                  ->first();
        
        $NewMsg = $request->msg;
        
        if ($msg === null) {
            DB::table('message')->insert([
                'sender_id'     => $sender->id,
                'sender_name'   => $sender->name,
                'receiver_id'   => $receiver->id,
                'receiver_name' => $receiver->name,
                'msg'           => $NewMsg,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } else {
            DB::table('message')->where('sender_id', $sender->id)
                                ->where('receiver_id', $receiver->id)
                                ->update([
                                    'msg' => $NewMsg,
                                    'updated_at' => now()
                                ]);
        }
        
        return redirect()->route('home')->with('success', 'Message sent successfully');
    }

    public function sendForm($rid){
        // Validate that the recipient exists
        $receiver = DB::table('users')->where('id', $rid)->first();
        
        if (!$receiver) {
            return redirect()->route('home')->with('error', 'Recipient not found');
        }
        
        return view('backend.message.send', ['rid' => $rid]);
    }
}
