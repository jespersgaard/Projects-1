$(function(){
	// Hide Success after so long
	$('.success').hide(4000);
	
	$("#s-views").hide();
	$("#s-people").hide();
	$("#s-projects").hide();
	
	// Projects Page toggle Projects form
	$("#project").hide();
	$('.addProject').click(function() {
		$("#project").show('slow');
	});
	$('a#close').click(function(){
		$("#project").slideToggle('slow');
	});
	$('.item h4').click(function(){
		$(this).next().slideToggle();
	});
	
	$('.sb_projects').click(function(){
        $("#s-projects").slideToggle('slow');	
	});
	$('a#pclose').click(function(){
	   $("#s-projects").hide('slow');
    });
	
	$('.task_item').change(function(){
		if($(this)[0].checked){
			var value = $(this).val();
			if($.post("bin/processTask.php",{"task_item":value})){
				location.reload(true);
			}
		}
	});
	
	$('.pPerms').change(function(){
		if($(this)[0].checked){
			var value = $(this).val();
			var pid = $('input#pid').val();
			if($.post("bin/processPerms.php",{"uid":value,"pid":pid})){
				location.reload(true);
			}
		} else {
			var value = $(this).val();
			var pid = $('input#pid').val();
			if($.post("bin/processPerms.php",{"uid":value,"pid":pid,"remove":"true"})){
				location.reload(true);
			}
		}
	});
});

function lookup(inputString){
	if(inputString.length == 0){
		$('#suggestions').hide();
	} else {
		$.post("bin/meta.php", {queryString:"'"+inputString+"'"}, function(data){
			if(data.length > 0){
				$('#suggestions').show();
				$('#autoSuggestionsList').html(data);
			}
		});
	}
}

function fill(thisValue){
	var testValue = $('#meta').val();
	var splitValue = testValue.split(", ");
	var finalValue = "";
	var testInt = splitValue.length - 1;
	for(i = 0; i < splitValue.length;i++){
		if(i == testInt){
			finalValue = finalValue + thisValue + ", ";
		} else {
			finalValue = finalValue + splitValue[i] + ", ";
		}
	}
	$('#meta').val(finalValue);
	$('#suggestions').hide();
}