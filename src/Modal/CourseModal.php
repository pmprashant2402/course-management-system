<?php

require_once ROOT_PATH.'/config/DbConfig.php';

/**
 * 
 */
class CourseModal extends DbConfig
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
			
			$sqlQuery = "SELECT id, name, details FROM course ";

	        if(!empty($data['search'])){
	            $sqlQuery .= 'where(course.id LIKE ? ';
	            $sqlQuery .= ' OR name LIKE ? ';          
	            $sqlQuery .= ' OR details LIKE ?) ';
	            $search = "%".$data['search']."%";          
	        } 
	        
	        if($_POST["length"] != -1){
	            $sqlQuery .= 'LIMIT ? , ?';
	        }
	        $stmt = $conn->prepare($sqlQuery);
	        // /echo $sqlQuery; exit;
	        if(!empty($search)) {
	        	$stmt->bind_param("sssss",$search,$search,$search,$data['start'],$data['length']);
	        } else {
	        	$stmt->bind_param("ss",$data['start'],$data['length']);
	        }
			$stmt->execute();
			$result = $stmt->get_result();
			
	        $totalQuery = "SELECT id, name, details FROM course";
	        
	        $totalRecords = mysqli_query($conn, $totalQuery);
	        $numRows = mysqli_num_rows($totalRecords);
	        $i = 1;
	        $courseData = array();    
	        while( $course = mysqli_fetch_assoc($result) ) {  
	            $courseRows = array();			
				$courseRows[] = $i;
				$courseRows[] = ucfirst($course['name']);
				$courseRows[] = $course['details'];							
				$courseRows[] = '<button type="button" name="update" id="'.$course["id"].'" class="btn btn-warning btn-xs update">Update</button>';
				$courseRows[] = '<button type="button" name="delete" id="'.$course["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
				$courseData[] = $courseRows;
				$i++;
	        }
	        $output = array(
	            "draw"              =>  intval($data["draw"]),
	            "recordsTotal"      =>  $numRows,
	            "recordsFiltered"   =>  $numRows,
	            "data"              =>  $courseData
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
		$response = array('status'=>FAILED,'message' => 'Something went wrong');
		try {
			if(empty($data)) {
				throw new Exception("No data to insert ", 1);
			}
		    $stmt = $conn->prepare("INSERT INTO course(name,details) 
                          VALUES(?,?);");
		    $stmt->bind_param("ss",$data['name'],$data['details']);
			$res = $stmt->execute();
			if (empty($res)) {
				throw new Exception("Failed to insert the records", 1);	
			}
			$response = array('status'=>SUCCESS,'message' => 'Record inserted successfully');
			return $response;
		} catch (Exception $e) {
			$message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
		}
	}

	public function delete($id) {
		$conn = $this->connect();
		$response = array('status'=>FAILED,'message' => 'Something went wrong');
		try {
			mysqli_autocommit($conn, false);
			$stmt1 = $conn->prepare("DELETE from assigned_courses WHERE course_id = ?");
		    $stmt1->bind_param("i",$id);
			$res1 = $stmt1->execute();

			$stmt = $conn->prepare("DELETE from course WHERE id = ?");
		    $stmt->bind_param("i",$id);
			$res = $stmt->execute();
					
			mysqli_commit($conn);
			if(empty($res)) {
				throw new Exception("Not able to delete the records", 1);
			}
			$response = array('status'=>SUCCESS,'message' => 'Course record deleted successfullywwww');
			return $response;
		} catch (Exception $e) {
			$message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
		}
	}

	public function getcourseData($id) {
		$conn = $this->connect();
		$response = array('status'=>FAILED,'message' => 'Something went wrong');
		try {
			$stmt = $conn->prepare("select * from course WHERE id = ?");
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
		$response = array('status'=>FAILED,'message' => 'Something went wrong');
		try {
			
			$stmt = $conn->prepare("UPDATE course set name = ?, details = ? where id = ?");
		    $stmt->bind_param("sss",$data['name'],$data['details'],$data['id']);
			$res = $stmt->execute();
			if(empty($res)) {
				throw new Exception("Not able to update the course records ", 1);
			}
			$response = array('status'=>SUCCESS,'message' => 'Records updated successfully');
			return $response;
		} catch (Exception $e) {
			$message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
		}
	}
}

?>