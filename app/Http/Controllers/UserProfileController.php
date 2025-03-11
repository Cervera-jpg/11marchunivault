<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'about' => 'nullable|string'
        ]);

        auth()->user()->update($request->only(['name', 'email', 'phone', 'location', 'about']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    public function uploadAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                
                // Check if file is valid
                if (!$avatar->isValid()) {
                    \Log::error('Invalid file upload attempt');
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid file upload'
                    ], 400);
                }

                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $directory = 'public/avatars';
                if (!Storage::exists($directory)) {
                    Storage::makeDirectory($directory);
                }
                
                try {
                    // Store the file
                    $path = $avatar->storeAs($directory, $filename);
                    
                    if (!$path) {
                        \Log::error('Failed to store file');
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to store file'
                        ], 500);
                    }

                    // Get the URL
                    $url = Storage::url($path);
                    
                    // Update user's avatar in database
                    $user = auth()->user();
                    $user->avatar = $url;
                    $user->save();

                    return response()->json([
                        'success' => true,
                        'path' => $url,
                        'message' => 'Profile picture updated successfully'
                    ]);
                } catch (\Exception $e) {
                    \Log::error('File storage error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to save file: ' . $e->getMessage()
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);
            
        } catch (\Exception $e) {
            \Log::error('Avatar upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading file: ' . $e->getMessage()
            ], 500);
        }
    }
}
