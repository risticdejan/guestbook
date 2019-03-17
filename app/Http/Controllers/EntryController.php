<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Http\Resources\EntryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
{
    /**
     * Create a new EntryController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj =  Entry::latest()->with("user")->paginate(5);

        return response()->json([
            'entries' => EntryResource::collection($obj),
            'current_page' => $obj->currentPage(),
            'length' => $obj->lastPage()
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request(['name','subject', 'email', 'body']);
        
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:80'],
            'subject' => ['required', 'string',  'max:255'],
            'body' => ['required', 'string',  'max:20000'],
            'email' => ['email']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $entry = auth()->user()->entries()->create(request()->all());

        if ($entry) {
            return response()->json([
                'entry' => new EntryResource($entry),
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'Entry didn\'t create'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        if ($entry) {
            return response()->json([
                'entry' => new EntryResource($entry),
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => "There isn't the entry"
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        //
    }
}
