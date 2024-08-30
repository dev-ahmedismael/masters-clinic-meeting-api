<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Message::all();
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
    public function store(MessageRequest $request)
    {
        Message::create($request->all());

        return response()->json(['message' => 'شكراً على تواصلكم معنا، سيتم الرد عليكم في أقرب وقت ممكن.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Message::destroy($id);
        $messages = Message::all();
        $message = 'تم حذف الرسالة بنجاح.';

        return response()->json(['message' => $message, 'messages' => $messages], 200);
    }
}
