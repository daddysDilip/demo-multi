

$(".addmore").on('click',function(){
	 $.ajax({
				url : 'colordata',
				dataType: "html",
				method: 'get',
				 success: function( data ) {
				var color = jQuery.parseJSON(data);
					
					 
				$.ajax({
				url : 'sizedata',
				dataType: "html",
				method: 'get',
				 success: function( data ) {
			var size = jQuery.parseJSON(data);
					
				var i = $('#tamptable >tbody >tr').length + 1;

	html = '<tr>';

	html += '<td><input class="case" type="checkbox"/></td>';

	html += '<td><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-danger btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" id="file" name="Image[]"></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a></div></td>';

	html += '<td><input type="text" name="mitem['+i+'][Name]" id="itemName_1" class="form-control"></td>';

		html += '<td><select class="form-control SizeID"   id="SizeID" name="mitem['+i+'][SizeID]">'+size+'</select></td>';

	html += '<td><select class="form-control ColorID"   id="ColorID" name="mitem['+i+'][ColorID]">'+color+'</select></td>';

	html += '<td><input type="number" name="mitem['+i+'][Price]"  class="form-control"></td>';

	html += '<td><input type="number" name="mitem['+i+'][OfferPrice]" id="total_1" class="form-control"></td>';

	html += '</tr>';

	$('#tamptable').append(html);
	
				
				//$(".ColorID").html(data);  

				}
});
				 }
	});

	
	

});


$(".updatemore").on('click',function(){
			 $.ajax({
				url : '../colordata',
				dataType: "html",
				method: 'get',
				 success: function( data ) {
				var color = jQuery.parseJSON(data);
					 
				$.ajax({
				url : '../sizedata',
				dataType: "html",
				method: 'get',
				 success: function( data ) {
			var size = jQuery.parseJSON(data);
					 
				var i = $('#tamptable >tbody >tr').length + 1;

	html = '<tr>';

	html += '<td><input class="case" type="checkbox"/></td>';

	html += '<td><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-danger btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" id="file" name="Image[]"></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a></div></td>';

	html += '<td><input type="text" name="mitem['+i+'][Name]" id="itemName_1" class="form-control"></td>';

		html += '<td><select class="form-control SizeID"   id="SizeID" name="mitem['+i+'][SizeID]">'+size+'</select></td>';

	html += '<td><select class="form-control ColorID"   id="ColorID" name="mitem['+i+'][ColorID]">'+color+'</select></td>';

	html += '<td><input type="number" name="mitem['+i+'][Price]"  class="form-control"></td>';

	html += '<td><input type="number" name="mitem['+i+'][OfferPrice]" id="total_1" class="form-control"></td>';

	html += '</tr>';

	$('#tamptable').append(html);
	
}
});
				 }
	});
	

});

$(".delete").on('click', function() {

	$('.case:checkbox:checked').parents("tr").remove();

	$('#check_all').prop("checked", false); 
});