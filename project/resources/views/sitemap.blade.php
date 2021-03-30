<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<url>
        <loc><?php echo url('/');?></loc>
    </url>

    <url>
        <loc><?php echo url('/')."/contact/";?></loc>
    </url>

 	<url>
        <loc><?php echo url('/')."/blog";?></loc>
    </url>

    <url>
        <loc><?php echo url('/')."/category/";?></loc>
    </url>


   <url>
        <loc><?php echo url('/')."/tags/";?></loc>
    </url>
    @forelse(@$blogs as $b)

    		   <url>
        <loc><?php echo url('/')."/blog/".$b->id ;?></loc>
    </url>
    @empty
    @endforelse	



      @forelse(@$cmain as $cm)
    		   <url>
        <loc><?php echo url('/')."/category/".$cm->slug;?></loc>
    </url>

    @empty
    @endforelse	



      @forelse(@$prodect as $prodect)
    		   <url>
        <loc><?php echo url('/')."/product/".$prodect->id."/".$prodect->slug;?></loc>
    </url>

    @empty
    @endforelse	

    	

    @forelse(@$cms as $cms)
    		   <url>
        <loc><?php echo url('/')."/".$cms->slug;?></loc>
    </url>

    @empty
    @endforelse	

      @forelse(@$soyallink as $sociyallink)
   	<url>
        <loc><?php echo url('/')."/".$sociyallink->facebook	;?></loc>
    </url>
	<url>
        <loc><?php echo url('/')."/".$sociyallink->twiter;?></loc>
    </url>
    <url>
        <loc><?php echo url('/')."/".$sociyallink->g_plus;?></loc>
    </url>
    <url>
        <loc><?php echo url('/')."/".$sociyallink->linkedin;?></loc>
    </url>


    @empty
    @endforelse	



      @forelse(@$testimonials as $testimonials)
   	<url>
        <loc><?php echo url('/')."/testimonials/".$testimonials->id	;?></loc>
    </url>

    @empty
    @endforelse	

    

  
  
</urlset>