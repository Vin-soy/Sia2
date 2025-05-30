<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->getRedirectByRole($request->user());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->getRedirectByRole($request->user());
    }

    /**
     * Get the redirect route based on user role.
     */
    private function getRedirectByRole($user): RedirectResponse
    {
        $roleName = $user->roles->pluck('role_name')->first();
        $verified = '?verified=1';

        switch ($roleName) {
            case 'tenant':
                return redirect()->route('tenant.home', absolute: false)->with('verified', 1);
            case 'landlord':
                return redirect()->route('landlord.home', absolute: false)->with('verified', 1);
            case 'admin':
                return redirect()->route('admin.home', absolute: false)->with('verified', 1);
            default:
                return redirect()->route('home', absolute: false)->with('verified', 1);
        }
    }
}
