<?php
namespace App\Http\Controllers;

use App\Category;
use App\Gallery;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Excel;
use Auth;
use App\SettingsTranslations;
use DB;
use App\ArchiveProduct;

class ProductController extends Controller
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
        $products = Product::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.productlist',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyid = get_company_id();
        $categories = Category::where('role','main')->where('status',1)->where('company_id',$companyid)->get();
        return view('admin.productadd',compact('categories'));
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
        $data = new Product();
        $data->fill($request->all());
        $data->category = $request->mainid.",".$request->subid.",".$request->childid;

        if ($file = $request->file('photo')){
            $photo_name = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/products',$photo_name);
            $data['feature_image'] = $photo_name;
        }

        if ($request->featured == 1){
            $data->featured = 1;
        }

        if ($request->status == ""){
            $data['status'] = 0;
        }
        else
        {
           $data['status'] = 1; 
        }

        if($request->offer_price == "")
        {
            $data['selling_price'] = $request->price;
        }
        else
        {
            $data['selling_price'] = $request->offer_price;
        }

        $data['slug'] = str_replace(' ','-',strtolower($request->title));
        $data['company_id'] = get_company_id();
        // $data['metatitle'] =$request->metatitle;
        // $data['metadec']=$request->metadec;
        // $data['metakey']=$request->metakey;


        // dd($data);

        $data->save();
        $lastid = $data->id;

        if ($files = $request->file('gallery')){
            foreach ($files as $file){
                $gallery = new Gallery;
                $image_name = str_random(2).time().$file->getClientOriginalName();
                $file->move('assets/images/gallery',$image_name);
                $gallery['image'] = $image_name;
                $gallery['productid'] = $lastid;
                $gallery->save();
            }
        }
        Session::flash('message', 'New Product Added Successfully.');
        return redirect('admin/products');
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
        $companyid = get_company_id();
        $product = Product::findOrFail($id);
        $child = Category::where('role','child')->where('status',1)->where('subid',$product->category[1])->get();
        $subs = Category::where('role','sub')->where('status',1)->where('mainid',$product->category[0])->get();
        $categories = Category::where('role','main')->where('status',1)->where('company_id',$companyid)->get();
        $gallary = Gallery::where('productid',$id)->get();
        return view('admin.productedit',compact('product','categories','child','subs','gallary'));
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
          
          // dd($request->all());
        $product = Product::findOrFail($id);
        $input = $request->all();
        // dd($input);
        $input['category'] = $request->mainid.",".$request->subid.",".$request->childid;

        if ($file = $request->file('photo')){
            $photo_name = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/products',$photo_name);
            $input['feature_image'] = $photo_name;
        }

        if ($request->galdel == 1){
            $gal = Gallery::where('productid',$id);
            $galllarydata = Gallery::where('productid',$id)->get();

            foreach($galllarydata as $allgal)
            {
                if($allgal->image != '')
                {
                    unlink('assets/images/gallery/'.$allgal->image);
                }
               
            }
           $gal->delete();
        }
        //die();

        if ($request->status == ""){
            $input['status'] = 0;
        }
        else
        {
           $input['status'] = 1; 
        }   

        if($request->offer_price == "")
        {
            $input['selling_price'] = $request->price;
        }
        else
        {
            $input['selling_price'] = $request->offer_price;
        }

        if ($request->featured == 1){
            $input['featured'] = 1;
        }else{
            $input['featured'] = 0;
        }

        $input['slug'] = str_replace(' ','-',strtolower($request->title));

        
      // dd($input);

        $product->update($input);

        if ($files = $request->file('gallery')){
            foreach ($files as $file){
                $gallery = new Gallery;
                $image_name = str_random(2).time().$file->getClientOriginalName();
                $file->move('assets/images/gallery',$image_name);
                $gallery['image'] = $image_name;
                $gallery['productid'] = $id;
                $gallery->save();
            }
        }

        Session::flash('message', 'Product Updated Successfully.');
        return redirect('admin/products');
    }

    public function status($subdomain,$id , $status)
    {
        $product = Product::findOrFail($id);
        $input['status'] = $status;

        $product->update($input);
        Session::flash('message', 'Product Status Updated Successfully.');
        return redirect('admin/products');
    }

    public function exist_skucode(Request $request){

        $id = $request->input('id');
        $companyid = get_company_id();

        if($id != '')
        {
            $title_exists = (count(\App\Product::where('id', '!=', $id)->where('company_id', '=', $companyid)->where('skucode', '=', $request->input('skucode'))->get())  > 0) ? false : true;
            return response()->json($title_exists);
        }
        else
        {
            $title_exists = (count(\App\Product::where('skucode', '=', $request->input('skucode'))->where('company_id', '=', $companyid)->get())  > 0) ? false : true;
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
        $product = Product::findOrFail($id);

            $data = new ArchiveProduct();
              $data['productid']=$product->id;  
              $data['owner']=$product->owner;
              $data['title']=$product->title;
              $data['slug']=$product->slug;
              $data['skucode']=$product->skucode;
              $data['category']=implode(",",$product->category);
              $data['description']=$product->description;
              $data['price']=$product->price;
              $data['offer_price']=$product->offer_price;
              $data['selling_price']=$product->selling_price;
              $data['stock']=$product->stock;
              $data['tax']=$product->tax;
              $data['shipping_cost']=$product->shipping_cost;
              $data['sizes']=$product->sizes;
              $data['feature_image']=$product->feature_image;
              $data['policy']=$product->policy;
              $data['tags']=$product->tags;
              $data['featured']=$product->featured;
              $data['views']=$product->views;
              $data['approved']=$product->approved;
              $data['status']=$product->status;
              $data['metatitle']=$product->metatitle;
              $data['metadec']=$product->metadec;
              $data['metakey']=$product->metakey;
              $data['metakey']=$product->metakey;
              $data['company_id']=$product->company_id;

            // dd($product,$data);
        $data->save();
           // dd($data);

        if($product->feature_image != '')
        {
            unlink('assets/images/products/'.$product->feature_image);
        }
        
        $product->delete();
        $gal = Gallery::where('productid',$id);
        $galllarydata = Gallery::where('productid',$id)->get();
        
        foreach($galllarydata as $allgal)
        {
            if($allgal->image != '')
            {
                unlink('assets/images/gallery/'.$allgal->image);
            }
           
        }
        
        $gal->delete();
        return redirect('admin/products')->with('message','Product Delete Successfully.');
    }

    public function deleteimage($subdomain,$id)
    {
        // dd('innnn');
        $product = Product::findOrFail($id); 

        if($product->feature_image != '')
        {
            unlink('assets/images/products/'.$product->feature_image);
        }
       
        $data['image'] = '';
        $updatedata = $product->update($data);
    }


      public function Exportdata()
    { 
        

         $companyid = get_company_id();
      
        $products = Product::where('company_id',$companyid)->orderBy('id','desc')->get();

    $d=count($products[0]->category);
          
         $productsArray = []; 

         $productsArray[] = ['Sr.NO','Product Name','SKU Code','Category','Current Product Image','Product Gallery Images','Product Description','Product Price','Product Offer Price','Product Stock','Product Buy/Return Policy','Product Tags','status'];
       $i = 1;
         foreach ($products as $alldata) 
         {
                       if($alldata->status == 1)
             {
                 $status = 'Active';
             }
             else if($alldata->status == 0)
             {
                 $status = 'Deactive';
             }
                 $mainid = Category::where('id',$alldata->category[0])->first()->name;
                   $child = Category::where('role','child')->where('status',1)->where('subid',$alldata->category[1])->first()->name;
                    
             $subs = Category::where('role','sub')->where('status',1)->where('mainid',$alldata->category[0])->first()->name;
                  $allcategory=$mainid.",". $subs.",".$child;
           

            $productsArray[] = array($i,$alldata->title,$alldata->skucode,$allcategory,$alldata->feature_image,$alldata->feature_image,$alldata->description,$alldata->price,$alldata->offer_price,$alldata->stock,$alldata->policy,$alldata->tags,$status);
            $i++;
        }   
        Excel::create('Products', function($excel) use ($productsArray) {

         // Set the spreadsheet title, creator, and description
             $excel->setTitle('Products List');
             $excel->setCreator('Laravel')->setCompany('Laravel');
             $excel->setDescription('Products List');

           // Build the spreadsheet, passing in the payments array
             $excel->sheet('sheet1', function($sheet) use ($productsArray) {
                $sheet->fromArray($productsArray, null, 'A1', false, false);
            });

     })->download('xlsx');
}





      public function import(Request $request)
    {

        // dd($request->all());
            $companyid = get_company_id();
             $prodectarray=array();

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

                   // dd($dataImported);

                foreach ($dataImported as $value)
                 {          

                        $title_exists = (count(\App\Product::where('skucode', '=',$value['sku_code'])->where('company_id', '=', $companyid)->get()) > 0) ? false : true;


                          if ($title_exists)
                           {
                                    

                                    $mainid=getcategoryprodect($value['main_category']); 


                                    $subid=getcategorysubprodect($value['sub_category'],$value['main_category']);


                                    $childid=getcategorychildprodect($value['child_category'],$subid,$mainid);



                                        $category=$mainid.",".$subid.",".$childid;

                                    if($value['product_price'] > $value['product_offer_price'])
                                    {
                                               $sallingprice=$value['product_price'];
                                    }
                                    else
                                    {
                                        if($value['product_offer_price'] == 0)
                                        {
                                        $sallingprice= $value['product_price'];
                                            
                                        }
                                        else
                                        {
                                            
                                         $sallingprice= $value['product_offer_price'];
                                        }
                                    }

                                    // dd($sallingprice);

                                        $stock=$value['product_stock'];
                                        $return=$value['product_buyreturn_policy'];
                                        $tag=$value['product_tags'];

                                    
                        
                        $role="";

                    $image=$value['current_product_image'];

                    // dd($image);
                    $imagegallery=$value['product_gallery_images'];

                        
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




                                      if($image != null)
                  {
                    $rand_imagname =str_random(6);
                      $url = $image;
                      $filename = $rand_imagname."_".substr($url, strrpos($url, '/') + 1); 
                      $data[] = $filename;
                    file_put_contents('assets/images/products/'.$filename, file_get_contents($url));


                        // dd($filename);

                      }
                      else
                      {
                        $image=null;
                      }

                        $product_gallery = explode(",",$value['product_gallery_images']);
                        
                         // dd(count($product_gallery));

                                   //   $sulg=str_slug($value['name'].'-');
                            // dd('innnn');
                           $productIN=DB::table('products')
                                ->insertGetId([
                                            'title'=>$value['product_name'],
                                            'slug'=>$value['product_name'],
                                            'skucode'=>$value['sku_code'],
                                            'category'=>$category,
                                            'description'=>$value['product_description'],
                                            'price'=>$value['product_price'],
                                            'offer_price'=>$value['product_offer_price'],
                                            'selling_price'=>$sallingprice,
                                            'stock'=>$stock,
                                            'tax'=>0,
                                            'shipping_cost'=>0,
                                            'sizes'=>null,
                                            'feature_image'=>$image,
                                            'policy'=>$return,
                                            'tags'=>$tag,
                                            'featured'=>$featured,
                                            'views'=>0,
                                            'approved'=>'yes',
                                            'created_at'=>date('Y-m-d h:i:s'),
                                            'status'=>$status,
                                            'company_id'=>$companyid,
                                            ]);
                                $data=array();
                            if($product_gallery  != '' )
                            {

                                foreach ($product_gallery as $imagevalue)
                                 {
                                  
                                  $rand_imagname = str_random(6);
                            $url = $imagevalue;
                              $file_name = $rand_imagname."_".substr($url, strrpos($url, '/') + 1); 
                                $data[] = $file_name;
              file_put_contents('assets/images/gallery/'.$file_name,file_get_contents($url));
                                
                                      DB::table('product_gallery')
                                          ->insert([
                                                    'productid'=>$productIN,
                                                    'image'=>$file_name
                                                      ]);
                                        }
                                    }

                           $prodectarray[]=array('product'=>$value['product_name'],
                                              'status'=>'YES');             

                      }
                          else
                          { 
                             $prodectarray[]=array('product'=>$value['product_name'],
                                              'status'=>'NO');  
                            continue;

                          }            

                 }
              

        
        } 
    
        // dd($allarrye);

    
         return view('admin.prodectimport',compact('prodectarray'));
        // return back()->with('message','New Product Added Successfully');
        
                 // echo $allarrye;
       // redirect()->back()->with('message', $allarrye);

  }



  public function allPosts(Request $request)
  {   
    $companyid = get_company_id();
      
    $columns = array( 
                      0 =>'title',
                      1 =>'price',
                      2 =>'category',
                      3 =>'stock',
                      4 =>'status',
                      5 =>'action',
                       );

    $totalData = Product::where('company_id',$companyid)->count();
          
    $totalFiltered = $totalData; 

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if(empty($request->input('search.value')))
    {            
      $posts = Product::where('company_id',$companyid)
                  ->offset($start)
                   ->limit($limit)
                   ->orderBy($order,$dir)
                   ->get();
    }
    else {
      $search = $request->input('search.value'); 
      
      $posts =  Product::where('company_id',$companyid)
                      ->where('id','LIKE',"%{$search}%")
                      ->orWhere('title', 'LIKE',"%{$search}%")
                      ->offset($start)
                      ->limit($limit)
                      ->orderBy($order,$dir)
                      ->get();


      $totalFiltered = Product::where('company_id',$companyid)
                      ->orwhere('id','LIKE',"%{$search}%")
                       ->orWhere('title', 'LIKE',"%{$search}%")
                       ->count();
                   // dd($totalFiltered);
    }
 
    $data = array();
    if(!empty($posts))
    { 
      $i=1;
      $langcode= get_defaultlanguage();
      $settings=SettingsTranslations::where('company_id',$companyid)->where('langcode',$langcode)
              ->get();
      foreach ($posts as $post)
      {
          // pr($post); die;
        if($post->offer_price != '' && $post->offer_price != 0)
        {    
          $price="<strike>".$settings[0]->currency_sign.$post->price."</strike><br/>".$settings[0]->currency_sign.$post->offer_price;
        }
        else
        {
          $price=$settings[0]->currency_sign.$post->price;                           
        }

        $prodect1=\App\Category::where('id',$post->category[0])->first()->name."<br>";
        if($post->category[1] != "")
        {
          $prodect2=\App\Category::where('id',$post->category[1])->first()->name."<br>";
        }
        if($post->category[2] != "")
        {
          $prodect3=\App\Category::where('id',$post->category[2])->first()->name;
        }
                                    
        $nestedData['title'] =$post->title;
        $nestedData['price'] =$price;
        $nestedData['category']=$prodect1.$prodect2.$prodect3;

        if($post->stock != 0)
        {
          $nestedData['stock']="<span style='color:green'>"."<b>In Stock (".$post->stock.")</b></span>";
        }
        else
        {
          $nestedData['stock']="<span style='color:red'>"."Out Of Stock</span>";

        }
        if($post->status == 1)
        {
          $nestedData['status'] = "<a href='".url("admin/products")."/status/".$post->id."/0'class='"."btn btn-success btn-xs'>Active</a>";
        }                   
        elseif($post->status == 0)
        {
          $nestedData['status'] = "<a href='".url("admin/products")."/status/".$post->id."/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
        }
        $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='products/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

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

    echo json_encode($json_data,JSON_UNESCAPED_UNICODE );    
      
  }   


}
