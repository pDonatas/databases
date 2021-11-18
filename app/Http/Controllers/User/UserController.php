<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create($request->toArray());

        $user->update([
            'password' => \Hash::make($request->get('password'))
        ]);

        return response()->redirectToRoute('users.index');
    }

    public function show(User $user): View
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);

        if ($request->get('password')) {
            $user->update([
                'password' => Hash::make($request->get('password'))
            ]);
        }

        return response()->redirectToRoute('users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return response()->redirectToRoute('users.index');
    }
}
