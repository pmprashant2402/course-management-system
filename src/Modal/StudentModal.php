<?php

require_once ROOT_PATH.'/config/DbConfig.php';

/**
 * 
 */
class StudentModal extends DbConfig
{
	
	function __construct()
	{
		# code...
	}

	public function getList($data) {
		$conn = $this->connect();
		$bindValues = array();
		try {
			if(!isset($data) || !empty($data) && !is_array($data) ) {
				throw new Exception("Something went wrong", 1);
			}
			$sqlQuery = "SELECT students.id,first_name, last_name, email, contact_number, date_of_birth FROM students  Join students_details ON students.id = students_details.student_id ";

	        if(!empty($data['search'])){
	            $sqlQuery .= 'where(students.id LIKE ? ';
	            $sqlQuery .= ' OR first_name LIKE ? ';          
	            $sqlQuery .= ' OR last_name LIKE ? ';
	            $sqlQuery .= ' OR email LIKE ? ';
	            $sqlQuery .= ' OR contact_number LIKE ? ';
	            $sqlQuery .= ' OR date_of_birth LIKE ?) ';
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
			
	        $totalQuery = "SELECT students.id,first_name, last_name, email, contact_number, date_of_birth FROM students Join students_details ON students.id = students_details.student_id  ";
	        
	        $totalRecords = mysqli_query($conn, $totalQuery);
	        $numRows = mysqli_num_rows($totalRecords);
	        $i = 1;
	        $studentData = array();    
	        while( $student = mysqli_fetch_assoc($result) ) {  
	            $studentRows = array();         
	            $studentRows[] = $i;
	            $studentRows[] = ucfirst($student['first_name']);
	            $studentRows[] = $student['last_name'];        
	            $studentRows[] = $student['email'];    
	            $studentRows[] = $student['contact_number'];
	            $studentRows[] = $student['date_of_birth'];                    
	            $studentRows[] = '<button type="button" name="update" id="'.$student["id"].'" class="btn btn-warning btn-xs update">Update</button>';
	            $studentRows[] = '<button type="button" name="delete" id="'.$student["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
	            $studentData[] = $studentRows;
	            $i++;
	        }
	        $output = array(
	            "draw"              =>  intval($data["draw"]),
	            "recordsTotal"      =>  $numRows,
	            "recordsFiltered"   =>  $numRows,
	            "data"              =>  $studentData
	        );
	        return $output;
		} catch (Exception $e) {
			$message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
			$response = array('status'=>FAILED,'message' => $message);
			return $response;			
		}
	}

	public function create($data) {
		$conn = $this->connect();
		try {
			if(empty($data)) {
				throw new Exception("No data to insert ", 1);
			}
			mysqli_autocommit($conn, false);
		    $stmt = $conn->prepare("INSERT INTO students(first_name,last_name) 
                          VALUES(?,?);");
		    $stmt->bind_param("ss",$data['first_name'],$data['last_name']);
			$stmt->execute();
		    $student_id =  $conn->insert_id;
		    
	    	$stmt1 = $conn->prepare("INSERT INTO students_details(student_id,email,contact_number,date_of_birth) VALUES(?,?,?,?);");
		    $stmt1->bind_param("isss",$student_id,$data['email'],$data['contact_number'],$data['date_of_birth']);
			$res = $stmt1->execute();
			if(empty($student_id)) {
	    		throw new Exception("Not able to process the request", 1);
	    	}
	    	mysqli_commit($conn);
			$response = array('status'=>SUCCESS,'message' => 'student records inserted successfully');
			return $response;
		} catch (Exception $e) {
			 mysqli_rollback($conn);
			 $message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
			 return array('status' => FAILED, 'message' => $message);
		}
	}

	public function delete($id) {
		$conn = $this->connect();
		$response = array('error_code'=>500,'message' => 'Something went wrong');
		try {
			mysqli_autocommit($conn, false);

			$stmt_asg = $conn->prepare("DELETE from assigned_courses WHERE student_id = ?");
		    $stmt_asg->bind_param("i",$id);
			$resasg = $stmt_asg->execute();

			$stmt = $conn->prepare("DELETE from students WHERE id = ?");
		    $stmt->bind_param("i",$id);
			$res = $stmt->execute();

			$stmt = $conn->prepare("DELETE from students_details WHERE student_id = ?");
		    $stmt->bind_param("i",$id);
			$res = $stmt->execute();
			mysqli_commit($conn);
			$response = array('status'=>SUCCESS,'message' => 'Student record deleted successfully');
			return $response;
		} catch (Exception $e) {
			mysqli_rollback($conn);
			$message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
			$response = array('status'=>FAILED,'message' => $message);
			return $response;
		}
	}

	public function getStudentData($id) {
		$conn = $this->connect();
		$response = array('error_code'=>500,'message' => 'Something went wrong');
		try {
			$stmt = $conn->prepare("select students.id,first_name, last_name, email, contact_number, date_of_birth from students join students_details ON students.id = students_details.student_id WHERE students.id = ?");
		    $stmt->bind_param("i",$id);
			$res = $stmt->execute();
			$result = $stmt->get_result();
			$studentRecords = mysqli_fetch_assoc($result);
			if(empty($studentRecords)) {
				throw new Exception("Not able to get the student records", 1);
			}
			return $studentRecords;
		} catch (Exception $e) {
			$message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
			$response = array('status'=>FAILED,'message' => $message);
			return $response;
		}
	}

	public function update($data) {
		$conn = $this->connect();
		$response = array('error_code'=>500,'message' => 'Something went wrong');
		try {
			mysqli_autocommit($conn, false);
			$stmt = $conn->prepare("UPDATE students set first_name = ?, last_name = ? where id = ?");
		    $stmt->bind_param("sss",$data['first_name'],$data['last_name'],$data['id']);
			$res = $stmt->execute();
			$stmt = $conn->prepare("UPDATE students_details set email = ?, contact_number = ?, date_of_birth = ? where id = ?");
		    $stmt->bind_param("ssss",$data['email'],$data['contact_number'], $data['date_of_birth'],$data['id']);
			$res = $stmt->execute();
			mysqli_commit($conn);
			if (empty($res)) {
				throw new Exception("Not able to update the student records", 1);
			}
			$response = array('status'=>SUCCESS,'message' => 'Records updated successfully');
			return $response;
		} catch (Exception $e) {
			mysqli_rollback($conn);
			$message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
			$response = array('status'=>FAILED,'message' => $message);
			return $response;
		}
	}
}

?>