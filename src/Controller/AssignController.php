<?php

require_once 'Actionontroller.php';
require_once ROOT_PATH.'src/Modal/AssignModal.php';


/**
 * Description of AssignController
@author : Prashant Mishra
Project: Course Management system
Date: 28/03/2021
 */
class AssignController extends Actionontroller
{
    private $assignModalObj;
    function __construct() {
        $this->assignModalObj = new AssignModal();
    }
    public function add()
    {
        $this->loadView('header');
        $this->loadView('assign/registration');
        $this->loadView('footer');
    }
    
    public function view()
    {
        $this->loadView('header');
        $this->loadView('assign/view');
        $this->loadView('assign/create_assign_modal');
        $this->loadView('footer');
    }
    
    public function list(int $limit = 10, int $offset = 0){
       // echo "<pre>"; print_r($_POST); exit;
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Some thing went wrong", 1);
            }
            $dataToSend['search'] = $_POST["search"]["value"] ? $_POST["search"]["value"] : '';
            $dataToSend['draw']   = $_POST["draw"] ? $_POST["draw"] : '';

            if(!empty($_POST["order"])){
                $dataToSend['orderby'] = $_POST['order']['0']['column'];
                $dataToSend['direction'] = $_POST['order']['0']['dir'];
            } else {
                $dataToSend['orderby'] = 'assigns.id';
                $dataToSend['direction'] = 'DESC';
            }
            if($_POST["length"] != -1){
                $dataToSend['start'] = $_POST['start'];
                $dataToSend['length'] = $_POST['length'];
            } 

            $list = $this->assignModalObj->getList($dataToSend);
            echo json_encode($list);
            
        } catch (Exception $e) {
            echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
        }
    }
    
    public function create()
    {
        $postData = array();
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Error Processing Request", 1);
            }
            $postData['student_id'] = $_POST['student_id'] ? $_POST['student_id'] : '';
            $postData['course_id'] = $_POST['course_id'] ? $_POST['course_id'] : '';
            $response = $this->assignModalObj->create($postData);
            echo json_encode($response);

        } catch (Exception $e) {
            
        }
    }

    public function delete() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Not able to delete the record", 1);
            }
            $assignId = $_POST['assignedId'];
            $response = $this->assignModalObj->delete($assignId);
            echo json_encode($response);
        } catch (Exception $e) {
            echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
        }
    }

    public function getAssignedCourse() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Not able to get the record", 1);
            }
            $assignId = $_POST['assignedId'];
            $response = $this->assignModalObj->getAssignedCourse($assignId);
            echo json_encode($response);
        } catch (Exception $e) {
            echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
        }
    }

    public function update() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("No data to update", 1);
            }
            $postData['student_id'] = $_POST['student_id'] ? $_POST['student_id'] : '';
            $postData['course_id'] = $_POST['course_id'] ? $_POST['course_id'] : '';
            $postData['id'] = $_POST['assignedId'] ? $_POST['assignedId'] : '';
            $response = $this->assignModalObj->update($postData);
            echo json_encode($response);
        } catch (Exception $e) {
            echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
        }
    }

    public function listAssignedCourse() {
    	try {
    		$data = $this->assignModalObj->fetchStudentCourse();
    		echo json_encode($data);
    	} catch (Exception $e) {
    		
    	}
    }

}
