<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\School;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Register
     */
    public function register(Request $request)
    {
        try {
            // add school info
            $school = School::factory()->create(
                [
                    'name' => $request->school_name
                ]
            );

            // add school admin info
            $user = User::factory()->create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'email_verified_at' => now(),
                    'school_id' => $school->id
                ]
            );
            $user->assignRole('schooladmin');
            // $user = User::query()->firstWhere('id', $user->id);
            // $token =  $user->createToken('login-token')->plainTextToken;
            // event(new Registered($user));
            
            $success = true;
            $message = 'User register successfully';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $token = null;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            // 'token'   => $token,
            'message' => $message,
        ];
        return response()->json($response);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $success = true;
            // $user = Auth::user();
            $user = User::where('email', $credentials['email'])->first();
            $user = User::query()->firstWhere('id', $user->id);
            $token =  $user->createToken('login-token')->plainTextToken;
            $message = 'User login successfully';
            
        } else {
            $success = false;
            $token = null;
            $message = 'Unauthorised';
        }

        // response
        $response = [
            'success' => $success,
            'token'   => $token,
            'message' => $message,
        ];
        return response()->json($response);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {
            session()->flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }


    // API calls

    public function get(Request $request)
    {
        $uid = $request->id > 0 ? $request->id : Auth::user()->id;
        $role = User::find($uid)->getrolenames()->first();
        
        $data = (object) array(
            'role' => $role,
        );

        return collect($data);
    }

    public function index()
    {
        $role = $this->get(new Request(['id'=>0]))->first();
        $school_id = (new SchoolController)->get(new Request(['id'=>0]))->first()[0]->id;

        $user = User::with('schools','roles');
        if ($role !== 'superadmin') {
            $user = $user->where('school_id', $school_id);
            switch ($role) {
                case 'student'     : $user->whereHas('roles', function($q){ $q->whereIn('name', ['student'          ]);}); break;
                case 'teacher'     : $user->whereHas('roles', function($q){ $q->whereIn('name', ['student','teacher']);}); break;
                case 'schooladmin' : $user->whereHas('roles', function($q){ $q->whereIn('name', ['student','teacher']);}); break;
                case 'superadmin'  :  /*------------------------- able to view all other roles -------------------------*/ break;
            }
        }
        return $user->where('users.name', '!=', 'superadmin')->get();

        // debug
        // return User::with('schools', 'roles')->where('users.name','!=','superadmin')->get();
    }

    public function add(Request $request)
    {
        $pwd = str_random(8);
        $user = User::factory()->create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($pwd),
                'email_verified_at' => now(),
                'school_id' => $request->school_id,
            ]
        );
        $user->assignRole($request->role);

        // $user->sendEmailVerificationNotification();
        // send user email with temp password
        $this->notify($request->email, $pwd, $request->role);

        return response()->json('Added new '. $request->role);
    }

    public function edit()
    {
        //
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json('User successfully deleted');
    }

    private function notify($email, $pwd, $role)
    {
        $content = [
            'title' => "Your new ($role) Account Information",
            'message' => "Login email: $email  password: $pwd"
        ];

        Mail::to($email)->send(new \App\Mail\newUser($content));
    }

}