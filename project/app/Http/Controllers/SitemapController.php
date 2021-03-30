<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Category;
use App\Product;
use App\Cms;
use App\SocialLink;
use App\Testimonial;

class SitemapController extends Controller
{
   

					public function sitemap()
					{
							 $companyid = get_company_id();

								 $blogs = Blog::where('company_id',$companyid)->orderBy('id','desc')->get();
				
   					
   					 $cmain = Category::where('status',1)->where('company_id',$companyid)->orderBy('id','desc')->get();

   					$prodect = Product::where('status',1)->where('company_id',$companyid)->orderBy('id','desc')->get();

   				 $cms = Cms::where('status', 1)->where('company_id',$companyid)->get(); 
   				 $soyallink=SocialLink::where('company_id',$companyid)->get();

   				  $testimonials = Testimonial::where('company_id',$companyid)->orderBy('id','desc')->get();

							 return response()->view('sitemap',compact('blogs','cmain','prodect','cms','soyallink','testimonials'))->header('Content-Type', 'text/xml');
						// return view('sitemap')->header('Content-Type', 'text/xml');
					}


}
