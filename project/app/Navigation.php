<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
	
	use Notifiable;
    public $table = "navigation";
	
   protected $fillable = ['parent_id', 'title', 'label', 'url','order','created_at', 'updated_at', 'company_id'];
   
   public function buildMenu($menu, $parentid = 0) 
	{ 
	  $result = null;
	  foreach ($menu as $item) 
	    if ($item->parent_id == $parentid) { 
	      $result .= "<li class='dd-item nested-list-item' data-order='{$item->order}' data-id='{$item->id}'>
	      <div class='dd-handle nested-list-handle'>
	        <i class='fa fa-bars'></i>
	      </div>
	      <div class='nested-list-content'>{$item->label}
	        <div class='pull-right'>
	          <a href='#' class='edit_toggle' data-id='{$item->id}' data-title='{$item->title}' data-label='{$item->label}' data-url='{$item->url}'>Edit</a> |
	          <a href='#' class='delete_toggle' rel='{$item->id}'>Delete</a>
	        </div>
	      </div>".$this->buildMenu($menu, $item->id) . "</li>"; 
	    } 
	  return $result ?  "\n<ol class=\"dd-list\">\n$result</ol>\n" : null; 
	} 

	// Getter for the HTML menu builder
	public function getHTML($items)
	{
		return $this->buildMenu($items);
	}
}
