function log_entry_actions(raw_id,type){
  /*
  if(type == 'drag-marker'){
		var r = confirm("Are you sure you want to change marker position?");
		if(r == false){
			return;
		}
	}
	*/
  var load = document.getElementById('queryresults');
  $('#myModal').modal();
  //load.html = 'images/spinner.gif';
  jQuery.ajax({
    url:'log_entry_actions.php',
    type:'POST',
    data:{'raw_id':raw_id, 'type':type},
    cache:false,
    success:function(data){
      $("#modal_results").html(data);
    },
    error:function(){
      load.html = 'Error Generating Report, please Try Later!';
    }
  });
}
function agent_actions(agent_id,type){
	if(type == 'delete'){
		var r = confirm("Are you sure you want to delete this entry!!");
		if(r == false){
			return;
		}
	}
	  var load = document.getElementById('queryresults');
	  $('#myModal').modal();
	  //load.html = 'images/spinner.gif';
	  jQuery.ajax({
		url:'agent_actions.php',
		type:'POST',
		data:{'agent_id':agent_id, 'type':type},
		cache:false,
		success:function(data){
		  $("#modal_results").html(data);
		},
		error:function(){
		  load.html = 'Error Generating Report, please Try Later!';
		}
	  });
	
}
function bb_actions(bb_co_id,type){
	if(type == 'delete'){
		var r = confirm("Are you sure you want to delete this entry!!");
		if(r == false){
			return;
		}
	}
	  var load = document.getElementById('queryresults');
	  $('#myModal').modal();
	  //load.html = 'images/spinner.gif';
	  jQuery.ajax({
		url:'bb_list.php',
		type:'POST',
		data:{'bb_co_id':bb_co_id, 'type':type},
		cache:false,
		success:function(data){
		  $("#modal_results").html(data);
		},
		error:function(){
		  load.html = 'Error Generating Report, please Try Later!';
		}
	  });
	
}
//Date Picker
$(document).ready(function(){
	var date_input=$('input[name="sd"]'); 
	var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	date_input.datepicker({
		format: 'yyyy-mm-dd',
		container: container,
		todayHighlight: true,
		autoclose: true,
	})
})

$(document).ready(function(){
	var date_input=$('input[name="ed"]'); 
	var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	date_input.datepicker({
		format: 'yyyy-mm-dd',
		container: container,
		todayHighlight: true,
		autoclose: true,
	})
})

//Tweets Listing
$(document).ready(function()
{	
	$(document).on('submit', '#date_select', function()
	{
		var data = $(this).serialize();
		$.ajax({
			type : 'POST',
			url  : 'form_submit.php',
			data : data,
			success :  function(data){						
							$(".listing").fadeOut(500).hide(function(){
								$(".listing").fadeIn(500).html(data);
							});
						}
		});
		return false;
	});
});
function joe_test(raw_id,agent_id){
	//alert(county + ' ' + sd + ' ' + ed);
	$.ajax({
		type : 'POST',
		url  : 'marker_details.php',
		data : {'raw_id':raw_id, 'agent_id':agent_id},
		success :  function(data)
				   {						
						$("#marker_details").fadeOut(500).hide(function()
						{
							//alert('joe');
							$("#marker_details").fadeIn(500).html(data);
							
						});
						
				   }
		});
}

function pageNav(sd,ed,page,page_id){
  //alert(sd + ' | ' + ed + ' | ' + page);
   	var data = $(this).serialize();
		$.ajax({
			type : 'POST',
			url  : 'log_list.php',
			data:{'sd':sd, 'ed':ed, 'limit_page':page, 'page_id':page_id},
			success :  function(data)
					   {						
							$(".listing").fadeOut(500).hide(function()
							{
								//alert('joe');
								$(".listing").fadeIn(500).html(data);
							});
							
					   }
		});
		//return false;
	
  
}

function pie_drilldown(county,sd,ed){
  var load = document.getElementById('queryresults');
  //$('#pie_drilldown_list').modal();
 
  jQuery.ajax({
    url:'log_entry_actions',
    type:'POST',
	//load.html = 'images/loading.gif',
	data:{'county_name':county, 'start_date':sd, 'end_date': ed, 'type':'pie_drilldown'},
	cache:false,
    success:function(data){
				$("#pie_drilldown_list").fadeOut(500).hide(function()
				{
					$("#pie_drilldown_list").fadeIn(500).html(data);
				});
      //$("#pie_drilldown_list").html(data);
    },
    error:function(){
      load.html = 'Error Loading, please Try Later!';
    }
  });
}

function getBrands(co_id,type) {
	$.ajax({
	type: "POST",
	url: "log_entry_actions.php",
	//data:'co_id='+co_id,
	data:{'co_id':co_id, 'type':type},
	success: function(data){
		$("#co_brands").html(data);
	}
	});
}

jQuery(function($) {
    $(document).on('submit', 'form[data-async]', function(event) {
        var $form = $(this);
        var $target = $($form.attr('data-target'));
        var submitButton = $("input[type='submit'][clicked=true], button[type='submit'][clicked=true]", $form);

        var formData = $form.serializeArray();
        if (submitButton.size() === 1) {
            formData.push({ name: $(submitButton[0]).attr("name"), value: "1" });
        }
        else if(submitButton.size() !== 0) {
            console.log("Multiple submit-buttons pressed. This should not happen!");
        }

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: formData,

            success: function(data, status) {
                $target.html(data);
            }
        });

        event.preventDefault();
    });

    $(document).on("click", 'input[type="submit"], button[type="submit"]', function() {
        $('form[data-async] input[type=submit], form[data-async] button[type=submit]', $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });
});

$('.btn-new-agent').on('click', function (e) {
	var agent_id = '0';
	var type = 'new';
	agent_actions(agent_id,type);
})
function save_new_geo(raw_id,lattitude,longitude){
	var r = confirm("Are you sure you want to change marker position?");
	if(r == false){
		return;
	}
	
	$.ajax({
		type: "POST",
		url: "log_entry_actions.php",
		//data:'co_id='+co_id,
		data:{'type':'save_geo','raw_id':raw_id, 'lattitude':lattitude, 'longitude':longitude},
		success: function(data){
			$("#geo_save").html(data);
		}
		});
}