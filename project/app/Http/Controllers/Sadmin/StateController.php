<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Country;
use App\State;
use Illuminate\Http\Request;
use Auth;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        $country = Country::where('status',1)->get();
        $cid = $country[0]->id;
        $state = State::where('countryid',$cid)->get();
        return view('sadmin.statelist',compact('cid','state','country'));
    }

    public function statebycid($id)
    {   
        $country = Country::where('status',1)->get();
        $cid = $id;
        $state = State::where('countryid',$cid)->get();
        return view('sadmin.statelist',compact('cid','state','country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::where('status',1)->get();
        return view('sadmin.stateadd',compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $state = new State();
        $state->fill($request->all());

        if ($request->status == ""){
            $state['status'] = 0;
        }
        else
        {
           $state['status'] = 1; 
        }

        $state->save();
        return redirect('sadmin/state')->with('message','State Added Successfully.');
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
        $state = State::findOrFail($id);
        $country = Country::where('status',1)->get();
        return view('sadmin.stateedit',compact('state','country'));
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
        $state = State::findOrFail($id);
        $data = $request->all();

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $state->update($data);
        return redirect('sadmin/state')->with('message','State Updated Successfully.');
    }

    public function status($id , $status)
    {
        $state = State::findOrFail($id);
        $input['status'] = $status;

        $state->update($input);

        return redirect('sadmin/state')->with('message','State Updated Successfully.');
    }

    public function state_exists(Request $request){

        $id = $request->input('id');
        $countryid = $request->input('countryid');

        if($countryid != '')
        {
            if($id != '')
            {
                $name_exists = ((\App\State::where('id', '!=', $id)->where('countryid', '=', $countryid)->where('statename', '=', $request->input('statename'))->get()) != null) ? false : true;
                return response()->json($name_exists);
            }
            else
            {
                $name_exists = ((\App\State::where('countryid', '=', $countryid)->where('statename', '=', $request->input('statename'))->get()) != null) ? false : true;
                return response()->json($name_exists);
            }
        }
        else
        {
            return response()->json(false);
        }
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        $state->delete();
        return redirect('sadmin/state')->with('message','State Delete Successfully.');
    }
}
