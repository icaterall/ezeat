<?php
namespace App\Services;

use App\Models\SocialFacebookAccount;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Str;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {

        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->id)
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->id,
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->user['email'])->first();

            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->user['name'],
                    'mobile' => rand(1000, 9999),
                    'password' => md5(rand(1,10000)),
                    'api_token' => Str::random(60),
                ]);
            }


            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}