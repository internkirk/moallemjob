<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketContent;
use Illuminate\Support\Facades\Storage;

class TicketContentController extends Controller
{
     public function index(Ticket $ticket)
    {
        $ticketContents = TicketContent::where('ticket_id',$ticket->id)->get();
        $ticket_id = $ticket->id;
        return view('panel.ticket.ticket-content.index',compact('ticketContents','ticket_id'));
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'text' => ['required']
        ]);

       $ticket = TicketContent::create([
            'ticket_id' => $request->ticket_id,
            'text' => $request->text ? $request->text : ' ',
            'sender' => 'admin'
        ]);

        if ($request->hasFile('file')) {
            $this->saveFile($request, $ticket->id);
        }

        return back()->with([
            'success' => 'با موفقیت ارسال شد'
        ]);
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
