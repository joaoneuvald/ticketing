<?php

namespace App\Http\Controllers;

use App\Domain\Actions\Auth\ConfirmLoginAction;
use App\Domain\Actions\Auth\LoginAction;
use App\Domain\DTOs\Auth\Credentials;
use App\Domain\Responses\AppResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request, LoginAction $loginAction): AppResponse
    {
        $credentials = new Credentials(
            $request->input('username'),
            $request->input('password'),
            $request->boolean('is_admin')
        );

        $loginAction->execute($credentials);

        return new AppResponse('messages.auth.confirmationSent');
    }

    public function confirmLogin(string $code, Request $request, ConfirmLoginAction $confirmLoginAction): AppResponse
    {
        $credentials = new Credentials(
            $request->input('username'),
            $request->input('password'),
            $request->boolean('is_admin')
        );

        $token = $confirmLoginAction->execute($credentials, (int) $code);

        return new AppResponse(data: $token->toArray());
    }
}
