<?php

namespace App\Services;

use App\SocialGoogleAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialGoogleAccountService
{
  public function createOrGetUser(ProviderUser $providerUser)
  {
    $isEmailExist = User::whereEmail($providerUser->getEmail())->first();
    if (!$isEmailExist) {
      abort(403);
    }

    $account = SocialGoogleAccount::whereProvider('google')
      ->whereProviderUserId($providerUser->getId())
      ->first();
    if ($account) {
      return $account->user;
    } else {
      $account = new SocialGoogleAccount([
        'provider_user_id' => $providerUser->getId(),
        'provider' => 'google'
      ]);
      $user = User::whereEmail($providerUser->getEmail())->first();
      if (!$user) {
        $user = User::create([
          'email' => $providerUser->getEmail(),
          'first_name' => $providerUser->user["given_name"],
          'last_name' => $providerUser->user["family_name"],
          'password' => md5(rand(1, 10000)),
        ]);
        $user->assignRole(['User']);

        $user->sendEmailVerificationNotification();
      }
      $account->user()->associate($user);
      $account->save();
      return $user;
    }
  }
}
