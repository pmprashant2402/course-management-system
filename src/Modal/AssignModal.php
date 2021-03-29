<?php

require_once ROOT_PATH.'/config/DbConfig.php';

/**
 * 
 */
class AssignModal extends DbConfig
{
	
	function __construct()
	{
		# code...
	}

	public function getList($data) {
		error_reporting(E_ALL);
		$conn = $this->connect();
		$bindValues = array();
		try {
			if(!isset($data) || !empty($data) && !is_array($data) ) {
				throw new Exception("Something went wrong", 1);
			}
			try {
				$sqlQuery = "SELECT assigned_courses.id, student_id, course_id, CONCAT(std.first_name, ' ', std.last_name) as student_name, crc.name as course FROM assigned_courses ";
				$sqlQuery .= "left JOIN students std ON std.id =  assigned_courses.student_id ";
				$sqlQuery .= "left JOIN course crc ON crc.id =  assigned_courses.course_id ";

		        if(!empty($data['search'])){
		            $sqlQuery .= 'where(assigned_courses.id LIKE ? ';
		            $sqlQuery .= ' OR student_id LIKE ? ';
		            $sqlQuery .= ' OR course_id LIKE ?) ';
		            $search = "%".$data['search']."%";          
		        } 
		        /*if(!empty($data['order'])){
		            $sqlQuery .= 'ORDER BY ? ? ';
		            $orderby = $data['orderby'];
		            $direction = $data['direction'];
		        } else {
		            $sqlQuery .= 'ORDER BY ? ? ';
		            $orderby = 'students.id';
		            $direction = 'DESC';
		        }*/
		        if($_POST["length"] != -1){
		            $sqlQuery .= 'LIMIT ? , ?';
		            $bindValues[] = $data['start'];
		            $bindValues[] = $data['length'];
		        }
		       	$bindData = implode($bindValues,',');
		        $stmt = $conn->prepare($sqlQuery);
		        if(!empty($search)) {
		        	$stmt->bind_param("ssssssii",$search,$search,$search,$search,$search,$search,$data['start'],$data['length']);
		        } else {
		        	$stmt->bind_param("ss",$data['start'],$data['length']);
		        }
				$stmt->execute();
				$result = $stmt->get_result();
				
		        $totalQuery = "SELECT assigned_courses.id, student_id, course_id, CONCAT(std.first_name, ' ', std.last_name) as student_name, crc.name as course FROM assigned_courses ";
				$totalQuery .= "left JOIN students std ON std.id =  assigned_courses.student_id ";
				$totalQuery .= "left JOIN course crc ON crc.id =  assigned_courses.course_id ";
		        
		        $totalRecords = mysqli_query($conn, $totalQuery);
		        $numRows = mysqli_num_rows($totalRecords);
		        $i = 1;
		        $assignedData = array();    
		        while( $assigned = mysqli_fetch_assoc($result) ) {  
		            $assignedRows = array();         
		            $assignedRows[] = $i;
		            $assignedRows[] = ucfirst($assigned['student_id']);
		            $assignedRows[] = $assigned['course_id'];        
		            $assignedRows[] = $assigned['student_name'];    
		            $assignedRows[] = $assigned['course'];
		            $assignedRows[] = '<button type="button" name="update" id="'.$assigned["id"].'" class="btn btn-warning btn-xs update">Update</button>';
		            $assignedRows[] = '<button type="button" name="delete" id="'.$assigned["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
		            $assignedData[] = $assignedRows;
		            $i++;
		        }
		        $output = array(
		            "draw"              =>  intval($data["draw"]),
		            "recordsTotal"      =>  $numRows,
		            "recordsFiltered"   =>  $numRows,
		            "data"              =>  $assignedData
		        );
		        return $output;
			} catch (Exception $e) {
				
			}
		} catch (Exception $e) {
						
		}
	}

	public function create($data) {
		$conn = $this->connect();
		$response = array('error_code'=>500,'message' => 'Something went wrong');
		try {
			if(empty($data)) {
				throw new Exception("No data to insert ", 1);
			}
			try {
				if (isset($data['student_id']) && !empty($data['student_id'])) {
					foreach ($data['student_id'] as $key => $row) {
						$stmt = $conn->prepare("INSERT INTO assigned_courses(student_id,course_id) 
                              VALUES(?,?);");
					    $stmt->bind_param("ii",$data['student_id'][$key],$data['course_id'][$key]);
						$res = $stmt->execute();
					}
				}
			  
			   	if(empty($res)) {
			   		throw new Exception("Not able to assign", 1);
			   	}
			} catch (Exception $e) {
				 echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
			}
		} catch (Exception $e) {
			 echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
		}
	}

	public function delete($id) {
		$conn = $this->connect();
		$response = array('error_code'=>500,'message' => 'Something went wrong');
		try {
			$stmt = $conn->prepare("DELETE from assigned_courses WHERE id = ?");
		    $stmt->bind_param("i",$id);
			$res = $stmt->execute();
			if(empty($res)) {
				throw new Exception("Not able to delete the records", 1);
			}
			$response = array('error_code'=>200,'message' => 'Assign record deleted successfully');
			return $response;
		} catch (Exception $e) {
			echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
		}
	}

	public function getAssignedCourse($id) {
		$conn = $this->connect();
		$response = array('error_code'=>500,'message' => 'Something went wrong');
		try {
			$stmt = $conn->prepare("select * from assigned_courses WHERE id = ?");
		    $stmt->bind_param("i",$id);
			$res = $stmt->execute();
			$result = $stmt->get_result();
			$assignedRecords = mysqli_fetch_assoc($result);
			if(empty($assignedRecords)) {
				throw new Exception("Not able to get the assigned records", 1);
			}
			return $assignedRecords;
		} catch (Exception $e) {
			echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
		}
	}

	public function update($data) {
		$conn = $this->connect();
		$response = array('error_code'=>500,'message' => 'Something went wrong');
		try {
			$this->delete($data['id']);
			$this->create($data);
			$response = array('error_code'=>200,'message' => 'Records updated successfully');
			return $response;
		} catch (Exception $e) {
			echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
		}
	}

	public function fetchStudentCourse() {
		$conn = $this->connect();
		$response = array();
		$sqlQuery = "SELECT id, name, details FROM course ";
		$stmt = $conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$courseData =  array();
		while( $course = mysqli_fetch_assoc($result) ) { 
			$courseRows = array();			
			$courseRows['id'] = $course['id'];
			$courseRows['name'] = ucfirst($course['name']);
			$courseRows['details'] = $course['details'];
			$courseData[] = $courseRows;
		}

		$sqlQuery = "SELECT * from students ";
		$stmt = $conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		$studentData = array();
		while( $students = mysqli_fetch_assoc($result) ) { 
			$studentRows = array();			
			$studentRows['id'] = $students['id'];
			$studentRows['first_name'] = ucfirst($students['first_name']);
			$studentRows['last_name'] = $students['last_name'];
			$studentData[] = $studentRows;
		}
		$response['students_list'] = $studentData; 
		$response['course_list'] = $courseData;
		$response = array('sussess' => true, 'error_code' => 500, 'data' => $response);
		return $response; 
	}
}

?>