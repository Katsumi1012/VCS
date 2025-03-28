<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChallengeController extends Controller
{
    public function teacher(){
        $challenge = DB::table('challenge')->get();
        return view('backend.challenge.teacher', compact('challenge'));
    }
    
    public function student(){
        // Get only the necessary challenge information for students
        // Remove the filename column to avoid revealing the answer
        $challenge = DB::table('challenge')
            ->select('cid', 'hint', 'created_at')
            ->get();
        
        return view('backend.challenge.student', compact('challenge'));
    }
    
    public function form(){
        return view('backend.challenge.create');
    }
    
    public function create(Request $request){
        // Validate the request
        $request->validate([
            'challengefile' => 'required|file|mimes:txt,text', // Enforce text files only
            'hint' => 'required|string', // Make hint required
        ]);

        if($request->hasFile('challengefile')){
            // Get the original filename
            $originalName = $request->challengefile->getClientOriginalName();
            
            // Remove file extension to get the answer
            $answer = pathinfo($originalName, PATHINFO_FILENAME);
            
            // Check if filename follows the required format (no accents, words separated by spaces)
            if (preg_match('/^[a-zA-Z0-9\s]+$/', $answer)) {
                // Store the file
                $filename = $request->challengefile->getClientOriginalName();
                
                // Store in database
                DB::table('challenge')->insert([
                    'hint' => $request->hint,
                    'filename' => $filename,
                    'answer' => $answer, // Store the answer (filename without extension)
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Move the file
                $request->challengefile->move(public_path('challenge'), $filename);
                
                return redirect()->route('challenge.teacher')
                    ->with('success', 'Challenge created successfully. The answer is: ' . $answer);
            } else {
                // Filename doesn't meet format requirements
                return redirect()->back()
                    ->with('error', 'File name must contain only letters, numbers, and spaces (no accents)')
                    ->withInput();
            }
        }
        
        return redirect()->back()
            ->with('error', 'Failed to upload challenge file')
            ->withInput();
    }
    
    public function download($filename){
        $path = public_path('challenge/'.$filename);
        if(file_exists($path)){
            return response()->download($path);
        }
        return "File không tồn tại";
    }
    
    public function detail($cid){
        $chall = DB::table('challenge')->where('cid', '=', $cid)->first();
        return view('backend.challenge.detail', compact('chall'));
    }
    
    public function solve(Request $request){
        $request->validate([
            'answer' => 'required|string',
            'challenge_id' => 'required|exists:challenge,cid'
        ]);
        
        // Get the challenge
        $challenge = DB::table('challenge')
            ->where('cid', '=', $request->challenge_id)
            ->first();
            
        if (!$challenge) {
            return redirect()->back()
                ->with('error', 'Challenge not found');
        }

        // Check if answer is correct (case insensitive)
        if (Str::lower($request->answer) === Str::lower($challenge->answer)) {
            // Get file content
            $file_path = public_path('challenge/' . $challenge->filename);
            
            if (file_exists($file_path)) {
                $content = file_get_contents($file_path);
                $status = "Đáp án chính xác!";
                
                // Log successful attempt
                DB::table('challenge_attempts')->insert([
                    'challenge_id' => $challenge->cid,
                    'user_id' => auth()->id(),
                    'answer' => $request->answer,
                    'is_correct' => true,
                    'created_at' => now()
                ]);
                
                return view('backend.challenge.content', [
                    'status' => $status, 
                    'content' => $content,
                    'challenge' => $challenge
                ]);
            } else {
                return redirect()->back()
                    ->with('error', 'Challenge file not found');
            }
        } else {
            // Log failed attempt
            DB::table('challenge_attempts')->insert([
                'challenge_id' => $challenge->cid,
                'user_id' => auth()->id(),
                'answer' => $request->answer,
                'is_correct' => false,
                'created_at' => now()
            ]);
            
            return redirect()->back()
                ->with('error', 'Đáp án sai! Hãy thử lại');
        }
    }
}
