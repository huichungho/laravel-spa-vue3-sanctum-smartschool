<?php

namespace App\Http\Controllers\API;

use App\Models\School;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;


class SchoolController extends Controller
{
    // all schools
    public function index()
    {
        $schools = School::all()->orderBy('School.id', 'desc')->toArray();
        return array_reverse($schools);
    }

    public function get(Request $request)
    {
        $uid = $request->id > 0 ? $request->id : Auth::user()->id;
        $data = new \stdClass;

        if(User::find($uid)->hasRole('superadmin')) {
            $schools = School::all();
            $data->schools = [];
            foreach($schools as $school) {
                array_push($data->schools, (object) array(
                    'id' => $school->id,
                    'name' => $school->name
                ));
            }
        } else {
            $school_id = User::find($uid)->school_id;
            $schools = School::where('id', $school_id)->first();
            $data->schools = [
                (object) array(
                    'id' => $schools->id,
                    'name' => $schools->name
                ),
            ];
        }

        return collect($data);
    }
}
