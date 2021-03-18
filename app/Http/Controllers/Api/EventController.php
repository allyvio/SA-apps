<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Event;
use App\User;
use App\Lead;
use App\Schedule;
use App\Present;
use App\ClickEvent;

class EventController extends Controller
{
    public function guestEvent()
    {

        $data = Event::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil didapatkan!',
            'data' => $data,
        ], 200);
    }

    //list event yang di ikuti sepsifik user
    public function userHasEvent()
    {
        $data = User::findOrFail(Auth::user()->id);
        try {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil didapatkan!',
                'data' => $data->lead()->get(),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 200);
        }
    }

    public function eventHasUser($id)
    {
        $data = Event::findOrFail($id);
        try {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil didapatkan!',
                'data' => $data->lead()->get(),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 200);
        }
    }
    public function user()
    {
        $data = User::findOrFail(32);
        try {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil didapatkan!',
                'data' => $data,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 200);
        }
    }
    public function getEventById($id)
    {
        try {

            $data = Event::findOrFail($id);
            if (auth('api')->check()) {
                $user = auth('api')->user();
                $newData = new ClickEvent();
                $newData->event_id = $id;
                $newData->user_id = $user->id;
                $newData->created_by = $user->id;
                $newData->updated_by = $user->id;
                $newData->created_at = Carbon::now();
                $newData->updated_at = Carbon::now();
                $newData->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil didapatkan!',
                    'data' => $data,
                ], 200);
            } else {
                $newData = new ClickEvent();
                $newData->event_id = $id;
                $newData->user_id = null;
                $newData->created_by = null;
                $newData->updated_by = null;
                $newData->created_at = Carbon::now();
                $newData->updated_at = Carbon::now();
                $newData->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil didapatkan!',
                    'data' => $data,
                ], 200);
            }
        } catch (ModelNotFoundException $e) {
            // dd(get_class_methods($e));
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 200);
        }
    }
    public function userEventStatus($id)
    {
        $data =  DB::table('users')->where('users.id', $id)
            ->join('leads', 'users.id', '=', 'leads.users_id')
            ->join('events', 'events.id', '=', 'leads.events_id')
            ->select('users.*', 'events.*')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data ditemukan!',
            'data' => $data,
        ], 200);
    }
    public function checkUserRegistered($event_id)
    {
        $id = Auth::user()->id;
        $data =  DB::table('leads')->where('users.id', $id)
            ->join('users', 'users.id', '=', 'leads.users_id')
            ->join('events', 'events.id', '=', 'leads.events_id')->where('events.id', '=', $event_id)
            ->select('users.name')
            ->first();
        if ($data == null) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terdaftar'
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'User  terdaftar'
            ], 200);
        }
    }
    public function userRegisterEvent(Request $request)
    {

        $validatedData = $request->validate([
            'events_id' => 'required',
        ]);
        $id = Auth::user()->id;
        $data =  DB::table('leads')->where('users.id', $id)
            ->join('users', 'users.id', '=', 'leads.users_id')
            ->join('events', 'events.id', '=', 'leads.events_id')->where('events.id', '=', $request->get('event_id'))
            ->select('users.name')
            ->first();
        if ($data != null) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu telah terdaftar dalam event ini'
            ], 200);
        } else {
            $validatedData['id'] =  Str::random(30);
            $validatedData['users_id'] =  $id;
            $validatedData['created_by'] =  $id;
            $validatedData['updated_by'] =  $id;
            $validatedData['status'] =  'daftar';
            // dd($validatedData);
            $data = Lead::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Silahkan cek email kamu untuk mendapatkan informasi lebih lanjut',
                'data' => $data,
            ], 200);
        }

        //kirim email
    }
    public function getCode($code)
    {
        $data = Schedule::where('code', $code)
            ->join('events', 'events.id', '=', 'schedules.events_id')
            ->select('events.event', 'schedules.id')
            ->first();
        return response()->json([
            'success' => true,
            'message' => 'Data didapat',
            'data' => $data,
        ], 200);
    }
    public function postPresent($id)
    {
        $event = Schedule::find($id);
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi event tidak ditemukan',
            ], 200);
        }
        $data = new Present();
        $data->schedules_id = $id;
        $data->created_by = Auth::user()->id;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return response()->json([
            'success' => true,
            'message' => 'Data disimpan',
            'data' => $data,
        ], 200);
    }
}
