<?php

namespace App\Http\Controllers;

use App\Cms;
use App\CmsTranslations;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Excel;

class CmsController extends Controller
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
        $cms = Cms::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.cmslist',compact('cms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cmsadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request->all());
        $cms = new Cms();
        $cms->fill($request->all());

        // $slug = str_slug($cms['name'], '-');

        $cslug = str_slug($request->name, '-');
        $slugcheck = Cms::where('slug','=',$cslug)->count();

        $slug="";

        if($slugcheck > 0 )
        {   
            $slug = $cslug."_".($slugcheck-1);
        }
        else
        {
            $slug = $cslug;
        }

        $cms['slug'] = $slug;
        $cms['tempcode'] = str_random(6);

        if ($request->status == "")
        {
            $cms['status'] = 0;
        }
        else
        {
            $cms['status'] = 1;
        }

        $cms['company_id'] = get_company_id();

        $cms->save();

        $cmstrans = new CmsTranslations();
        $cmstrans['cmsid'] = $cms->id;
        $cmstrans['name'] = $request->name;
        $cmstrans['title'] = $request->title;
        $cmstrans['description'] = $request->description;
        $cmstrans['metatitle'] = $request->metatitle;
        $cmstrans['metadescription'] = $request->metadescription;
        $cmstrans['metakeywords'] = $request->metakeywords;
        $cmstrans['langcode'] = $request->default_langcode;
        $cmstrans['company_id'] = get_company_id();
        $cmstrans->save();

            if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $cmsalltrans = new CmsTranslations();
            $cmsalltrans['cmsid'] = $cms->id;
            $cmsalltrans['name'] = $request->trans_name[$data];
            $cmsalltrans['title'] = $request->trans_title[$data];
            $cmsalltrans['description'] = $request->trans_description[$data];
            $cmsalltrans['metatitle'] = $request->trans_metatitle[$data];
            $cmsalltrans['metadescription'] = $request->trans_metadescription[$data];
            $cmsalltrans['metakeywords'] = $request->trans_metakeywords[$data];
            $cmsalltrans['langcode'] = $transdata;
            $cmsalltrans['company_id'] = get_company_id();
            $cmsalltrans->save();    
            
        }
    }

        return redirect('admin/cms')->with('message',trans("app.CmsAddMsg"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        $cms = Cms::findOrFail($id);
        // dd($cms);
        return view('admin.cmsedit',compact('cms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        $cms = Cms::findOrFail($id);
        $data = $request->all();

        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
        }
       
        $cms->update($data);

        $cmsdeflang_exists = CmsTranslations::where('langcode', '=', $request->default_langcode)->where('cmsid', '=', $id)->first();

        if(count($cmsdeflang_exists) > 0)
        {
            CmsTranslations::where('langcode', '=', $request->default_langcode)->where('cmsid', '=', $id)->update(['name' => $request->name, 'title' => $request->title, 'description' => $request->description, 'metatitle' => $request->metatitle, 'metadescription' => $request->metadescription, 'metakeywords' => $request->metakeywords]);
        }
        else
        {
            $cmstrans = new CmsTranslations();
            $cmstrans['cmsid'] = $id;
            $cmstrans['name'] = $request->name;
            $cmstrans['title'] = $request->title;
            $cmstrans['description'] = $request->description;
            $cmstrans['metatitle'] = $request->metatitle;
            $cmstrans['metadescription'] = $request->metadescription;
            $cmstrans['metakeywords'] = $request->metakeywords;
            $cmstrans['langcode'] = $request->default_langcode;
            $cmstrans['company_id'] = get_company_id();
            $cmstrans->save();
        }
            
            if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $cmslang_exists = CmsTranslations::where('langcode', '=', $transdata)->where('cmsid', '=', $id)->first();
            if(count($cmslang_exists) > 0)
            {

                CmsTranslations::where('langcode', '=', $transdata)->where('cmsid', '=', $id)->update(['name' => $request->trans_name[$data], 'title' => $request->trans_title[$data], 'description' => $request->trans_description[$data], 'metatitle' => $request->trans_metatitle[$data], 'metadescription' => $request->trans_metadescription[$data], 'metakeywords' => $request->trans_metakeywords[$data]]);

            }
            else
            {
                $cmsalltrans = new CmsTranslations();
                $cmsalltrans['cmsid'] = $id;
                $cmsalltrans['name'] = $request->trans_name[$data];
                $cmsalltrans['title'] = $request->trans_title[$data];
                $cmsalltrans['description'] = $request->trans_description[$data];
                $cmsalltrans['metatitle'] = $request->trans_metatitle[$data];
                $cmsalltrans['metadescription'] = $request->trans_metadescription[$data];
                $cmsalltrans['metakeywords'] = $request->trans_metakeywords[$data];
                $cmsalltrans['langcode'] = $transdata;
                $cmsalltrans['company_id'] = get_company_id();
                $cmsalltrans->save();
            }
            
        }

    }

        return redirect('admin/cms')->with('message',trans("app.CmsUpdateMsg"));
    }

    public function status($subdomain, $id , $status)
    {
        $cms = Cms::findOrFail($id);
        $input['status'] = $status;

        $cms->update($input);
        return redirect('admin/cms')->with('message',trans("app.CmsStatusUpdateMsg"));
    }
	
	public function exist_titles(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
             $title_exists = (count(\App\Cms::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('name', '=', $request->input('name'))->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\Cms::where('name', '=', $request->input('name'))->where('company_id', '=', $companyid)->get()) > 0) ? false : true;
            return response()->json($title_exists);
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $id)
    {
        $cms = Cms::findOrFail($id);
        $cms->delete();

        $cmstrans = CmsTranslations::where('cmsid',$id);
        $cmstrans->delete();

        return redirect('admin/cms')->with('message',trans("app.CmsDeleteMsg"));
    }

    public function Exportdata()
    { 

        $companyid = get_company_id();
        $cms = Cms::where('company_id',$companyid)->orderBy('id','desc')->get();
        // dd($cms);
    
        $cmsArray = []; 

        $cmsArray[] = ['Sr.NO','Page Name','Page Title*','Page Details','Meta Title','Meta Description', 'Meta Keyword','Tempcode','Status'];
        $i = 1;
        foreach ($cms as $alldata) 
        {
                    
            if($alldata->status == 1)
            {
                $status = 'Active';
            }
            else if($alldata->status == 0)
            {
                $status = 'Deactive';
            }

            $name = '';
            $title = '';
            $description = '';
            $metatitle = '';
            $metadescription = '';
            $metakeywords = '';

            $cmstrans = CmsTranslations::where('cmsid',$alldata->id)->where('langcode',get_defaultlanguage())->first();

            if(count($cmstrans) > 0)
            {
                $name = $cmstrans->name;
                $title = $cmstrans->title;
                $description = $cmstrans->description;
                $metatitle = $cmstrans->metatitle;
                $metadescription = $cmstrans->metadescription;
                $metakeywords = $cmstrans->metakeywords;
            }

            $cmsArray[]= array($i, $name, $title, $description, $metatitle, $metadescription, $metakeywords, $alldata->tempcode, $status);
            $i++;
        }   
        Excel::create('CMS', function($excel) use ($cmsArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('CMS List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('CMS List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($cmsArray) {
                $sheet->fromArray($cmsArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }
                

    public function import(Request $request)
    {

        // dd($request->all(),'CMS HELLEOEOEOE');

        $companyid = get_company_id();

        if($request->file('imported_file'))
        {
            $path = $request->file('imported_file')->getRealPath();
                $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count())
            {
                $data = $data->toArray();
                for($i=0;$i<count($data);$i++)
                {
                  $dataImported[] = $data[$i];
                }
            }

            foreach ($dataImported as $value)
            {         

                $cslug = str_slug($value['page_name'], '-');
                $slugcheck = Cms::where('slug','=',$cslug)->count();

                $slug="";

                if($slugcheck > 0 )
                {   
                    $slug = $cslug."_".($slugcheck-1);
                }
                else
                {
                    $slug = $cslug;
                }

                if($value['status'] == 'Active')
                {
                    $status = 1;
                } 
                else
                {
                    $status = 0;
                }

                if($value['meta_title'] == '')
                {
                    $metatitle = "";
                }
                else
                {
                    $metatitle = $value['meta_title'];
                }

                if($value['meta_description'] == '')
                {
                    $metadescription = "";
                }
                else
                {
                    $metadescription = $value['meta_description'];
                }

                if($value['meta_keyword'] == '')
                {
                    $metakeywords = "";
                }
                else
                {
                    $metakeywords = $value['meta_keyword'];
                }

                $cms = new Cms();
                $cms['name'] = $value['page_name'];
                $cms['title'] = $value['page_title'];
                $cms['slug'] = $slug;
                $cms['description'] = $value['page_details'];
                $cms['metatitle'] = $metatitle;
                $cms['metadescription'] = $metadescription;
                $cms['metakeywords'] = $metakeywords;
                $cms['tempcode'] = str_random(6);
                $cms['status'] = $status;
                $cms['company_id'] = get_company_id();
                $cms->save();


                $cmstrans = new CmsTranslations();
                $cmstrans['cmsid'] = $cms->id;
                $cmstrans['name'] = $value['page_name'];
                $cmstrans['title'] = $value['page_title'];
                $cmstrans['description'] = $value['page_details'];
                $cmstrans['metatitle'] = $request->metatitle;
                $cmstrans['metadescription'] = $request->metadescription;
                $cmstrans['metakeywords'] = $request->metakeywords;
                $cmstrans['langcode'] = get_defaultlanguage();
                $cmstrans['company_id'] = get_company_id();
                $cmstrans->save();

            }

        }
        return back();
    }

    public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

                        0 =>'name',
                        1 =>'title',
                        2 =>'date',
                        3 =>'status',
                        4 =>'action',
                         );
                    
        $totalData = Cms::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Cms::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Cms::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                           

                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Cms::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('title', 'LIKE',"%{$search}%")
                          
                             ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
            $etitle=CmsTranslations::where('cmsid',$post->id)->where('langcode',app()->getLocale() )->first()->title;
                
                $nestedData['name'] =$post->name;
                $nestedData['title'] =$etitle;
                $nestedData['date']= date('jS M Y',strtotime($post->created_at));
              
                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('admin/cms')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }                                       
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/cms')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                              
$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='cms/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

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


}
