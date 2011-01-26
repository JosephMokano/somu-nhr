$(document).ready(function() {
	//medicine recieved date
	$("#txtmedrecdate").datepicker({
		onSelect: function(value, date){
			//saveDateValue(value,this.name);
		}
	});
	//exp date
	$("#txtexpdate").datepicker({
		onSelect: function(value, date){
			//saveDateValue(value,this.name);
		}
	});
	//exp date
	$("#txtissuedate").datepicker({
		onSelect: function(value, date){
			//saveDateValue(value,this.name);
		}
	});
	
	//gift
	$('#chkisgiftY').click(function(){
		if ($("#chkisgiftY").is(":checked")) {
			$("#dontarea").hide("fast");
		}else if ($("#chkisgiftN").is(":checked")){
			$("#dontarea").show("fast");
		}
	});

	//numeric validation 
	$("input.numericfield").numeric();

	/*function orgtype(){
		//$("drppromode").attr("disabled",true);
		var qs = $("#drppromode").val();
		alert(qs);
		if(qs != ''){
			$("#drpprorg").append(new Option('Getting city list ...'));
			var cityOptions = new Array('1','2','3');
			$.get("", function(data){
						eval(data);	
			});
		}
	}*/
	
	
	$("#drppromode").change(function(){
	    $.ajax({
	            type: "POST",
				url: filePath+"dynamic_procur_drop",
				data: "cat_data=" + $('#drppromode').val(),	
				success: function(msg)
				{
	               if (msg != '')
					{
	                    $("#drpprorg").html(msg).show();
	                }
	                else
					{
	                   $("#drpprorg").html(<em>No item result</em>);
	               }
          		}
        	});
    	});	
});