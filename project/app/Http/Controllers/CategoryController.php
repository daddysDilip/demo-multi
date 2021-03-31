<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryTranslations;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Product;
use Auth;
use DB;
use Excel;
use App\ArchiveCategory;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        return view('admin.categoryadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $category = new Category;
        $category->fill($request->all());
        $category['role'] = "main";

        if ($request->featured == 1)
        {
            $category->featured = 1;
            if ($file = $request->file('fimage'))
            {
                $photo_name = time().$request->file('fimage')->getClientOriginalName();
                $file->move('assets/images/categories',$photo_name);
                $category['feature_image'] = $photo_name;
            }
        }
        else
        {
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
   
        return redirect('admin/categories')->with('message', trans("app.CategoryAddMsg"));

    }

    public function storemain(Request $request)
    {
       
        // dd('innnn',$request->all());
        $category = new Category;
        $category->fill($request->all());
        $category['role'] = "main";

        if ($request->featured == 1)
        {
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
        // Session::flash('message', 'New Category Added Successfully.');

        return redirect()->back();
            // dd('category mathi');
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
        $category = Category::findOrFail($id);
        return view('admin.categoryedit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain, $id)
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

        return redirect('admin/categories')->with('message', trans("app.CategoryUpdateMsg"));
    }

    public function status($subdomain, $id, $status)
    {
        $category = Category::findOrFail($id);
        $input['status'] = $status;

        $category->update($input);
        // echo $status;
        //     die();
        return redirect('admin/categories')->with('message', trans("app.CategoryStatusUpdateMsg"));
    }

    public function exist_category(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $name_exists = ((\App\Category::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('name', '=', $request->input('name'))->get()) != null) ? false : true;
            return response()->json($name_exists);
        }
        else
        {
            $name_exists = ((\App\Category::where('name', '=', $request->input('name'))->where('company_id', '=', $companyid)->get()) != null) ? false : true;
            return response()->json($name_exists);
        }  
    }

    public function exist_slug(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $slug_exists = ((\App\Category::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('slug', '=', $request->input('slug'))->get()) != null) ? false : true;
            return response()->json($slug_exists);
        }
        else
        {
            $slug_exists = ((\App\Category::where('slug', '=', $request->input('slug'))->where('company_id', '=', $companyid)->get()) != null) ? false : true;
            return response()->json($slug_exists);
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
      // dd('Destroy walu prodect');

        $category = Category::findOrFail($id);
        $category->delete();
        Session::flash('message', 'Category Deleted Successfully.');
        return redirect('admin/categories');
    }

 //Delete All Category and Its Details
    public function delete($subdomain,$id)
    {
        $category = Category::findOrFail($id);

      // dd('delete walu teable',$category);

        $subcategory = Category::where('mainid',$category->id);


                    $oldcategory = new ArchiveCategory;

                    $oldcategory['categoryId']=$category->id;
                    $oldcategory['mainid']=$category->mainid;
                    $oldcategory['subid']=$category->subid;
                    $oldcategory['role']=$category->role;
                    $oldcategory['name']=$category->name;
                    $oldcategory['slug']=$category->slug;
                    $oldcategory['feature_image']=$category->feature_image;
                    $oldcategory['featured']=$category->featured;
                    $oldcategory['status']=$category->status;
                    $oldcategory['metatitle']=$category->metatitle;
                    $oldcategory['metadec']=$category->metadec;
                    $oldcategory['metakey']=$category->metakey;
                    $oldcategory['views']=$category->views;
                    $oldcategory['company_id']=$category->company_id;  

               $oldcategory->save();

               dd($oldcategory);
                    
        
        $subcategory->delete();

        if($category->role == "sub"){
            $subchcategory = Category::where('subid',$category->id);
              $oldcategory = new ArchiveCategory;

                    $oldcategory['categoryId']=$subchcategory->id;
                    $oldcategory['mainid']=$subchcategory->mainid;
                    $oldcategory['subid']=$subchcategory->subid;
                    $oldcategory['role']=$subchcategory->role;
                    $oldcategory['name']=$subchcategory->name;
                    $oldcategory['slug']=$subchcategory->slug;
                    $oldcategory['feature_image']=$subchcategory->feature_image;
                    $oldcategory['featured']=$subchcategory->featured;
                    $oldcategory['status']=$subchcategory->status;
                    $oldcategory['metatitle']=$subchcategory->metatitle;
                    $oldcategory['metadec']=$subchcategory->metadec;
                    $oldcategory['metakey']=$subchcategory->metakey;
                    $oldcategory['views']=$subchcategory->views;
                    $oldcategory['company_id']=$subchcategory->company_id;  

               $oldcategory->save();
            $subchcategory->delete();
        }

        $childcategory = Category::where('mainid',$category->id);
        $oldcategory = new ArchiveCategory;

                    $oldcategory['categoryId']=$childcategory->id;
                    $oldcategory['mainid']=$childcategory->mainid;
                    $oldcategory['subid']=$childcategory->subid;
                    $oldcategory['role']=$childcategory->role;
                    $oldcategory['name']=$childcategory->name;
                    $oldcategory['slug']=$childcategory->slug;
                    $oldcategory['feature_image']=$childcategory->feature_image;
                    $oldcategory['featured']=$childcategory->featured;
                    $oldcategory['status']=$childcategory->status;
                    $oldcategory['metatitle']=$childcategory->metatitle;
                    $oldcategory['metadec']=$childcategory->metadec;
                    $oldcategory['metakey']=$childcategory->metakey;
                    $oldcategory['views']=$childcategory->views;
                    $oldcategory['company_id']=$childcategory->company_id;  

               $oldcategory->save();
        $childcategory->delete();

        $products = Product::whereRaw('FIND_IN_SET(?,category)', [$category->id]);
         $oldcategory = new ArchiveCategory;
                    


                    $oldcategory['categoryId']=$products->id;
                    $oldcategory['mainid']=$products->mainid;
                    $oldcategory['subid']=$products->subid;
                    $oldcategory['role']=$products->role;
                    $oldcategory['name']=$products->name;
                    $oldcategory['slug']=$products->slug;
                    $oldcategory['feature_image']=$products->feature_image;
                    $oldcategory['featured']=$products->featured;
                    $oldcategory['status']=$products->status;
                    $oldcategory['metatitle']=$products->metatitle;
                    $oldcategory['metadec']=$products->metadec;
                    $oldcategory['metakey']=$products->metakey;
                    $oldcategory['views']=$products->views;
                    $oldcategory['company_id']=$products->company_id;  
                    $oldcategory->save();
                 $products->delete();

        $category->delete();
        Session::flash('message', 'Category Deleted Successfully.');
        return redirect('admin/categories');
    }


     public function deleteimage(Request $request , $subdomain ,$id )
    {
            // dd(' jiGAGAGAGAAG');


        $category = Category::findOrFail($id); 
       
        if($category->feature_image != '')
        {
            unlink('assets/images/categories/'.$category->feature_image);
        }
       
        $data['feature_image'] = '';
        $updatedata = $category->update($data);
    }   




    public function Exportdata()
    { 
            // dd('innn Category');

         $companyid = get_company_id();


            $category=Category::where('company_id',$companyid)->get();

            // dd($category);

               // $child = Category::where('role','child')->where('company_id',$companyid)->orderBy('id','desc')->get();
        // $subs = Category::where('role','sub')->where('company_id',$companyid)->orderBy('id','desc')->get();
        // $categories = Category::where('role','main')->where('company_id',$companyid)->orderBy('id','desc')->get();
         
            // $event = Event::where('company_id',$companyid)->orderBy('id','desc')->get();

          // dd($category);
   
               $categorymain=Category::where('id',2)->first()->name;
        
         $categoryArray = []; 

         $categoryArray[] = ['Sr.NO','Name','main Category','Sub Category','Role','Category URL Slug','Featured','Featured Image','status'];
       $i = 1;
         foreach ($category as $alldata) 
         {
                       if($alldata->status == 1)
             {
                 $status = 'Active';
             }
             else if($alldata->status == 0)
             {
                 $status = 'Deactive';
             }  

                if($alldata->featured == 1)
                {
                    $featured='YES';
                }
                else 
                {
                    $featured="NO";
                }


            
                if(!empty($alldata->mainid ))
                {
                    
                     // $category = Category::findOrFail($alldata->mainid);
                        $demo=getcategory($alldata->mainid);

                     // $demo=$category[0]->name;

              
             
                }
                else 
                {
                 $demo="0";
                }
                
                if(!empty($alldata->subid))
                {
                    // dd($alldata->subid);
             
                    $demo1= getcategory($alldata->subid);
                
                }
                else
                {
               $demo1= '0';
                }
            $categoryArray[]= array($i,$alldata->name,$demo,$demo1,$alldata->role,$alldata->slug,$featured,$alldata->feature_image,$status);
            $i++;
        }
           
        Excel::create('Category', function($excel) use ($categoryArray) {

         // Set the spreadsheet title, creator, and description
             $excel->setTitle('Category List');
             $excel->setCreator('Laravel')->setCompany('Laravel');
             $excel->setDescription('Category List');

           // Build the spreadsheet, passing in the payments array
             $excel->sheet('sheet1', function($sheet) use ($categoryArray) {
                $sheet->fromArray($categoryArray, null, 'A1', false, false);
            });

     })->download('xlsx');
}

         public function import(Request $request)
    {

        // dd($request->all());
            $companyid = get_company_id();
             $allarrye="";

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

                          $name_exists = ((\App\Category::where('name', '=', $value['name'])->where('company_id', '=', $companyid)->get()) != null) ? false : true;


                          if ($name_exists)
                           {
                                    
                        
                        $role="";

                    if($value['main_category'] == '0'  &&  $value['sub_category'] == '0' )
                    {

                             $mainid=null;
                             $subnid=null;
                             $role="main";
                     }
                   else if($value['main_category'] != '0'  &&  $value['sub_category'] == '0' )
                    {

                             $mainid=getcategoryname($value['main_category']);
                             $subnid=null;
                             $role="sub";
                 

                    }
                    else if($value['main_category'] != '0'  &&  $value['sub_category'] != '0' )
                    {

                             $mainid=getcategoryname($value['main_category']);
                            $subnid=getcategoryname($value['sub_category']);
                             $role="child";
                    }  
                    $image=$value['featured_image'];

                        
                                      if($value['featured'] == 'YES')
                                        {
                                            $featured=1;
                                        } 
                                        else
                                        {
                                            $featured=0;
                                        }




                                   if($value['status'] == 'Active')
                                        {
                                            $status=1;
                                        } 
                                        else
                                        {
                                            $status=0;
                                        }

                                     $sulg=Str::slug($value['name'].'-');

                            DB::table('categories')
                                ->insert([
                                            'mainid'=>$mainid,
                                            'subid'=>$subnid,
                                            'role'=>$role,
                                            'name'=>$value['name'],
                                            'slug'=>$value['category_url_slug'],
                                            'feature_image'=>$image,
                                            'featured'=>$featured,
                                            'status'=>$status,
                                            'company_id'=>$companyid,
                                            ]);

                      }
                          else
                          { 

                            $allarrye.=$value['name'].',';
                            continue;

                          }            

                 }
              

        
        }
                 // echo $allarrye;
        return back()->with('message','This Category Is Already exist'.$allarrye);
       // redirect()->back()->with('message', $allarrye);

  }




    public function allpostsmain(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                           
                        0 =>'name',
                        1 =>'slug',
                        2 =>'status',
                        3 =>'action',
                         );

          $totalData = Category::where('role','main')->where('company_id',$companyid)->orderBy('id','desc')->get();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // dd($limit,$start,$order,$dir,$totalData);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Category::where('role','main')
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

            $posts =  Category::where('role','main')
                            ->where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Category::where('role','main')
                            ->where('company_id',$companyid)
                            ->where('role','main')
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
                         // dd($totalFiltered);
        }
        // dd($posts);
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
                                                          
                $nestedData['name'] =$post->name;
                $nestedData['slug'] =$post->slug;

                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('admin/blog')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }                                        
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/blog')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                     
            
$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='blog/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";


                $data[] = $nestedData;
                $i++;
            }
        }         

        // dd($data); 
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
