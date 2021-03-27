$(document).ready(function(){	
	var studentData = $('#studentList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"http://localhost/sage/source/index.php",
			type:"POST",
			data:{action:'list',api:'StudentClass'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 6, 7],
				"orderable":false,
			},
		],
		"pageLength": 10
	});		
	$('#addStudent').click(function(){
		$('#studentModal').modal('show');
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Student");
		$('#action').val('create');
		  $("form[name='registration']").validate({
		    rules: {
		      first_name: {
		      	//lettersonly: true,
				required: true,
				minlength: 3,
				maxlength: 15
		      },
		      last_name:{
		      //	lettersonly: true,
				required: true,
				minlength: 3,
				maxlength: 15
		      },
		      email: {
		        required: true,
		        email: true
		      },
		      contact_number: {
		      	number: true,
		        required: true,
		        minlength: 10,
		        maxlength: 10
		      },
		      date_of_birth: {
		      	required: true
		      }
		    },
		    messages: {
		      first_name: {
		      	required:  "Please enter your first name",
		      	minlength: "Your first name must be at least 3 characters long",
		      	maxlength: "Your first name must be less then 15 characters"

		      },
		      last_name: {
		      	required:  "Please enter your last name",
		      	minlength: "Your last name must be at least 3 characters long",
		      	maxlength: "Your last name must be less then 15 characters"

		      },
		      contact_number: {
		      	number: "Please enter only numbers",
		        required: "Please provide a contact number",
		        minlength: "Your contact number must be at least 10 characters long"
		      },
		      email: "Please enter a valid email address",
		      date_of_birth: "Please select date of birth"
		    },
		    submitHandler: function(form) {
		      var data = $("form[name='registration']").serializeArray();
			  data.push({'api': 'StudentClass'});
			  console.log(data);
				  $.ajax({
				    type: "POST",
				    url: "http://localhost/sage/source/index.php",
				    data: data,
				    success: function(response){
				        $('#registration')[0].reset();
						$('#studentModal').modal('hide');	
						studentData.ajax.reload();
				    },
				    error: function(){
				        alert("error");
				    }
				  });
    		}
 	});
	});
	
	$("#studentList").on('click', '.update', function(){
		var studentId = $(this).attr("id");
		var action = 'getStudent';
		$.ajax({
			url: APP_BASE_URL + "e/action.php",
			method:"POST",
			data:{studentId:studentId, action:action},
			dataType:"json",
			success:function(data){
				$('#studentModal').modal('show');
				$('#studentId').val(data.id);
				$('#first_name').val(data.first_name);
				$('#last_name').val(data.last_name);
				$('#email').val(data.email);				
				$('#contact_number').val(data.contact_number);
				$('#date_of_birth').val(data.date_of_birth);	
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Student");
				
				$('#action').val('updateStudent');
				$('#save').hide();
				$('.update_student_records').show();
				$('.update_student_records').removeClass("hide");


			}
		})
	});

$("#registration").on('click', '.update_student_records', function(){
		var studentId = $("#studentId").val();
		var action = 'updateStudent';
	    var data = $("form[name='registration']").serializeArray();
		data.push({action: action});
		 console.log(data);
			  $.ajax({
			    type: "POST",
			    url: APP_BASE_URL + "e/action.php",
			    data: data,
			    success: function(response){
			        $('#registration')[0].reset();
					$('#studentModal').modal('hide');	
					studentData.ajax.reload();
			    },
			    error: function(){
			        alert("error");
			    }
			  });
	});

	$("#studentList").on('click', '.delete', function(){
		var studentId = $(this).attr("id");		
		var action = "studentDelete";
		if(confirm("Are you sure you want to delete this student?")) {
			$.ajax({
				url: APP_BASE_URL + "e/action.php",
				method:"POST",
				data:{studentId:studentId, action:action},
				success:function(data) {					
					studentData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
});