<?php

namespace App\Http\Controllers;

// Laravel utilities
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

// Models
use App\User;

// Repository
use App\Repositories\UserRepository;

// Request
use Illuminate\Http\Request;

// Notifications
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;

// Helpers
use Carbon\Carbon;

class AuthController extends Controller
{

    use SendsPasswordResetEmails;
     
    public function __construct(UserRepository $user) {
        
        $this->userRepo = $user;

    }

    public function login(Request $request)
    {
    	$http = new \GuzzleHttp\Client;

    	try {

            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {

            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }

            return response()->json('Something went wrong on the server.', $e->getCode());

        }
    }

    public function register(Request $request)
    {
    	$request->validate([
    		'name' 		=> 'required|string|max:255',
    		'email' 	=> 'required|string|email|max:255|unique:users',
    		'password' 	=> 'required|string|min:6',
    	]);

    	return User::create([
    		'name' 		=> $request->name,
    		'email' 	=> $request->email,
    		'password' 	=> Hash::make($request->password),
    	]);
    }

    public function logout()
    {
    	auth()->user()->tokens->each(function ($token, $key) {
    		$token->delete();
    	});

    	return response()->json('Logged out successfully', 200);
    }

    public function refreshToken(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        try {

            $response = $http->post('http://myprecious.local:8080/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $request->refresh_token,
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'scope' => ''
                ]
            ]);

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {

            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }

            return response()->json('Something went wrong on the server.', $e->getCode());

        }
    }

    /**
     * Create token password reset
     *
     * @param  [string] email
     * @param  [string] url
     * @return [string] message
     */
    public function linkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'url' => 'required|string|url',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user)
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);

        // $token = $this->tokens->createToken($user);
        $token = $this->broker()->createToken($user);

        if ($user && $token)
            $user->notify(
                new PasswordResetRequest($token, $request->url)
            );

        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required|string'
        ]);

        $user = $this->broker()->getUser($request->all());

        if (!$user)
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);

        $check_token = $this->broker()->tokenExists($user, $request->token);

        if (!$check_token)
            return response()->json([
                'message' => 'The token is invalid for this user.'
            ], 404);

        $response = $this->broker()->reset($request->all(), function ($user, $password) {
                // save new password in database
                $status = $this->userRepo->update(array('password' => $password), $user->id);
                // send success update notification
                $user->notify(new PasswordResetSuccess());
            }
        );

        return response()->json([
                'response' => $response
            ], 200);
    }
}
