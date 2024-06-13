<?php

namespace App\Http\Controllers\SocialLogin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class SocialController extends Controller
{


  public function handleLinkedinAuthentication()
  {

    // New OpenID implementation
    //dd(Socialite::driver('linkedin-openid')->scopes(['openid', 'profile', 'email', 'w_member_social']));

    return Socialite::driver('linkedin-openid')->scopes(['openid', 'profile', 'email', 'w_member_social'])->redirect();
  }

  public function handleLinkedinCallback()
  {
    // $user contains the linkedin user dedails
    // id, nickname, name, email, avatar, token and more..
    $user = Socialite::driver('linkedin-openid')->user();
    //$token = $user->token;
    //$userUrn = $user->id;
    ## TODO: Add the user profile picture?
    $avatar = $user->getAvatar();

    //dd($user, $token, $userUrn, $avatar, $user->name, $user->email);

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
