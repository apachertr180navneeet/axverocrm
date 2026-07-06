<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Models\GlobalSetting;
use Laravel\Fortify\Features;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Actions\Fortify\AttemptToAuthenticate;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\RedirectIfTwoFactorConfirmed;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;

class FortifyServiceProvider extends ServiceProvider
{
    use AppBoot;

    public function register()
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                session()->flush();
                return redirect()->route('login');
            }
        });
    }

    public function boot()
    {
        if (request()->has('locale')) {
            App::setLocale(request()->locale);
        }

        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorConfirmed::class : null,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {

            $request->validate([
                'email' => 'required|email:rfc,strict'
            ]);

            $user = User::withoutGlobalScope(ActiveScope::class)
                ->where('email', $request->email)
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {

                if ($user->status === 'deactive') {
                    throw ValidationException::withMessages([
                        'email' => __('auth.failedBlocked')
                    ]);
                }

                if ($user->login === 'disable') {
                    throw ValidationException::withMessages([
                        'email' => __('auth.failedLoginDisabled')
                    ]);
                }

                session()->forget('locale');
                session()->put([
                    'current_latitude' => $request->current_latitude,
                    'current_longitude' => $request->current_longitude,
                ]);

                return $user;
            }
        });

        // 🔥 Cached Global Setting Helper
        $getGlobalSetting = function () {
            return Cache::remember('global_setting', 3600, function () {
                return GlobalSetting::first();
            });
        };

        // 🔥 Cached Company
        $getCompany = function () {
            return Cache::remember('company', 3600, function () {
                return Company::withCount('users')->first();
            });
        };

        Fortify::requestPasswordResetLinkView(function () use ($getGlobalSetting) {

            $globalSetting = $getGlobalSetting();

            App::setLocale($globalSetting->locale);
            Carbon::setLocale($globalSetting->locale);

            return view('auth.passwords.forget', compact('globalSetting'));
        });

        Fortify::loginView(function () use ($getGlobalSetting, $getCompany) {

            // Prevent unnecessary checks in console
            if (!app()->runningInConsole()) {
                $this->showInstall();
                $this->checkMigrateStatus();
            }

            $globalSetting = $getGlobalSetting();
            $company = $getCompany();

            App::setLocale($globalSetting->locale);
            Carbon::setLocale($globalSetting->locale);

            $userTotal = $company?->users_count;

            if ($userTotal == 0) {
                return view('auth.account_setup', [
                    'global' => $globalSetting,
                    'setting' => $globalSetting
                ]);
            }

            $socialAuthSettings = Cache::remember('social_auth', 3600, function () {
                return social_auth_setting();
            });

            $languages = Cache::remember('languages', 3600, function () {
                return language_setting();
            });

            return view('auth.login', [
                'globalSetting' => $globalSetting,
                'socialAuthSettings' => $socialAuthSettings,
                'company' => $company,
                'languages' => $languages,
            ]);
        });

        Fortify::resetPasswordView(function ($request) use ($getGlobalSetting) {

            $globalSetting = $getGlobalSetting();

            App::setLocale($globalSetting->locale);
            Carbon::setLocale($globalSetting->locale);

            return view('auth.passwords.reset-password', compact('request', 'globalSetting'));
        });

        Fortify::confirmPasswordView(function ($request) use ($getGlobalSetting) {

            $globalSetting = $getGlobalSetting();

            App::setLocale($globalSetting->locale);
            Carbon::setLocale($globalSetting->locale);

            return view('auth.password-confirm', compact('request', 'globalSetting'));
        });

        Fortify::twoFactorChallengeView(function () use ($getGlobalSetting) {

            $globalSetting = $getGlobalSetting();

            App::setLocale($globalSetting->locale);
            Carbon::setLocale($globalSetting->locale);

            return view('auth.two-factor-challenge', compact('globalSetting'));
        });

        Fortify::registerView(function () use ($getGlobalSetting, $getCompany) {

            $company = $getCompany();
            $globalSetting = $getGlobalSetting();

            if (!$company->allow_client_signup) {
                return redirect(route('login'));
            }

            App::setLocale($globalSetting->locale);
            Carbon::setLocale($globalSetting->locale);

            return view('auth.register', compact('globalSetting'));
        });
    }

    public function checkMigrateStatus()
    {
        return check_migrate_status();
    }
}