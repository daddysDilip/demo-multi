<?php

namespace App\Http\Controllers;

use App\Brand;
use App\FAQ;
use App\PageSettings;
use App\PageSettingTranslations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Seosetion;
use Illuminate\Support\Str;

class PageSettingsController extends Controller
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
        $companyid = get_company_id();
        $brands = Brand::where('type','brand')->where('company_id', '=', $companyid)->get();
        $banners = Brand::where('type','banner')->where('company_id', '=', $companyid)->get();
        $faqs = FAQ::where('company_id',$companyid)->orderBy('id','desc')->get();
        $pagedata = PageSettings::where('company_id', '=', $companyid)->get();
        return view('admin.pagesettings',compact('pagedata','faqs','brands','banners'));
    }

    //Banner Add,Edit,Update
    public function addbanner()
    {
        return view('admin.banneradd');
    }

    public function bannerdelete($subdomain,$id)
    {
        Brand::findOrFail($id)->delete();
        return redirect('admin/pagesettings')->with('message',trans("app.BannerDeletedMsg"));
    }

    public function banneredit($subdomain,$id)
    {
        $banner = Brand::findOrFail($id);
        return view('admin.banneredit',compact('banner'));
    }

    public function bannersave(Request $request)
    {
        $brand = new Brand();
        $brand->fill($request->all());
        $brand->type='banner';
        if ($file = $request->file('blogo')){
            $photo_name = time().$request->file('blogo')->getClientOriginalName();
            $file->move('assets/images/brands',$photo_name);
            $brand['image'] = $photo_name;
        }

        if ($request->status == ""){
            $brand['status'] = 0;
        }
        else
        {
           $brand['status'] = 1; 
        }

        $brand['company_id'] = get_company_id();

        $brand->save();
        Session::flash('message', trans("app.NewBannerAddedMsg"));
        return redirect('admin/pagesettings');
    }

    public function bannerupdate(Request $request,$subdomain,$id)
    {
        $brand = Brand::findOrFail($id);
        $data = $request->all();
        $data['type']='banner';
        if ($file = $request->file('blogo')){
            $photo_name = time().$request->file('blogo')->getClientOriginalName();
            $file->move('assets/images/brands',$photo_name);
            $data['image'] = $photo_name;
        }

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $brand->update($data);
        Session::flash('message', trans("app.BannerUpdatedMsg"));
        return redirect('admin/pagesettings');
    }

    public function bannerstatus($subdomain,$id , $status)
    {
        $banner = Brand::findOrFail($id);
        $input['status'] = $status;

        $banner->update($input);

        return redirect('admin/pagesettings')->with('message',trans("app.BannerStatusUpdatedMsg"));
    }

    //Brand Logo Add,Edit,Update
    public function addbrand()
    {
        return view('admin.brandadd');
    }

    public function branddelete($subdomain,$id)
    {
        Brand::findOrFail($id)->delete();
        return redirect('admin/pagesettings')->with('message',trans("app.BrandDeletedMsg"));
    }

    public function brandedit($subdomain,$id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brandedit',compact('brand'));
    }

    public function brandsave(Request $request)
    {
        $brand = new Brand();
        $brand->fill($request->all());
        $brand->type='brand';
        if ($file = $request->file('blogo')){
            $photo_name = time().$request->file('blogo')->getClientOriginalName();
            $file->move('assets/images/brands',$photo_name);
            $brand['image'] = $photo_name;
        }

        if ($request->status == ""){
            $brand['status'] = 0;
        }
        else
        {
           $brand['status'] = 1; 
        }

        $brand['company_id'] = get_company_id();

        $brand->save();
        Session::flash('message', trans("app.NewBrandLogoMsg"));
        return redirect('admin/pagesettings');
    }
    //Large Banner
    public function largebanner(Request $request)
    {
        $companyid = get_company_id();
        $page = PageSettings::where('company_id', '=', $companyid);
        $input = $request->except(['_token']);

        if ($file = $request->file('large_banner')) {
            $banner = $request->file('large_banner');
            $name = time().$banner->getClientOriginalName();
            $banner->move('assets/images', $name);
            $input['large_banner'] = $name;
        }

        $page->update($input);
        Session::flash('message', trans("app.LargeBannerUpdatedMsg"));
        return redirect('admin/pagesettings');
    }

    public function brandupdate(Request $request,$subdomain,$id)
    {
        $brand = Brand::findOrFail($id);
        $data = $request->all();

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $brand->update($data);
        Session::flash('message', trans("app.BlogUpdateMsg"));
        return redirect('admin/pagesettings');
    }

    public function brandstatus($subdomain,$id , $status)
    {
        $barnd = Brand::findOrFail($id);
        $input['status'] = $status;

        $barnd->update($input);

        return redirect('admin/pagesettings')->with('message',trans("app.BrandStatusUpdatedMsg"));
    }

    //FAQ Page Add,Edit,Update
    public function addfaq()
    {
        return view('admin.faqadd');
    }

    public function faqdelete($subdomain,$id)
    {
        FAQ::findOrFail($id)->delete();
        return redirect('admin/pagesettings')->with('message',trans("app.FAQDeletedMsg"));
    }

    public function faqedit($subdomain,$id)
    {
        $faq = FAQ::findOrFail($id);
        return view('admin.faqedit',compact('faq'));
    }

    public function faqsave(Request $request)
    {
        $faq = new FAQ();
        $faq->fill($request->all());

        if ($request->status == ""){
            $faq['status'] = 0;
        }
        else
        {
           $faq['status'] = 1; 
        }

        $faq['company_id'] = get_company_id();

        $faq->save();
        Session::flash('message', trans("app.NewFAQAddedSuccessfully"));
        return redirect('admin/pagesettings');
    }

    public function faqupdate(Request $request,$subdomain,$id)
    {
        $faq = FAQ::findOrFail($id);
        $data = $request->all();

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        $faq->update($data);
        Session::flash('message', trans("app.FAQUpdatedMsg"));
        return redirect('admin/pagesettings');
    }

    public function status($subdomain,$id , $status)
    {
        $faq = FAQ::findOrFail($id);
        $input['status'] = $status;

        $faq->update($input);

        return redirect('admin/pagesettings')->with('message',trans("app.FAQStatusUpdatedMsg"));
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
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        //
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
        //
    }

    //Upadte FAQ Page Section Settings
    public function faq(Request $request)
    {
        $companyid = get_company_id();
        $page = PageSettings::where('company_id', '=', $companyid);
        $input = $request->except(['_token']);
        if ($request->f_status == ""){
            $input['f_status'] = 0;
        }
        $page->update($input);
        Session::flash('message', trans("app.FAQContentUpdatedMsg"));
        return redirect('admin/pagesettings');
    }

    //Upadte Contact Page Section Settings
    public function contact(Request $request)
    {

        $companyid = get_company_id();
        $page = PageSettings::where('company_id', '=', $companyid);
        $input = $request->except(['_token','default_langcode','langcode','trans_contact']);
        
        if ($request->c_status == ""){
            $input['c_status'] = 0;
        }
        $page->update($input);

        $pagedeflang_exists = PageSettingTranslations::where('langcode', '=', $request->default_langcode)->where('pagesettingsid', '=', $input['id'])->first();

        if(count($pagedeflang_exists) > 0)
        {
            PageSettingTranslations::where('langcode', '=', $request->default_langcode)->where('pagesettingsid', '=', $input['id'])->update(['contact' => $request->contact]);
        }
        else
        {
            $pagetrans = new PageSettingTranslations();
            $pagetrans['pagesettingsid'] = $input['id'];
            $pagetrans['contact'] = $request->contact;
            $pagetrans['langcode'] = $request->default_langcode;
            $pagetrans['company_id'] = get_company_id();
            $pagetrans->save();
        }
        

        foreach($request->langcode as $data => $transdata)
        {
            $pagelang_exists = PageSettingTranslations::where('langcode', '=', $transdata)->where('pagesettingsid', '=', $input['id'])->first();
            
            if(count($pagelang_exists) > 0)
            {

                PageSettingTranslations::where('langcode', '=', $transdata)->where('pagesettingsid', '=', $input['id'])->update(['contact' => $request->trans_contact[$data]]);
            }
            else
            {
                $pagealltrans = new PageSettingTranslations();
                $pagealltrans['pagesettingsid'] = $input['id'];
                $pagealltrans['contact'] = $request->trans_contact[$data];
                $pagealltrans['langcode'] = $transdata;
                $pagealltrans['company_id'] = get_company_id();
                $pagealltrans->save();
            }
            
        }

        Session::flash('message', trans("app.ContactContentUpdatedMsg"));
        return redirect('admin/pagesettings');
    }

    public function exist_faq(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $title_exists = (count(\App\FAQ::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('question', '=', $request->input('question'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\FAQ::where('question', '=', $request->input('question'))->where('company_id', '=', $companyid)->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        //
    }

     public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'question',
                        1 =>'answer',
                        2 =>'status',
                        3 =>'action',    
                         );
                    
    $totalData = FAQ::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = FAQ::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  FAQ::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('question', 'LIKE',"%{$search}%")
                            ->orWhere('answer', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();



        $totalFiltered = FAQ::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('question', 'LIKE',"%{$search}%")
                            ->orWhere('answer', 'LIKE',"%{$search}%")
                            ->count();
                // dd($totalFiltered);
        }
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                
                $nestedData['question'] =$post->question;
                $nestedData['answer'] =$post->answer;
            
               if($post->status == 1)
                  {

                  $nestedData['status'] = "<a href='".url('admin/pagesettings')."/status/".$post->id."/0'class='"."btn btn-success btn-xs'>Active</a>";
                 }


                          
               elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/pagesettings')."/status/".$post->id."/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                } 

                
    $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='faq/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_faqdata('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";


   
                $data[] = $nestedData;
                $i++;
            }
        }          
        $json_data=array(
                  "draw"            => intval($request->input('draw')),  
                  "recordsTotal"    => intval($totalData),  
                  "recordsFiltered" => intval($totalFiltered), 
                  "data"            => $data   
                    );
        // dd($json_data);
       echo json_encode($json_data,JSON_UNESCAPED_UNICODE );        
 }   


   public function allPostsbanner(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'image',
                        1 =>'link',
                        2 =>'status',
                        3 =>'action',    
                         );
                        

    $totalData = Brand::where('type','banner')->where('company_id', '=', $companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Brand::where('type','banner')
                            ->where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Brand::where('type','banner')
                            ->where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('link', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();



        $totalFiltered = Brand::where('type','banner')
                            ->where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('link', 'LIKE',"%{$search}%")
                            ->count();
                // dd($totalFiltered);
        }
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                
              

        if($post->image != '')
            {
            $image= "<img style='max-width: 250px;' src='".url("/")."/assets/images/brands/".$post->image."'>";
              }
               else
               {
        
                  $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='max-width: 250px;'>";
              }


                $nestedData['image'] =$image;
                $nestedData['link'] =$post->link;
           
               if($post->status == 1)
                  {

                  $nestedData['status'] = "<a href='".url('admin/banner')."/status/".$post->id."/0'class='"."btn btn-success btn-xs'>Active</a>";
                 }
                          
               elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/banner')."/status/".$post->id."/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                } 
             

                
    $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='banner/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_banner('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";


   
                $data[] = $nestedData;
                $i++;
            }
        }          
        $json_data=array(
                  "draw"            => intval($request->input('draw')),  
                  "recordsTotal"    => intval($totalData),  
                  "recordsFiltered" => intval($totalFiltered), 
                  "data"            => $data   
                    );
        // dd($json_data);
       echo json_encode($json_data,JSON_UNESCAPED_UNICODE );        
 }   

  public function allPostsbrandlogo(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'image',
                        1 =>'status',
                        2 =>'action',    
                         );


    $totalData = Brand::where('type','brand')->where('company_id', '=', $companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Brand::where('type','brand')
                            ->where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Brand::where('type','brand')
                            ->where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('link', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();



        $totalFiltered = Brand::where('type','brandbrands')
                            ->where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('link', 'LIKE',"%{$search}%")
                            ->count();
                // dd($totalFiltered);
        }
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                
              

        if($post->image != '')
            {
            $image= "<img style='max-width: 250px;' src='".url("/")."/assets/images/brands/".$post->image."'>";
              }
               else
               {
        
                  $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='max-width: 250px;'>";
              }


                $nestedData['image'] =$image;
              
                


               if($post->status == 1)
                  {

                  $nestedData['status'] = "<a href='".url('admin/brandstatus')."/status/".$post->id."/0'class='"."btn btn-success btn-xs'>Active</a>";
                 }
                          
               elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/brandstatus')."/status/".$post->id."/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                } 
             

                
    $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='banner/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_brand('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";


   
                $data[] = $nestedData;
                $i++;
            }
        }          
        $json_data=array(
                  "draw"            => intval($request->input('draw')),  
                  "recordsTotal"    => intval($totalData),  
                  "recordsFiltered" => intval($totalFiltered), 
                  "data"            => $data   
                    );
        // dd($json_data);
       echo json_encode($json_data,JSON_UNESCAPED_UNICODE );        
 }   




  public function allpostsseo(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'metatitle',
                        1 =>'metakey',
                        2 =>'metadec',
                        3 =>'action',    
                         );


    $totalData = Seosetion::where('company_id', '=', $companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Seosetion::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Seosetion::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('metatitle', 'LIKE',"%{$search}%")
                               ->orWhere('metakey', 'LIKE',"%{$search}%")
                                  ->orWhere('metadec', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();



        $totalFiltered = Seosetion::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('metatitle', 'LIKE',"%{$search}%")
                               ->orWhere('metakey', 'LIKE',"%{$search}%")
                                  ->orWhere('metadec', 'LIKE',"%{$search}%")
                            ->count();
                // dd($totalFiltered);
        }
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                
              

      

                $nestedData['metatitle'] =$post->metatitle;
               $nestedData['metakey'] =$post->metakey;
               $nestedData['metadec'] =$post->metadec;
                
                
                


               // if($post->status == 1)
               //    {

               //    $nestedData['status'] = "<a href='".url('admin/brandstatus')."/status/".$post->id."/0'class='"."btn btn-success btn-xs'>Active</a>";
               //   }
                          
               // elseif($post->status == 0)
               //  {
               //        $nestedData['status'] = "<a href='".url('admin/brandstatus')."/status/".$post->id."/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
               //  } 
             

                
    $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='seoview/".$post->slug."'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li></ul></div>";


   
                $data[] = $nestedData;
                $i++;
            }
        }          
        $json_data=array(
                  "draw"            => intval($request->input('draw')),  
                  "recordsTotal"    => intval($totalData),  
                  "recordsFiltered" => intval($totalFiltered), 
                  "data"            => $data   
                    );
        // dd($json_data);
       echo json_encode($json_data,JSON_UNESCAPED_UNICODE );        
 }   



         public function seoadd()
         {


             return view('admin.seosetionadd');
         }


        public function seoinsert(Request $request)
         {

                // dd($request->all());

                

                 $seosetion = new Seosetion();
        $seosetion->fill($request->all());

        $cslug = Str::slug($request->metatitle, '-');
        $slugcheck = Seosetion::where('slug','=',$cslug)->count();

        $slug="";
        if($slugcheck > 0 )
        {   
            $slug = $cslug."_".($slugcheck-1);
        }
        else
        {
            $slug = $cslug;
        }




   
          $seosetion['metatitle'] = $request->metatitle;
        $seosetion['metadec'] = $request->metadec;
            $seosetion['metakey'] = $request->metakey;
    
        $seosetion['slug'] = $slug;
        $seosetion['company_id'] = get_company_id();

           // dd($blog); 
        $seosetion->save();
        return redirect('admin/pagesettings');

       
        }

          public function seoview($subdomain,$id)
    {
        $seosetion = Seosetion::where('slug',$id)->first();
        // dd($seosetion);

        return view('admin.seosetionedit',compact('seosetion'));
    }


    public function seosetionupdate(Request $request, $subdomain)
    {
       
        // dd($request->all());

                        $seosetion=Seosetion::findOrFail($request->id);
                         $data = $request->all();


                          $data['metatitle'] = $request->metatitle;
                          $data['metadec'] = $request->metatitle;
                          $data['metakey'] = $request->metatitle;

                          

                             $seosetion->update($data);

                               return redirect('admin/pagesettings');

                        

    }
}
