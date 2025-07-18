<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
     public function index()
    {
        $tickets = Ticket::all();
        return view('panel.ticket.index', compact('tickets'));
    }
    public function close(Ticket $ticket)
    {
        $ticket->is_closed = true;
        $ticket->save();

        return back()->with([
            'success' => 'تیکت با موفقیت بسته شد'
        ]);
    }
    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required','exists:tickets,id']
        ]);

        Ticket::findOrFail($request->id)->delete();

        return back()->with([
            'success' => 'تیکت با موفقیت حذف شد'
        ]);
    }
}
