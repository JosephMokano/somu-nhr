
$(function() {
	$("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
	$("#tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
});

$(document).ready(function() {
	//numeric validation
	$("input.numericfield").numeric();
	
	//mandatory fields 
	$("#pat_dispform").validate({ 
		rules: { 
		  txtfname: "required",// simple rule, converted to {required:true} 
		  txtlname: "required"
		},
		messages: { 
		  txtfname: "Please enter First Name." ,
		  txtlname: "Please enter Last name."
		}
	  }); 
	
	//dob
	$("#txtdob").datepicker({
		changeMonth: true,
		changeYear: true, 
		yearRange:'1920:2020',
		onSelect: function(value, date){
			//saveDateValue(value,this.name);
		}
	});
});