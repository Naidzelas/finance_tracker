<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\AuthKitAccountDeletionRequest;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Profile',[
            'user' => $request->user(),
        ]);
    }

    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile settings.
     */
    public function update(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        // ]);
        User::find($request->user()->id)->update([
            'etoro_name' => $request->etoro_name,
            'income' => $request->income
        ]);
        // $request->user()->update([
        //     'etoro_name' => $request->etoro_name,
        //     'income' => $request->income
        // ]);

        return to_route('index');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(AuthKitAccountDeletionRequest $request): RedirectResponse
    {
        return $request->delete(
            using: fn(User $user) => $user->delete()
        );
    }
}
