<?php
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $findUser = User::where('email', $user->getEmail())->first();
            if ($findUser) {
                Auth::login($findUser);
            } else {
                $newUser = User::updateOrCreate(
                    ['email' => $user->getEmail()],
                    [
                        'name' => $user->getName(),
                        'google_id' => $user->getId(),
                        'password' => bcrypt(Str::random(24))
                    ]
                );
                Auth::login($newUser);
            }
            session(['user' => Auth::user(), 'id' => Auth::user()->id]);

            return redirect(route('home.index'));
        } catch (\Exception $e) {
            return redirect(route('user.register'))->withErrors(['msg' => 'Something went wrong. Please try again.']);
        }
    }

        public function redirectToLinkedin()
        {
            $redirectUrl = Socialite::driver('linkedin')
                ->scopes(['openid','profile','w_member_social','email'])
                ->redirect()
                ->getTargetUrl();

            Log::info('LinkedIn Authorization URL: ' . $redirectUrl);

            return redirect($redirectUrl);
        }
        public function handleLinkedinCallback()
        {
            try {
                Log::info('LinkedIn callback request: ', ['request' => request()->all()]);

                if (!request()->has('code')) {
                    throw new \Exception('Missing "code" parameter in the callback request.');
                }

                $user = Socialite::driver('linkedin')->stateless()->user();
                Log::info('LinkedIn user info: ', ['user' => $user]);

                $findUser = User::where('email', $user->getEmail())->first();

                if ($findUser) {
                    Auth::login($findUser);
                } else {
                    $newUser = User::updateOrCreate(
                        ['email' => $user->getEmail()],
                        [
                            'name' => $user->getName(),
                            'linkedin_id' => $user->getId(),
                            'password' => bcrypt(Str::random(24))
                        ]
                    );
                    Auth::login($newUser);
                }

                session(['user' => Auth::user(), 'id' => Auth::user()->id]);
                return redirect(route('home.index'));
            } catch (\Exception $e) {
                Log::error('LinkedIn Callback Error: ' . $e->getMessage());
                return redirect(route('user.register'))->withErrors(['msg' => 'Something went wrong. Error: ' . $e->getMessage()]);
            }
        }

    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterCallback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
            // dd($user->id);
            $findUser = User::where('twitter_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
            } else {
                $newUser = User::updateOrCreate(
                    ['twitter_id' => $user->id],
                    [
                        'name' => $user->getName() ,
                       'email' => $user->getEmail(),
                        'password' => bcrypt(Str::random(24))
                    ]
                );
                Auth::login($newUser);
            }

            session(['user' => Auth::user(), 'id' => Auth::user()->id]);
            return redirect(route('home.index'));
        } catch (\Exception $e) {
            return redirect(route('user.register'))->withErrors(['msg' => 'Something went wrong. Error: ' . $e->getMessage()]);
        }
    }

}
