$(document).ready(function() {

var filePath="http://nhr.app/homepage/";
	
	$("#location").focus(function() {}).change(function(){
	cityid=$("OPTION:selected", this).val();
	//alert(cityid);
		$.ajax({
			type: "POST",
			url: filePath+"displaychapterdetails",
			data: ({cityid_x:cityid}),
			success: function(msg)
			{
				$("#message").append(msg);
			}
		});
	});
	
});