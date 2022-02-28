<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::latest()->paginate(20);
        return view('client.index',['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Client::all();
        return view('client.create',['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'max:255', 'string'],
            'username'  => ['required', 'max:255', 'string'],
            'email'  => ['required', 'max:255', 'string', 'email'],
            'phone'  => ['max:255', 'string'],
            'country'  => ['max:255', 'string'],
            'status'  => ['max:255', 'string'],
            'thumbnail'  => ['image'],


        ]);
        if(!empty($request->file('thumbnail')) ){
            $image = time(). '-'.$request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->storeAs('public/uploads',$image);
        }




        Client::create([
            'name' => $request->name,
            'username' => $request->username,
            'email'  => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'status' => $request->status,
            'thumbnail' => $image,


        ]);


        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
