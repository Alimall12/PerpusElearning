<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FirebaseAuthController extends Controller
{
    public function callback(Request $request)
    {
        $idToken = $request->input('idToken');
        
        if (!$idToken) {
            return response()->json(['success' => false, 'error' => 'Token tidak ditemukan'], 400);
        }
        
        try {
            $auth = Firebase::auth();
            $verifiedIdToken = $auth->verifyIdToken($idToken);
            
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name');
            
            // Cari user berdasarkan email atau firebase_uid
            $user = User::where('email', $email)
                        ->orWhere('firebase_uid', $uid)
                        ->first();
            
            if (!$user) {
                // Bikin user baru
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt(Str::random(32)),
                ]);
                $user->forceFill(['role' => 'user', 'firebase_uid' => $uid])->save();
            } else {
                // Update firebase_uid kalau belum ada
                if (!$user->firebase_uid) {
                    $user->forceFill(['firebase_uid' => $uid])->save();
                }
            }
            
            // Login ke Laravel session
            Auth::login($user);
            
            return response()->json(['success' => true, 'redirect' => route('dashboard')]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 401);
        }
    }
}
