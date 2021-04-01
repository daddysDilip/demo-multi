<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryTranslations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => 'subcats']);
    }

    public function index()
    {
        $companyid = get_company_id();
        $child = Category::where('role','child')->where('company_id',$companyid)->orderBy('id','desc')->get();
        $subs = Category::where('role','sub')->where('company_id',$companyid)->orderBy('id','desc')->get();
        $categories = Category::where('role','main')->where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.categories',compact('categories','subs','child'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyid = get_company_id();
        $categories = Category::where('role','main')->where('company_id',$companyid)->where('status',1)->get();
        return view('admin.subcategoryadd',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('demo',$request->all());

        $category = new Category;
        $category->fill($request->all());
        $category['role'] = "sub";

        if ($request->featured == 1){
            $category->featured = 1;
                if ($file = $request->file('fimage')){
                $photo_name = time().$request->file('fimage')->getClientOriginalName();
                $file->move('assets/images/categories',$photo_name);
                $category['feature_image'] = $photo_name;   
            }
        }else{
            $category->featured = 0;
            $category['feature_image'] = ''; 
        }

        if($request->status == "")
        {
            $category['status'] = 0;
        }
        else
        {
            $category['status'] = 1;
        }

        $category['company_id'] = get_company_id();
        
        $category->save();

        $categrytrans = new CategoryTranslations();
        $categrytrans['categoryid'] = $category->id;
        $categrytrans['name'] = $request->name;
        $categrytrans['langcode'] = $request->default_langcode;
        $categrytrans['company_id'] = get_company_id();
        $categrytrans->save();
          if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $categryalltrans = new CategoryTranslations();
            $categryalltrans['categoryid'] = $category->id;
            $categryalltrans['name'] = $request->trans_name[$data];
            $categryalltrans['langcode'] = $transdata;
            $categryalltrans['company_id'] = get_company_id();
            $categryalltrans->save();     
        }
    }
   
        return redirect('admin/categories')->with('message', trans("app.SubCategoryAddMsg"));

    }


    public function storesub(Request $request)
    {
            
        // dd('demo',$request->all());

        $category = new Category;
        $category->fill($request->all());
        // $category['mainid']=$request->mainid;
        $category['name'] = $request->namesub;
        $category['slug']=$request->slugsub;
        $category['role'] = "sub";

        if ($request->featured == 1){
            $category->featured = 1;
                if ($file = $request->file('fimage')){
                $photo_name = time().$request->file('fimage')->getClientOriginalName();
                $file->move('assets/images/categories',$photo_name);
                $category['feature_image'] = $photo_name;   
            }
        }else{
            $category->featured = 0;
            $category['feature_image'] = ''; 
        }

        if($request->status == "")
        {
            $category['status'] = 0;
        }
        else
        {
            $category['status'] = 1;
        }

        $category['company_id'] = get_company_id();
            // dd($category);
        $category->save();


        return redirect()->back();

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //
    }

    public function subget($subdomain,$id)
    {
        $companyid = get_company_id();
        $defaultlang = get_defaultlanguage();

        $subcats=Category::where('mainid', $id)->where('role', 'sub')->where('company_id',$companyid)->where('status',1)->select('categories.*','categories.name as cname')->get();

         
        
        if($subcats != null)
        {

            return $subcats;
        } 
        else
        {
            $null=array();
            return null;
        }

    }



  public function subcats($subdomain,$id)
    {
        $companyid = get_company_id();
        $defaultlang = get_defaultlanguage();


        $subcats=Category::where('mainid', $id)->where('role', 'sub')->where('company_id',$companyid)->where('status',1)->select('categories.*','categories.name as cname')->get();

        
        if($subcats != null)
        {

            return response()->json(['response' => $subcats]);
        } 
        else
        {
            $null=array();
            return null;
        }

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        $companyid = get_company_id();
        $categories = Category::where('role','main')->where('company_id',$companyid)->where('status',1)->get();
        $category = Category::findOrFail($id);
        return view('admin.subcategoryedit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
       
        $category = Category::findOrFail($id);
        $input = $request->all();
            
        if ($request->featured == 1){
            $input['featured'] = 1;
            if ($file = $request->file('fimage')){
                $photo_name = time().$request->file('fimage')->getClientOriginalName();
                $file->move('assets/images/categories',$photo_name);
                $input['feature_image'] = $photo_name;
            }
        }else{
            $input['featured'] = 0;
            if($category->feature_image != '')
            {
                unlink('assets/images/categories/'.$category->feature_image);
            }
            $input['feature_image'] = '';
        }

        if($request->status == "")
        {
            $input['status'] = 0;
        }
        else
        {
            $input['status'] = 1;
        }
        
        $category->update($input);

        $categorydeflang_exists = CategoryTranslations::where('langcode', '=', $request->default_langcode)->where('categoryid', '=', $id)->first();

        if($categorydeflang_exists != null)
        {
            CategoryTranslations::where('langcode', '=', $request->default_langcode)->where('categoryid', '=', $id)->update(['name' => $request->name]);
        }
        else
        {
            $categorytrans = new CategoryTranslations();
            $categorytrans['categoryid'] = $id;
            $categorytrans['name'] = $request->name;
            $categorytrans['langcode'] = $request->default_langcode;
            $categorytrans['company_id'] = get_company_id();
            $categorytrans->save();
        }
            
              if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $categorylang_exists = CategoryTranslations::where('langcode', '=', $transdata)->where('categoryid', '=', $id)->first();
            if($categorylang_exists != null)
            {

                CategoryTranslations::where('langcode', '=', $transdata)->where('categoryid', '=', $id)->update(['name' => $request->trans_name[$data]]);
            }
            else
            {
                $categoryalltrans = new CategoryTranslations();
                $categoryalltrans['categoryid'] = $id;
                $categoryalltrans['name'] = $request->trans_name[$data];
                $categoryalltrans['langcode'] = $transdata;
                $categoryalltrans['company_id'] = get_company_id();
                $categoryalltrans->save();
            }
            
        }
    }

        return redirect('admin/categories')->with('message', trans("app.SubCatUpdateMsg"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        //die();
        $category = Category::findOrFail($id);

        if($category->feature_image != '')
        {
            unlink('assets/images/categories/'.$category->feature_image);
        }

        $childcat = Category::where('subid',$id); 

        $childcategory = Category::where('subid',$id)->get();
        foreach($childcategory as $allchildcat)
        {
            if($allchildcat->feature_image != '')
            {
                unlink('assets/images/categories/'.$allchildcat->feature_image);
            }

            $childtranscategory = CategoryTranslations::where('categoryid',$allchildcat->id);
            $childtranscategory->delete();
           
        }

        $childcat->delete();
        $category->delete();

        $categorytrans = CategoryTranslations::where('categoryid',$id);
        $categorytrans->delete();
        
        return redirect('admin/categories')->with('message', trans("app.SubCatDeleteMsg"));
    }

    public function deleteimage(Request $request , $subdomain ,$id)
    {
        // dd(' SubCetegory Cetegory DElete IMage');

        $category = Category::findOrFail($id); 
       
        if($category->feature_image != '')
        {
            unlink('assets/images/categories/'.$category->feature_image);
        }
       
        $data['feature_image'] = '';
        $updatedata = $category->update($data);
    }


}
