<?php

namespace App\Http\Controllers;

use App\News;
use App\NewsTranslations;
use DB;
use App\SectionTitles;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Excel;
use Illuminate\Support\Str;

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
        return view('admin.newslist',compact('news','titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.newsadd');
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

        $cslug = Str::slug($request->newstitle, '-');
        $slugcheck = News::where('slug','=',$cslug)->count();

        $slug="";
        if($slugcheck > 0 )
        {   
            $slug = $cslug."_".($slugcheck-1);
        }
        else
        {
            $slug = $cslug;
        }

        if ($request->status == "")
        {
            $news['status'] = 0;
        }
        else
        {
            $news['status'] = 1;
        }

        $news['slug'] = $slug;      
        $news['company_id'] = get_company_id();

        $news->save();

        $newstrans = new NewsTranslations();
        $newstrans['newsid'] = $news->id;
        $newstrans['newstitle'] = $request->newstitle;
        $newstrans['content'] = $request->content;
        $newstrans['langcode'] = $request->default_langcode;
        $newstrans['company_id'] = get_company_id();
        $newstrans->save();

            if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {
            $newsalltrans = new NewsTranslations();
            $newsalltrans['newsid'] = $news->id;
            $newsalltrans['newstitle'] = $request->trans_newstitle[$data];
            $newsalltrans['content'] = $request->trans_content[$data];
            $newsalltrans['langcode'] = $transdata;
            $newsalltrans['company_id'] = get_company_id();
            $newsalltrans->save();    
        }
    }

        return redirect('admin/news')->with('message',trans("app.NewsAddMsg"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
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
        $news = News::findOrFail($id);
        return view('admin.newsedit',compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        $news = News::findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('newsimage')){
            $photo_name = str_random(3).$request->file('newsimage')->getClientOriginalName();
            $file->move('assets/images/news',$photo_name);
            $data['newsimage'] = $photo_name;

            if($news->newsimage != '')
            {
                unlink('assets/images/news/'.$news->newsimage);
            }
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

        $newsdeflang_exists = NewsTranslations::where('langcode', '=', $request->default_langcode)->where('newsid', '=', $id)->first();

        if($newsdeflang_exists != null)
        {
            NewsTranslations::where('langcode', '=', $request->default_langcode)->where('newsid', '=', $id)->update(['newstitle' => $request->newstitle, 'content' => $request->content]);
        }
        else
        {
            $newstrans = new NewsTranslations();
            $newstrans['newsid'] = $id;
            $newstrans['newstitle'] = $request->newstitle;
            $newstrans['content'] = $request->content;
            $newstrans['langcode'] = $request->default_langcode;
            $newstrans['company_id'] = get_company_id();
            $newstrans->save();
        }
        
        //dd($request);

            if($request->langcode != null)
        {
        foreach($request->langcode as $data => $transdata)
        {
            $newslang_exists = NewsTranslations::where('langcode', '=', $transdata)->where('newsid', '=', $id)->first();
            if($newslang_exists != null)
            {

                NewsTranslations::where('langcode', '=', $transdata)->where('newsid', '=', $id)->update(['newstitle' => $request->trans_newstitle[$data], 'content' => $request->trans_content[$data]]);
            }
            else
            {

                $newsalltrans = new NewsTranslations();
                $newsalltrans['newsid'] = $id;
                $newsalltrans['newstitle'] = $request->trans_newstitle[$data];
                $newsalltrans['content'] = $request->trans_content[$data];
                $newsalltrans['langcode'] = $transdata;
                $newsalltrans['company_id'] = get_company_id();
                $newsalltrans->save();
            }
            
        }
    }

        return redirect('admin/news')->with('message',trans("app.NewsUpdateMsg"));
    }

    public function status($subdomain,$id , $status)
    {
        $news = News::findOrFail($id);
        $input['status'] = $status;

        $news->update($input);
        return redirect('admin/news')->with('message',trans("app.NewsStatusUpdateMsg"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        $news = News::findOrFail($id);

        if($news->newsimage != '')
        {
            unlink('assets/images/news/'.$news->newsimage);
        }

        $news->delete();

        $newstrans = NewsTranslations::where('newsid',$id);
        $newstrans->delete();

        return redirect('admin/news')->with('message',trans("app.NewsDeleteMsg"));
    }


    public function deleteimage(Request $request , $subdomain ,$id )
    {
        // dd('innnnnnnnnnn');

        $news = News::findOrFail($id); 
       
        if($news->newsimage != '')
        {
            unlink('assets/images/news/'.$news->newsimage);
        }
       
        $data['newsimage'] = '';
        $updatedata = $news->update($data);
    }


    public function Exportdata()
    { 
        $companyid = get_company_id();
            
        $news = News::where('company_id',$companyid)->orderBy('id','desc')->get();
     
        $newsArray = []; 

        $newsArray[] = ['Sr.NO','News Title','Featured Image','News Details','News Date','status'];
        $i = 1;

        foreach ($news as $alldata) 
        {
            if($alldata->status == 1)
            {
                $status = 'Active';
            }
            else if($alldata->status == 0)
            {
                $status = 'Deactive';
            }
            $date=$alldata->created_at->format('jS M Y');
            
            $newstitle = '';
            $content = '';

            $newstrans = NewsTranslations::where('newsid',$alldata->id)->where('langcode',get_defaultlanguage())->first();

            if($newstrans != null)
            {
                $newstitle = $newstrans->newstitle;
                $content = $newstrans->content;
            }

            $newsArray[]= array($i,$newstitle,$alldata->newsimage,$content,$date,$status);
            $i++;
        }   
        Excel::create('News', function($excel) use ($newsArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('News List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('News List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($newsArray) {
                $sheet->fromArray($newsArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }

    public function import(Request $request)
    {
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


                // if($value['news_date'] != "")
                // {
                //     $$newsdate=
                // }    

                $newsdate=date('Y-m-d',strtotime($value['news_date']));

                $cslug = Str::slug($value['news_title'], '-');
                $slugcheck = News::where('slug','=',$cslug)->count();

                $slug="";
                if($slugcheck > 0 )
                {   
                    $slug = $cslug."_".($slugcheck-1);
                }
                else
                {
                    $slug = $cslug;
                }

                $image=$value['featured_image'];

                if($value['status'] == 'Active')
                {
                    $status=1;
                } 
                else
                {
                    $status=0;
                }

                $news = new News();
                $news['newstitle'] = $value['news_title'];
                $news['content'] = $value['news_details'];
                $news['newsimage'] = $image;
                $news['tempcode'] = str_random(6);
                $news['slug'] = $slug;
                $news['status'] = $status;
                $news['company_id'] = $companyid;
                $news->save(); 

                $newstrans = new NewsTranslations();
                $newstrans['newsid'] = $news->id;
                $newstrans['newstitle'] = $value['news_title'];;
                $newstrans['content'] = $value['news_details'];;
                $newstrans['langcode'] = get_defaultlanguage();
                $newstrans['company_id'] = get_company_id();
                $newstrans->save();

            }

        }
        return back();
    }

    public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                          
                        0 =>'newsimage',
                        1 =>'newstitle',
                        2 =>'created_at',
                        3 =>'status',
                        4 =>'action',
                         );
  
        $totalData = News::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = News::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            // $posts =  News::where('company_id',$companyid)
            //                 ->where('id','LIKE',"%{$search}%")
            //                 ->orWhere('eventname', 'LIKE',"%{$search}%")
            //                 ->offset($start)
            //                 ->limit($limit)
            //                 ->orderBy($order,$dir)
            //                 ->get();

                             $posts =  News::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('newstitle', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")

                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = News::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('newstitle', 'LIKE',"%{$search}%")
                            ->orWhere('created_at', 'LIKE',"%{$search}%")
                             ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {

            // $etitle=NewsTranslations::where('newsid',$post->id)->where('langcode',app()->getLocale() )->first()->newstitle;

             if($post->newsimage != '')
            {
        $image= "<img style='width: 300px;height: 100px;' src='".url("/")."/assets/images/news/".$post->newsimage."'>";
              }
               else
               {      
        $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='width: 300px;height: 100px;'>";
              }

                $nestedData['newsimage'] =$image;
                $nestedData['newstitle'] =$post->newstitle;
                $nestedData['created_at']= date('jS M Y',strtotime($post->created_at));

                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('admin/news')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }                                       
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/news')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                              
$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='news/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

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
