<?php 
	echo "<table id=modulename_tbl_data>
       <tbody>
            <tr id=tr1 class=tr_newaddaction>
                <th>Price From</th>
                <th>Price To</th>
				<th>Choose Type</th>
                <th>Percentage</th>
            </tr>
            <tr id=tr2 class=tr_newaddaction>
                <td><input id=id1 class=required-entry /></td>
                <td><input id=id2 class=required-entry /></td>
                <td><select><option>--Select--</option><option>Fixed Rate</option><option>Percentage</option></select></td>
                <td><input id=id4 class=required-entry /></td>
                <td><button id=add_your_component class=add type=button title=Add><span><span><span>Add New</span></span></span></button></td>
            </tr>
</tbody>
</table>";
?>
<!-- <table id="modulename_tbl_data">
       <tbody>
            <tr id="tr1" class="tr_newaddaction">
                <th>Price From</th>
                <th>Price To</th>
				<th>Choose Type</th>
                <th>Percentage</th>
            </tr>
            <tr id="tr2" class="tr_newaddaction">
                <td><input id="id1" value="" class="required-entry" /></td>
                <td><input id="id2" value="" class="required-entry" /></td>
                <td><select><option>--Select--</option><option>Fixed Rate</option><option>Percentage</option></select></td>
                <td><input id="id4" value="" class="required-entry" /></td>
                <td><button id="add_your_component" class="add" type="button" title="Add"><span><span><span>Add New</span></span></span></button></td>
            </tr>
</tbody>
</table> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
		$('.add').click(function() { 
			var i = $('input').size() + 1;
			var j = $('tr').size() + 1;
			var dropdown = '<select><option>--Select--</option><option>Fixed Rate</option><option>Percentage</option></select>';
			var one = '	<input id="yourID" value="" class="required-entry" />';
			var remove = '<button onclick="javascript:$(this).parent().parent().remove();" class="delete" type="button" title="Remove"><span></span></button>';
			var tr = '<tr class="tr_newaddaction"  id="tr'+j+'"><td id="'+(i-1)+'"">'+one+'</td><td id="'+i+'">'+one+'</td><td id="'+(i+1)+'"">'+dropdown+'</td><td id="'+(i+2)+'"">'+one+'</td><td>'+remove+'</td></tr>';  
			$('#modulename_tbl_data').append(tr);
			i++;
		});
</script>
<style>
input{
	width: 100px;
}
td{
	padding:0px 10px;
}
th{
	padding: 4px 12px;
	width: 120px;
}
table{
	border: 1px solid green;
	width: 706px;
	padding: 5px;
}
select{
	width: 107px;
	border-radius: 3px 3px 3px 3px;
}
option{
	height: 16px;
}
</style>