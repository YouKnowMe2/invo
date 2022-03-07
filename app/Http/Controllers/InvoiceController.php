<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceEmail;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class InvoiceController extends Controller
{


    public function index(){
        $invoices = Invoice::where('user_id',Auth::user()->id)->with('client')->latest()->paginate(10);
        return view('invoice.index')->with([
            'invoices' => $invoices
        ]);
    }

    public function create(){
        return view('invoice.create')->with([
            'clients' => Client::where('user_id',Auth::user()->id)->get(),
        ]);
    }



    public function preview(Request $request)
    {
        $invoice = Invoice::where('client_id',$request->client_id)->latest()->get();


        return view('invoice.preview')->with([
            'user' => Auth::user(),
            'tasks' => $this->getInvoice($request),
            'invoice_no' => $invoice->first()->invoice_id

        ]);
    }


    public function generate(Request $request)
    {


        dd($request->all());
        $invo_no = 'Invo_no' . rand(23432, 234234);
        $data = [
            'user' => Auth::user(),
            'tasks' => $this->getInvoice($request),
            'invoice_no' => $invo_no
        ];

        $pdf = Pdf::loadView('invoice.pdf', $data);

        Storage::put('public/invoices/' . $invo_no . '.pdf', $pdf->output());

            Invoice::create([
                'invoice_id' => $invo_no,
                'client_id' => $request->client_id,
                'user_id' => Auth::user()->id,
                'status' => 'unpaid',
                'download_url' => $invo_no . '.pdf'
            ]);

        return redirect()->route('invoice.index')->with('success', 'Invoice created');

    }
        public function download(Request $request){
        $invoice = Invoice::where('client_id',$request->client_id)->latest()->get();

        $data = [
            'user' => Auth::user(),
            'tasks' => $this->getInvoice($request),
            'invoice_no'=> $invoice->first()->invoice_id


        ];
        $pdf = Pdf::loadView('invoice.pdf',$data);
        return $pdf->download('invoice.pdf');
    }


    public function getInvoice(Request $request){
        $task = Task::where('user_id',Auth::user()->id)->get();

        if(!empty($request->client_id)){
            $task = $task->where('client_id','=',$request->client_id);
        }
        if(!empty($request->status)){
            $task = $task->where('status','=',$request->status);
        }
        return $task;

    }


    public function show(Invoice $invoice){

      return view('invoice.show')->with([
          'invoice' => $invoice
      ]);
    }



    public function store(Request $request){

        $request->validate([
            'client_id' =>['required','not_in:none'],
            'status' => ['required','not_in:none']
        ]);
    }


    public function destroy(Invoice $invoice)
    {
        Storage::delete('public/invoices/'.$invoice->download_url);

        $invoice->delete();
        return back()->with('success','Invoice haas been deleted successfully');
    }



    public function status(Invoice $invoice){
        $invoice->update([
            'status' => 'paid'
        ]);
        return back()->with('success','Payment has been paid');
    }


    public function search(Request $request){
       $request->validate([
           'client_id' =>['required','not_in:none'],
           'status' => ['required','not_in:none']
       ]);
        $task = $this->getInvoice($request);

       return view('invoice.create')->with([
           'tasks' => $task,
           'clients' => Client::where('user_id',Auth::user()->id)->get()

       ]);


    }
    public function sendMail(Invoice $invoice)
    {

        $pdf = Storage::get('public/invoices/'.$invoice->download_url);
        $data = [
            'user'          => Auth::user(),
            'invoice_id'    => $invoice->invoice_id,
            'invoice'       => $invoice,
            'pdf'           => public_path('storage/invoices/' . $invoice->download_url),
        ];
        Mail::send(new InvoiceEmail($data,$pdf));
//       Mail::send('emails.invoice',$data,function ($message) use ($invoice,$pdf){
//           $message->from(Auth::user()->email, Auth::user()->name);
//           $message->to($invoice->client->email, $invoice->client->name);
//           $message->subject('SM corps ' . $invoice->invoice_id);
//           $message->attachData($pdf, $invoice->download_url,[
//               'mime' => 'application/pdf'
//           ]);
//       });

       $invoice->update([
           'email_sent' => 'yes'
       ]);
        return redirect()->route('invoice.index')->with('success','Message has been sent');
    }


}
