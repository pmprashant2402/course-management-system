$('#courseList').DataTable().ajax.reload();
$(document).ready(function(){	
	var courseData = $('#courseList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"http://localhost/sage/source/AllAction.php",
			type:"POST",
			data:{action:'list',api:'student'},
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