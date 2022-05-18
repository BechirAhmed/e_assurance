<?php
/**
 * File AuthController.php
 *
 * @author Bechir Ahmed <bechir93aa@gmail.com>
 * @package E_assurance
 * @version 1.0
 */
namespace App\Http\Controllers\Api;

use App\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::with('roles')->where('email', $request->username)->orWhere('phone_number', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->device_name)->plainTextToken;
            $response = [
                'success' => true,
                'user' => new UserResource($user),
                'token' => $token,
            ];
            return response()->json($response, Response::HTTP_OK)->header('Authorization', $token);
        }

        return response()->json(new JsonResponse([], 'Check your credentials!'), Response::HTTP_UNAUTHORIZED);
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_number' => 'required|regex:/^[0-9]+$/|min:8|unique:users',
                'email' => 'unique:users',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                ], 401);
            }

            $role = Role::where('title', 'Customer')->first();
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['name'] = $input['phone_number'];
            $createdUser = User::create($input);

            $createdUser->roles()->sync($role);

            $token = $createdUser->createToken($request->device_name)->plainTextToken;

            $user = User::with('roles')->where('id', $createdUser->id)->first();

            $response = [
                'success' => true,
                'user' => new UserResource($user),
                'token' => $token,
            ];

            return response($response);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json((new JsonResponse())->success([]), Response::HTTP_OK);
    }

    public function getUser(Request $request)
    {
        $user = User::with('roles')->where('phone_number', $request->username)->first();

        if(!isset($user)) {
            return response()->json([
                'status_code'    => '0',
                'status_message' => 'Identifiants de connexion incorrects, veuillez réessayer',
            ], 401);
        }
        
        if($user->status == 'Inactive') {
            return response()->json([
                'status_code'     => '0',
                'status_message' => 'Votre compte est désactivé, contacter l\'administration',
           ], 401);
        }


        $return_data = array(
            'status_code'       => '1',
            'status_message'    => 'Login Success',
            'user'             => new UserResource($user),
        );
    
        return response()->json($return_data, 200);   
    }

    /**
     * @return mixed
     */
    private function guard()
    {
        return Auth::guard();
    }
}
