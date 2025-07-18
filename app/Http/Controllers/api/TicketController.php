<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketContent;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TicketContentResource;

class TicketController extends Controller
{
   public function index()
    {
        try {
            $user = auth()->user();

            $ticket = Ticket::where('user_id', $user->id)->get();

            return TicketResource::collection($ticket);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($ticket_id)
    {
        try {

            $ticket = TicketContent::where('ticket_id', $ticket_id)->get();

            return TicketContentResource::collection($ticket);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function store(Request $request)
    {
        try {

            $ticket_created = Ticket::create([
                'user_id' => auth()->user()->id,
                'subject' => $request->subject,
            ]);

            $content = TicketContent::create([
                'ticket_id' => $ticket_created->id,
                'text' => $request->text,
                'sender' => 'user',
                'file' => '/'
            ]);

            if ($request->hasFile('file')) {
                $this->saveFile($request, $content->id);
            }


            return response()->json([
                'message' => 'ticket saved'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function continueTicket(Request $request, $ticket_id)
    {
        try {

            $content = TicketContent::create([
                'ticket_id' => $ticket_id,
                'text' => $request->text ? $request->text : ' ',
                'sender' => 'user',
                'file' => '/'
            ]);

            if ($request->hasFile('file')) {
                $this->saveFile($request, $content->id);
            }

            return response()->json([
                'message' => 'ticket saved'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    private function saveFile(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/ticket/content/file/" . $id);

        Storage::disk('public')->makeDirectory('/ticket/content/file/');
        $path[] = "/storage/" . Storage::disk('public')->put("/ticket/content/file/" . $id, $request->file);

        TicketContent::findOrFail($id)->update([
            'file' => json_encode($path)
        ]);
    }
}
