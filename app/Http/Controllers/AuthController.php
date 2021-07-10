<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    protected function jwt($user)
    {
        $payload = [
            'iss' => "https://api.finansis.marcushakozaki.com.br", // Issuer do TOKEN.
            'sub' => 'anerao', // Subject do TOKEN.
            'user' => $user->name, // Nome do usuário.
            'iat' => time(), // Hora da emissão do TOKEN.
            'exp' => time() + 60 * 60 // Hora de exporiração do TOKEN.
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    protected function retornaToken($user)
    {
        return response()->json(['token' => $this->jwt($user)], Response::HTTP_OK);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $user = ['login'=>'anerao', 'password'=>'351798a_vpr'];
        return $this->retornaToken($user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
