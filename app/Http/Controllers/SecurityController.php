<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Security;

class SecurityController extends Controller
{   


    public function __construct(){      
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('security',['securities'=>Security::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('addsecurity');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $s = new Security();
        $s->name = $request->name;
        $s->location = $request->location;
        $s->description = $request->description;
        $s->save();

        return redirect()->route('security.index')->with([
                'status'=>'success',
                'message'=>'Security firm added!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       return view('editsecurity',['security'=>Security::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $s = Security::find($id);
        $s->name = $request->name;
        $s->location = $request->location;
        $s->description = $request->description;
        $s->save();

        return redirect()->route('security.index')->with([
                'status'=>'success',
                'message'=>'Security firm updated!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $s = Security::find($id);
       $s->delete();

       return redirect()->route('security.index')->with([
                'status'=>'success',
                'message'=>'Deleted!'
        ]);
    }
}
