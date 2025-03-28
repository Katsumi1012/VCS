<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\message as Message;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $data = [];
        
        // Get recent messages and properly format dates
        $messages = DB::table('message')
                    ->where('receiver_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
        
        // Map through messages to ensure dates are Carbon objects
        $data['recent_messages'] = $messages->map(function($message) {
            // Convert string dates to Carbon instances
            if (is_string($message->created_at)) {
                $message->created_at = \Carbon\Carbon::parse($message->created_at);
            }
            if (is_string($message->updated_at)) {
                $message->updated_at = \Carbon\Carbon::parse($message->updated_at);
            }
            return $message;
        });
        
        // If user is a student
        if ($user->hasRole('Student') && $user->student) {
            $submissions = DB::table('bailam')
                           ->where('student_id', $user->id)
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
            
            // Ensure dates are Carbon objects and add default status
            $data['recent_submissions'] = $submissions->map(function($submission) {
                if (is_string($submission->created_at)) {
                    $submission->created_at = \Carbon\Carbon::parse($submission->created_at);
                }
                
                // Add status property if it doesn't exist
                if (!property_exists($submission, 'status')) {
                    $submission->status = 'pending'; // Default status
                }
                
                return $submission;
            });
        }
        
        // If user is a teacher
        if ($user->hasRole('Teacher')) {
            $homework = DB::table('baitap')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
            
            // Ensure dates are Carbon objects
            $data['recent_homework'] = $homework->map(function($hw) {
                if (is_string($hw->created_at)) {
                    $hw->created_at = \Carbon\Carbon::parse($hw->created_at);
                }
                return $hw;
            });
        }
        
        return view('profile.index', $data);
    }
    
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }
    
    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update role-specific information
        if ($user->hasRole('Student') && $user->student) {
            $user->student->phone = $request->phone;
            $user->student->save();
        } elseif ($user->hasRole('Teacher') && $user->teacher) {
            $user->teacher->phone = $request->phone;
            $user->teacher->subject = $request->subject;
            $user->teacher->save();
        }
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Delete old profile picture if it's not the default
            if ($user->profile_picture !== 'avatar.png') {
                $oldImagePath = public_path('images/profile/') . $user->profile_picture;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                } // nó được lưu ở đường dẫn public/profiles
            }
            
            // Lưu ảnh vào thư mục images/profile thay vì public/profiles
            $request->profile_picture->move(public_path('images/profile'), $filename);
            $user->profile_picture = $filename;
        }
        
        $user->save();
        
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }
    
    /**
     * Show the change password form.
     *
     * @return \Illuminate\View\View
     */
    public function changePassword()
    {
        return view('profile.change-password');
    }
    
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('profile.index')->with('success', 'Password changed successfully');
    }
}
