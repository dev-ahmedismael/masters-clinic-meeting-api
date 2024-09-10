<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservations\ReservationRequest;
use App\Mail\MeetingURL;
use App\Models\Doctor;
use App\Models\Reservation;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Jubaer\Zoom\Facades\Zoom;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Reservation::with(['doctor.user'])->latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = $request->date;
        $time = Carbon::createFromFormat('H:i:s', $request->time);
        $date_time = $date . 'T' . $time . 'Z';

        $doctor_profile = Doctor::find($request->doctor_id);
        $doctor = $doctor_profile->user;
        $reservations = Reservation::where('doctor_id', $request->doctor_id)->whereDate('date', $date)->get();
        foreach ($reservations as $reservation) {
            $start_time = Carbon::createFromFormat('H:i:s', $reservation['time']);
            $end_time = $start_time->copy()->addMinutes(30);

            if ($time->greaterThanOrEqualTo($start_time) && $time->lessThan($end_time)) {
                return response()->json(['message' => 'الطبيب لديه حجز مسبق في هذا الموعد، يرجى اختيار موعد آخر.'], 422);
            };
        }

        $meeting = Zoom::createMeeting([
            'topic' => $doctor['name'],
            'type' => 2, // 1 => instant, 2 => scheduled
            'start_time' =>  $date . 'T' . $request->input('time') . 'Z',
            'duration' => 30, // in minutes
            'timezone' => 'Asia/Riyadh', // Set time zone to Riyadh
            'password' => 'amnc',
            'settings' => [
                'waiting_room' => true, // Enable Waiting Room
                'join_before_host' => false, // Disable Join Before Host
                'host_video' => true,
                'participant_video' => true,
                'mute_upon_entry' => true,
            ],
        ]);

        $reservation = Reservation::create($request->all());
        $reservation->meeting_url = $meeting['data']['join_url'];
        $reservation->save();

        Mail::to($request->patient_email)->send(new MeetingURL($meeting['data']['join_url']));

        return response()->json(['meeting_url' => $meeting['data']['join_url']], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    public function today_reservations(Request $request)
    {
        $user = auth()->user();
        $doctor = Doctor::where('user_id', $user['id'])->first();
        $reservations = Reservation::where('doctor_id', $doctor->id)->whereDate('date', Carbon::today())->get();

        return response()->json(['reservations' => $reservations], 200);
    }

    public function doctor_reservations(Request $request)
    {
        $user = auth()->user();
        $doctor = Doctor::where('user_id', $user['id'])->first();
        $reservations = Reservation::where('doctor_id', $doctor->id)->get();

        return response()->json(['reservations' => $reservations], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Reservation::destroy($id);
        $reservations = Reservation::with(['doctor.user'])->get();
        $message = 'تم حذف الحجز بنجاح.';
        return response()->json(['reservations' => $reservations, 'message' => $message], 200);
    }

    public function get_reservation_doctors(Request $request)
    {
        $branch = $request->branch_id;
        $department = $request->department_id;
        $doctors = Doctor::where('branch_id', $branch)->where('department_id', $department)->with(['branch', 'department', 'user'])->get();

        return response()->json(['doctors' => $doctors], 200);
    }
}
