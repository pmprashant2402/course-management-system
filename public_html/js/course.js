$('#courseList').DataTable().ajax.reload();
$(document).ready(function(){	
	var courseData = $('#courseList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url: APP_BASE_URL + "/course/list",
			type:"POST",
			data:{action:'listCourse'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	


	
	$('#addCourse').click(function(){
		$('#courseModal').modal('show');
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Course");
		$('#action').val('addCourse');
		  $("form[name='create_course']").validate({
		    rules: {
		      name: {
		      	//lettersonly: true,
				required: true,
				minlength: 3,
				maxlength: 100
		      },
		      details:{
		      //	lettersonly: true,
				required: true,
				minlength: 10,
				//maxlength: 15
		      }
		    },
		    messages: {
		      name: {
		      	required:  "Please enter your first name",
		      	minlength: "Your first name must be at least 3 characters long",
		      	//maxlength: "Your first name must be less then 15 characters"

		      },
		      details: {
		      	required:  "Please enter your last name",
		      	minlength: "Your last name must be at least 3 characters long",
		      //	maxlength: "Your last name must be less then 15 characters"

		      }
		    },
		    submitHandler: function(form) {
		      var data = $("form[name='create_course']").serializeArray();
		      url: APP_BASE_URL + "/course/add",
			  data.push({action: 'addCourse'});
				  $.ajax({
				    type: "POST",
				    url: APP_BASE_URL + "/course/create",
				    data: data,
				    success: function(response){
				        $('#create_course')[0].reset();
						$('#courseModal').modal('hide');
						courseData.ajax.reload();	
				    },
				    error: function(){
				        alert("chyba");
				    }
				  });
    		}
 	});
	});		
	$("#courseList").on('click', '.update', function(){
		var courseId = $(this).attr("id");
		var action = 'getCoursee';
		$.ajax({
			url: APP_BASE_URL + "/course/getcourseData",
			method:"POST",
			data:{courseId:courseId, action:action},
			dataType:"json",
			success:function(data){
				$('#courseModal').modal('show');
				$('#courseId').val(data.id);
				$('#name').val(data.name);
				$('#details').val(data.details);
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Course");
				$('#save').val('Save');
				$('#action').val('updateCourse');
				$('#save').hide();
				$('.update_course_records').show();
				$('.update_course_records').removeClass("hide");
			}
		})
	});
	
	$("#courseList").on('click', '.delete', function(){
		var courseId = $(this).attr("id");		
		var action = "deleteCourse";
		if(confirm("Are you sure you want to delete this course?")) {
			$.ajax({
				url: APP_BASE_URL + "/course/delete",
				method:"POST",
				data:{courseId:courseId, action:action},
				success:function(data) {					
					courseData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	$("#create_course").on('click', '.update_course_records', function(){
		var courseId = $("#courseId").val();
		var action = 'updateCourse';
	    var data = $("form[name='create_course']").serializeArray();
		data.push({action: action});
		 console.log(data);
			  $.ajax({
			    type: "POST",
			    url: APP_BASE_URL + "/course/update",
			    data: data,
			    success: function(response){
			        $('#create_course')[0].reset();
					$('#courseModal').modal('hide');	
					courseData.ajax.reload();
			    },
			    error: function(){
			        alert("error");
			    }
			  });
	});
});