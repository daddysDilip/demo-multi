<?php 
if (!function_exists('human_file_size')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */

    function get_company_id()
    {
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); //creates the various parts
        $subdomain_name = $subdomain_arr[0];

        $company = DB::table('admin')->where('username',$subdomain_name)->get();
        
        if(count($company) > 0){
            return $company[0]->company_id;
        }
        else
        {
            return 0;
        }
    }

    function get_time_difference($date1, $date2 = "", $is_exp = false)
{
    if ($date2 == "") {
        $date2 = date("Y-m-d");
    }
    $diff  = date_diff(date_create($date1), date_create($date2));
    $year  = $diff->format("%y");
    $month = $diff->format("%m");
    $days  = $diff->format("%d");
    if ($year >= 1 && $year < 5) {
        if($month == 0){
            $res = $year . " Year(s) ";
        } else {
            $frection = floor(10*$month/12);
            $res = $year . ".". $frection ." Year(s) ";
        }
    } else if ($year >= 5) {
        $res = $year . " Year(s) ";
    } else if ($month >= 1) {
        $res = $month . " Month(s) ";
    } else if ($days >= 1) {
        $res = $days . " Day(s) ";
    } else {
        if ($is_exp)
            $res = false;
        else
            $res = "0 Day";
    }
    return $res;
}



    function get_active_company()
    {
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); //creates the various parts
        $subdomain_name = $subdomain_arr[0];

        $company = DB::table('admin')->where('username',$subdomain_name)->where('status',1)->get();
        if(count($company) > 0)
        {
            return 'active';
        }
        else
        {
            return 'deactive';
        }
    }



    function get_subdomain()
    {
        $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2); //creates the various parts
        $subdomain_name = $subdomain_arr[0];
        return $subdomain_name;
    }



    function get_plan_productlimit()
    {
        $companyid=get_company_id();

        if($companyid!=NULL)
        {
            $company = DB::table('company')->where('id',$companyid)->get();
            
            if(!empty($company[0]->planid)){
                $plan = DB::table('plans')->select('product_limit')->where('id',$company[0]->planid)->get();
            }

            if(!empty($plan[0]->product_limit)){
                return $plan[0]->product_limit;
            }else{
                return "0";
            }
        }
    }

    function get_userdata($id)
    {  
        $user = DB::table('admin')->where('id',$id)->get();
        return $user; 
    }

    function get_productdetail($id)
    {  
        $product = DB::table('products')->where('id',$id)->get();
        return $product; 
    }

    function get_quantity($id)
    {  
        $product = DB::table('products')->where('id',$id)->get();
        return $product[0]->stock; 
    }

	function get_theme_name()
    {
		$companyid=get_company_id();
		$themename ='';
		if($companyid!=NULL)
        {
			$settings = DB::table('settings')->where('company_id',$companyid)->pluck('theme');
			 
		    $themeid=$settings[0];
		    if($themeid > 0){
			   
			    $theme = DB::table('themes')->where('id',$themeid)->pluck('foldername');
			    if( $theme ) 
                {
                    if($theme[0] != '')
                    {
				        $themename =$theme[0].'.'; 
                    } 
                    else 
                    {
                        $themename = $theme[0];
                    }  
			    }
		    }	
		}
		return $themename ;
	}

    function get_sadmin_user_id()
    {
        $user = DB::table('admin')->where('company_id',0)->get();
        return $user;
    }

    function get_user_id()
    {
        $companyid = get_company_id();
        if($user = Auth::user())
        {
            $roleid = $user->role;
            $id = $user->id;
            $username = $user->username;
        }
        else
        {
            $roleid = '0';
            $username = '';
        }

        if($username == 'superadmin')
        {   
            $userrole = DB::table('admin')->where('company_id',$companyid)->get();
            $admindetail = DB::table('admin')->where('role',$userrole[0]->role)->first();
            return $admindetail->id;
        }
        else
        {
            $admindetail = DB::table('admin')->where('id',$id)->first();
            return $admindetail->id;
        }
    }

    function get_user_role_id()
    {
        $userid = get_user_id(); 
        $companyid = get_company_id(); 
        
        $user = DB::table('admin')->where('id',$userid)->where('company_id',$companyid)->first();

        return $user->role;
    }

    function get_ticket_files($id)
    {
        $ticketfiles = DB::table('ticketfiles')->where('replyid',$id)->get();
        return $ticketfiles;
    }

    function has_permission($menuname)
    {
        $userid = get_user_id(); 
        $companyid = get_company_id(); 

        $user = DB::table('admin')->where('id',$userid)->where('company_id',$companyid)->first();

        $menu = DB::table('menus')->where('name',$menuname)->where('status',1)->where('company_id',$companyid)->first();
        if(!empty($menu))
        {
            $menu_permission = DB::table('permissions')->select('roleid')->where('menuid',$menu->id)->where('roleid',$user->role)->where('company_id',$companyid)->get(); 
            if(count($menu_permission) > 0)
            {
                return true;
            }
            else
            {

                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function get_country_name($id)
    {
        $country = DB::table('countries')->where('id',$id)->first();
        if($country)
        {
            return $country->countryname;
        }
        else
        {
            return null;
        }
    }

    function get_state_name($id)
    {
        $country = DB::table('states')->where('id',$id)->first();
        if($country)
        {
            return $country->statename;
        }
        else
        {
            return null;
        }
    }

    function get_city_name($id)
    {
        $country = DB::table('cities')->where('id',$id)->first();
        if($country)
        {
            return $country->cityname;
        }
        else
        {
            return null;
        }
    }

    function get_main($id)
    {
        // $demo=Product::where('status','1')->whereRaw('FIND_IN_SET(?,category)', [$id])->count();

        $demo=DB::table('products')
                   ->whereRaw('FIND_IN_SET(?,category)', [$id])
                   ->count();    
        return $demo;
    }


    function get_defaultlanguage()
    {
        $companyid = get_company_id(); 
        $company = DB::table('company')->where('id',$companyid)->first();

        if($company)
        {
            if($company->default_language != '')
            {
                return $company->default_language;
            }
            else
            {
                return 'en';
            }
            
        }
        else
        {
            return 'en';
        }
    }

    function get_language_direction()
    {
        //echo Request::segment(1);
        $storeval = Request::segment(1);

        if($storeval == 'admin')
        {
            $langcode  = get_defaultlanguage();
        }
        else
        {
            if(Session::has('locale'))
            {
                $langcode  = Session::get('locale');
            }
            else
            {
                $langcode  = get_defaultlanguage();
            }
        }
    
        $language = DB::table('language')->where('code',$langcode)->first();

        $direction = 'left';

        if($language)
        {
            $direction = $language->direction;
            
        }
        
        return $direction;
        
    }
    
    function get_language_name($code)
    {
        $language = DB::table('language')->where('code',$code)->first();

        $langname = '';

        if($language)
        {
            $langname = $language->name;
            
        }
        return $langname;
    }

    
    function getcategory($id)
{
        $namecategory=DB::table('categories')
                ->where('id',$id->id)->first()->name;

        // dd($namecategory);
                return $namecategory;

    }


    function getcategoryname($id)
    {
           
                  $demo =DB::table('categories')
                        ->where('name',$id)
                        ->first()->id;

                       return $demo;

    }


    function getcategoryprodect($id)
    {
           // dd($id);
        $companyid = get_company_id();
        $demo1="";
                  $demo =DB::table('categories')
                        ->where('name',$id)
                        ->count();


                        if($demo == 0)
                        {
                            // dd('nathi a category');


                               $demo1= DB::table('categories')
                                    ->insertGetId([
                                                     'mainid'=>null,
                                                     "subid"=>null,
                                                     "role"=>'main',
                                                     "name"=>$id,
                                                     "slug"=>$id,
                                                     "feature_image"=>null,
                                                     "featured"=>1,
                                                     'company_id'=>$companyid

                                                    ]);
                        }
                        else
                        {
                            $demo1=DB::table('categories')
                            ->where('name',$id)
                            ->first()->id;
                        }

                       return $demo1;

    }

    function getcategorysubprodect($id,$id1)
    {
                // dd($id,$id1);

                     $companyid = get_company_id();

                     $submain="";

                    $subcount=DB::table('categories')
                            ->where('name',$id)
                            ->count();

                            if($subcount == 0)
                            {
                                   $mainid=DB::table('categories')
                                        ->where('name',$id1)
                                        ->first()->id;


                                       $submain=DB::table('categories')
                                            ->insertGetId([
                                                    'mainid'=>$mainid,
                                                     "subid"=>null,
                                                     "role"=>'sub',
                                                     "name"=>$id,
                                                     "slug"=>$id,
                                                     "feature_image"=>null,
                                                     "featured"=>1,
                                                     'company_id'=>$companyid  

                                                            ]);
                             }
                             else
                             {
                                 $submain=DB::table('categories')
                                 ->where('name',$id)
                                 ->first()->id;
                             }
                               return $submain;
    }


    function getcategorychildprodect($id,$id1,$id2)
    {
				$companyid = get_company_id();

                    $childmain="";

                    $childcount=DB::table('categories')
                            ->where('name',$id)
                            ->count();


                                if($childcount == 0)
                                {

                                $childmain=DB::table('categories')->insertGetId
												([
                                                    'mainid'=>$id2,
                                                     "subid"=>$id1,
                                                     "role"=>'child',
                                                     "name"=>$id,
                                                     "slug"=>$id,
                                                     "feature_image"=>null,
                                                     "featured"=>1,
                                                     'company_id'=>$companyid  
													]);
								}
                                else
                                {

                                     $childmain=DB::table('categories')
                                        ->where('name',$id)
                                            ->first()->id;

                                }
                              return $childmain;  


    }




    function prodectlink($id)
    {

          $product=DB::table('products')
                   ->where('id',$id)
                   ->first(); 
   

                   if($product != "")
                   {

           $prodect=url('/product')."/".$product->id."/".$product->slug;
                   }
                   else
                   {
                    $prodect="#";
                   }

            // dd($product,$prodect);
              return $prodect; 
    

    }
	
	function total_rows($table, $where = array())

	{
		 $companyid=get_company_id();
		if (is_array($where)) {
		   if (sizeof($where) > 0) {
				//$CI->db->where($where);
				return DB::table($table)->where($where)->count();
			}
		} else if (strlen($where) > 0) {

			
			return DB::table($table)->where($where)->count();

		}

		return DB::table($table)->count();
		//return $CI->db->count_all_results($table);



	}
	
	function get_front_menu()
	{  
	$companyid=get_company_id();
    $navigation = DB::table('navigation')->where('parent_id',0)->where('company_id',$companyid)->get();
	
	$result =array();
    if($navigation != null){
		
		$i=0;
	foreach($navigation as $row){
			$result[$i]=$row;
			$result[$i]->sub=get_children_menu($row->id);
		$i++;	
		}
	}
		//dd($result);
		return $result;
    }

	function get_children_menu($id)
	{  
		 $companyid=get_company_id();
		$sub_navigation = DB::table('navigation')->where('parent_id',$id)->where('company_id',$companyid)->get(); 
		
		$result =array();
		if($sub_navigation != null){
			
			$i=0;
		foreach($sub_navigation as $sub_row){
				
			$result[$i]=$sub_row;
			$child_navigation = DB::table('navigation')->where('parent_id',$sub_row->id)->where('company_id',$companyid)->get(); 
			$child_navigation = $child_navigation->toArray();
				$result[$i]->child=$child_navigation;
			$i++;	
			}
		}
			
			return $result;
	   // return $query->result();
	}
   
    function get_cat_front_menu()
	{  
	$companyid=get_company_id();
    $main_cat = DB::table('categories')->where('status',1)->where('company_id',$companyid)->where('role','main')->get();
	
	$result =array();
    if($main_cat != null){
		
		$i=0;
	foreach($main_cat as $row){
			$result[$i]=$row;
			$result[$i]->sub=get_cat_children_menu($row->id);
		$i++;	
		}
	}
		//dd($result);
		return $result;
    }

	function get_cat_children_menu($id)
	{  
		 $companyid=get_company_id();
		$sub_cat = DB::table('categories')->where('status',1)->where('mainid',$id)->where('role','sub')->get(); 
		
		$result =array();
		if($sub_cat != null){
			
			$i=0;
		foreach($sub_cat as $sub_row){
				
			$result[$i]=$sub_row;
			$child_cat = DB::table('categories')->where('role','child')->where('subid',$sub_row->id)->where('status',1)->get(); 
			$child_cat = $child_cat->toArray();
				$result[$i]->child=$child_cat;
			$i++;	
			}
		}
			
			return $result;
	   // return $query->result();
	}

    function str_random($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function pr($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}