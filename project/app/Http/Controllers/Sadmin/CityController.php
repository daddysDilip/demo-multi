<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\City;
use App\State;
use App\Country;
use Illuminate\Http\Request;
use Auth;

class CityController extends Controller
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
        $state = State::where('countryid',$cid)->where('status',1)->get();
        $sid = $state[0]->id;
        $city = City::where('stateid',$sid)->get();
        return view('sadmin.citylist',compact('city','country','cid','state','sid'));
    }

    public function citybycsid($countryid,$stateid)
    {
        $country = Country::where('status',1)->get();
        $cid = $countryid;
        $state = State::where('countryid',$cid)->where('status',1)->get();
        $sid = $stateid;
        $city = City::where('stateid',$sid)->get();
        return view('sadmin.citylist',compact('city','country','cid','state','sid'));
    }

    public function statelist($cid)
    {
        $state = State::where('countryid',$cid)->where('status',1)->get();
        return response()->json(array('state' => $state));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = State::where('status',1)->get();
        return view('sadmin.cityadd',compact('state'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = new City();
        $city->fill($request->all());

        if ($request->status == ""){
            $city['status'] = 0;
        }
        else
        {
           $city['status'] = 1; 
        }

        $city->save();
        return redirect('sadmin/city')->with('message','City Added Successfully.');
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
        $city = City::findOrFail($id);
        $state = State::where('status',1)->get();
        return view('sadmin.cityedit',compact('state','city'));
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
        $city = City::findOrFail($id);
        $data = $request->all();

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $city->update($data);
        return redirect('sadmin/city')->with('message','City Updated Successfully.');
    }

    public function status($id , $status)
    {
        $city = City::findOrFail($id);
        $input['status'] = $status;

        $city->update($input);

        return redirect('sadmin/city')->with('message','City Updated Successfully.');
    }

    public function city_exists(Request $request){

        $id = $request->input('id');
        $stateid = $request->input('stateid');

        if($stateid != '')
        {
            if($id != '')
            {
                $name_exists = (count(\App\City::where('id', '!=', $id)->where('stateid', '=', $stateid)->where('cityname', '=', $request->input('cityname'))->get()) > 0) ? false : true;
                return response()->json($name_exists);
            }
            else
            {
                $name_exists = (count(\App\City::where('stateid', '=', $stateid)->where('cityname', '=', $request->input('cityname'))->get()) > 0) ? false : true;
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
        $city = City::findOrFail($id);
        $city->delete();
        return redirect('sadmin/city')->with('message','City Delete Successfully.');
    }
}
