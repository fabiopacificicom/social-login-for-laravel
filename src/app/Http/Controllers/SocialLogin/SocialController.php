<?php

namespace App\Http\Controllers\SocialLogin;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Social;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{


  public function handleLinkedinAuthentication()
  {
    // New OpenID implementation
    //dd(Socialite::driver('linkedin-openid')->scopes(['openid', 'profile', 'email', 'w_member_social']));


    //dd(Socialite::driver('linkedin-openid')->scopes(['w_member_social']));

    return Socialite::driver('linkedin-openid')->scopes(['openid', 'profile', 'email', 'w_member_social'])->redirect();
  }

  public function handleLinkedinCallback()
  {
    // $user contains the linkedin user dedails
    // id, nickname, name, email, avatar, token and more..
    $user = Socialite::driver('linkedin-openid')->user();
    $token = $user->token;
    $userUrn = $user->id;
    dd($user, $token, $userUrn);

    $foundUser = User::where('email', $user->email)->first();
    if ($foundUser) {
      // log in the user
      auth()->login($foundUser);
    } else {
      // register a new user
      $newUser = User::create([
        'name' => $user->name,
        'email' => $user->email,
        'password' => Hash::make(Str::random(16))
      ]);

      auth()->login($newUser);
    }

    return redirect()->intended()->with('message', 'Linkedin Access Successfull');
  }
}
