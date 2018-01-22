<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialAccountService;

class SocialAuthController extends Controller
{
    /**
    * Create a redirect method to twitter api.
   *
   * @return void
   */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Return a callback method from twitter api.
     *
     * @return callback URL from twitter
     */
    public function callback(SocialAccountService $service, $provider)
    {
        $user = $service->createOrGetUser(Socialite::driver($provider));
        auth()->login($user);
        return redirect()->to('/home');
    }
}
