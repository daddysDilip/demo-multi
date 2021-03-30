<?php

namespace App\Http\Controllers;

use App\Navigation;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Input; 
use Redirect; 
use View; 

class NavigationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function getIndex()
	{	
	    $companyid = get_company_id();
		$items 	= Navigation::where('company_id',$companyid)->orderBy('order')->get();

		$menu 	= new Navigation;
		$menu   = $menu->getHTML($items);

		return view('admin.menu.builder',compact('items','menu'));
		//View('admin.navigation.builder', array('items'=>$items,'menu'=>$menu));
	}

	public function getEdit($subdomain,$id)
	{	
		$item = Navigation::findOrFail($id);
		return view('admin.menu.edit',compact('item'));
	}

	public function postEdit($subdomain,$id)
	{	
		$item = Navigation::find($id);
		$item->title 	= e(Input::get('title','untitled'));
		$item->label 	= e(Input::get('label',''));	
		$item->url 		= e(Input::get('url',''));	

		$item->save();
		
		return redirect('admin/navigation')->with('message','Navigation Updated Successfully.');
	}

	// AJAX Reordering function
	public function postIndex()
	{	
	    $source       = e(Input::get('source'));
	    $destination  = e(Input::get('destination',0));
        if($destination == ''){
			$destination = 0;
		}
	    $item             = Navigation::find($source);
	    $item->parent_id  = $destination;  
	    $item->save();

	    $ordering       = json_decode(Input::get('order'));
	    $rootOrdering   = json_decode(Input::get('rootOrder'));

	    if($ordering){
	      foreach($ordering as $order=>$item_id){
	        if($itemToOrder = Navigation::find($item_id)){
	            $itemToOrder->order = $order;
	            $itemToOrder->save();
	        }
	      }
	    } else {
	      foreach($rootOrdering as $order=>$item_id){
	        if($itemToOrder = Navigation::find($item_id)){
	            $itemToOrder->order = $order;
	            $itemToOrder->save();
	        }
	      }
	    }

	    return 'ok ';
	}

	public function postNew(Request $request)
	{
		$companyid = get_company_id();
		// Create a new menu item and save it
		$item = new Navigation;
		$item->fill($request->all());
	
       
		$item['parent_id'] = 0;
		$item['company_id'] =$companyid;
		$item['order'] 	= Navigation::max('order')+1;

		$item->save();
        return redirect('admin/navigation')->with('message','New navigation Added Successfully.');
	}

	public function postDelete()
	{
		$id = Input::get('delete_id');
		// Find all items with the parent_id of this one and reset the parent_id to zero
		$items = Navigation::where('parent_id', $id)->get()->each(function($item)
		{
			$item->parent_id = 0;  
			$item->save();  
		});

		// Find and delete the item that the user requested to be deleted
		$item = Navigation::find($id);
		$item->delete();

		return Redirect::to('admin/navigation');
	}
}
