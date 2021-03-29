$('#assignList').DataTable().ajax.reload();
$(document).ready(function(){	
	var assignData = $('#assignList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url: APP_BASE_URL + "/assign/list",
			type:"POST",
			data:{action:'listAssignedCourse'},
			dataType:"json"
		},
		"columnDefs":[
			    { "visible": false, "targets": 1 },
			    { "visible": false, "targets": 2 },
		],
		"pageLength": 10
	});	

	$('#assignCourse').click(function(){
		$('#assignModal').modal('show');
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Course");
		$('#action').val('assignCourse');
		  $("form[name='assign_course']").validate({
		    rules: {
		      course_id: {
				required: true
		      },
		      student_id:{
				required: true,
		      }
		    },
		    messages: {
		      course_id: {
		      	required:  "Please select course",
		      },
		      details: {
		      	student_id:  "Please select student",
		      }
		    },
		    submitHandler: function(form) {
		      var data = $("form[name='assign_course']").serializeArray();
			  data.push({action: 'assignCourse'});
				  $.ajax({
				    type: "POST",
				    url: APP_BASE_URL + "/assign/create",
				    data: data,
				    success: function(response){
				        $('#assign_course')[0].reset();
						$('#assignModal').modal('hide');
						assignData.ajax.reload();	
				    },
				    error: function(){
				        alert("error");
				    }
				  });
    		}
 	});
	});		
	$("#assignList").on('click', '.update', function(){

		var assignedId = $(this).attr("id");
		var action = 'getAssignedCourse';
		$.ajax({
			url: APP_BASE_URL + "/assign/getAssignedCourse",
			method:"POST",
			data:{assignedId:assignedId, action:action},
			dataType:"json",
			success:function(data){
				$('#assignModal').modal('show');
				$('#assignedId').val(data.id);
				$('#name').val(data.name);				
				$('#course').val(data.course);	
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Assigned Course");
				$('#action').val('updateAssignedCourse');
				$('#save').val('Save');
				$('#save').hide();
				$('.update_assigned_course').show();
				$('.update_assigned_course').removeClass("hide");
        		$(".student_id").val(data.student_id).attr("selected","selected");
        		$(".course_id").val(data.course_id).attr("selected","selected");

			}
		})
	});
	
	$("#assignList").on('click', '.delete', function(){
		var assignedId = $(this).attr("id");		
		var action = "assignDelete";
		if(confirm("Are you sure you want to delete this assign?")) {
			$.ajax({
				url: APP_BASE_URL + "/assign/delete",
				method:"POST",
				data:{assignedId:assignedId, action:action},
				success:function(data) {					
					assignData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	

	  $("#assign_course").on('click', '.update_assigned_course', function(){
		var assignedId = $("#assignedId").val();
		var action = 'updateAssignedCourse';
	    var data = $("form[name='assign_course']").serializeArray();
		data.push({action: action});
		 console.log(data);
			  $.ajax({
			    type: "POST",
			    url: APP_BASE_URL + "/assign/update",
			    data: data,
			    success: function(response){
			       // $('#assign_course')[0].reset();
					$('#assignModal').modal('hide');	
					assignData.ajax.reload();
			    },
			    error: function(){
			        alert("error");
			    }
			  });
	});

});

$(document).ready(function(){
 $.ajax({    
        url: APP_BASE_URL + "/assign/listAssignedCourse",
        type: 'POST',
        data:{action:'listStudentCourse'},
		dataType:"json",
        success: function(data) {
        	var studentlistItems = '<option value="">Select Student</option>';
        	var courselistItems = '<option value="">Select Course</option>';
        	var studentJson = data.data.students_list;
        	var courseJson = data.data.course_list;
        	
    		for (var i = 0; i < studentJson.length; i++){

		      studentlistItems+= "<option value='" + studentJson[i].id + "'>" + studentJson[i].first_name + ' '+ studentJson[i].last_name + "</option>";
		    }
	    	for (var i = 0; i < courseJson.length; i++){
		      courselistItems+= "<option value='" + courseJson[i].id + "'>" + courseJson[i].name + "</option>";
		    }
        	 var html = '';
			  html += '<tr>';
			  html += '<td><select name="student_id[]"   class="form-control student_id">'+studentlistItems+'</select></td>';
			  html += '<td><select name="course_id[]" class="form-control course_id">'+courselistItems+'</select></td>';
			  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
  			$('#item_table').append(html);
        }
        });
 $(document).on('click', '.assign_course', function(){
  $.ajax({    
        url: APP_BASE_URL + "/assign/listAssignedCourse",
        type: 'POST',
		dataType:"json",
        success: function(data) {
        	var studentlistItems = '<option value="">Select Student</option>';
        	var courselistItems = '<option value="">Select Course</option>';
        	var studentJson = data.data.students_list;
        	var courseJson = data.data.course_list;

    		for (var i = 0; i < studentJson.length; i++){
		      studentlistItems+= "<option value='" + studentJson[i].id + "'>" + studentJson[i].first_name + "</option>";
		    }
	    	for (var i = 0; i < courseJson.length; i++){
		      courselistItems+= "<option value='" + courseJson[i].id + "'>" + courseJson[i].name + "</option>";
		    }
        	 var html = '';
			  html += '<tr>';
			  html += '<td><select name="student_id[]" class="form-control student_id">'+studentlistItems+'</select></td>';
			  html += '<td><select name="course_id[]" class="form-control course_id">'+courselistItems+'</select></td>';
			  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
  			$('#item_table').append(html);
        }
        });

 });
 

 $('#insert_form').on('submit', function(event){
	  event.preventDefault();
	  var error = '';
	  $('.student_id').each(function(){
	   var count = 1;
	   if($(this).val() == '')
	   {
	    error += "<p>Please select Course at "+count+" Row</p>";
	    return false;
	   }
	   count = count + 1;
	  });
	  
	  $('.course_id').each(function(){
	   var count = 1;
	   if($(this).val() == '')
	   {
	    error += "<p>Please select course at "+count+" Row</p>";
	    return false;
	   }
	   count = count + 1;
	  });
	  
	  var form_data = $(this).serialize();
	  if(error == '')
	  {

	    var data = form_data;
	    console.log(form_data)
		url: APP_BASE_URL + "/assign/assignCourse",
	    data.push({action: 'assignCourse'});
		  $.ajax({
		    type: "POST",
		    url: APP_BASE_URL + "/assign/create",
		    data: data,
		    success: function(response){
		        $('#assign_course')[0].reset();
				$('#assignModal').modal('hide');	
		    },
		    error: function(){
		        alert("chyba");
		    }
		  });

	  }
	  else
	  {
	   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
	  }
 });
 
 

});