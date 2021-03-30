<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\News;
use DB;
use App\SectionTitles;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyid = get_company_id();
        $titles = SectionTitles::where('company_id', '=', $companyid)->get();
        $news = News::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('sadmin.newslist',compact('news','titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sadmin.newsadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $news = new News();
        $news->fill($request->all());

        if ($file = $request->file('newsimage')){
            $photo_name = str_random(3).$request->file('newsimage')->getClientOriginalName();
            $file->move('assets/images/news',$photo_name);
            $news['newsimage'] = $photo_name;
        }

        $news['tempcode'] = str_random(6);

        if ($request->status == "")
        {
            $news['status'] = 0;
        }
        else
        {
            $news['status'] = 1;
        }

        $news['company_id'] = get_company_id();

        $news->save();
        return redirect('sadmin/news')->with('message','New News Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('sadmin.newsedit',compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $news = News::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('newsimage')){
            $photo_name = str_random(3).$request->file('newsimage')->getClientOriginalName();
            $file->move('assets/images/news',$photo_name);
            $data['newsimage'] = $photo_name;
        }
        
        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }
       
        $news->update($data);
        return redirect('sadmin/news')->with('message','News Updated Successfully.');
    }

    public function status($id , $status)
    {
        $news = News::findOrFail($id);
        $input['status'] = $status;

        $news->update($input);
        return redirect('sadmin/news')->with('message','News Status Updated Successfully.');
    }

    public function titles(Request $request)
    {
        $companyid = get_company_id();
        
        $news = SectionTitles::where('company_id', $companyid);
        $data['news_title'] = $request->news_title;
        $data['news_text'] = $request->news_text;
        
        $news->update($data);
        return redirect('sadmin/news')->with('message','News Section Title & Text Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect('sadmin/news')->with('message','News Delete Successfully.');
    }
}
