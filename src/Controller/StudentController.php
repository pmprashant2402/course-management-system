<?php

require_once 'Actionontroller.php';
require_once ROOT_PATH.'src/Modal/StudentModal.php';


/**
 * Description of StudentController
 @author : Prashant Mishra
Project: Course Management system
Date: 28/03/2021
 */
class StudentController extends Actionontroller
{
    private $studentModalObj;
    function __construct() {
        $this->studentModalObj = new StudentModal();
    }
    public function add()
    {
        $this->loadView('header');
        $this->loadView('student/registration');
        $this->loadView('footer');
    }
    
    public function view()
    {
        $this->loadView('header');
        $this->loadView('student/view');
        $this->loadView('student/create_student_modal');
        $this->loadView('footer');
    }
    
    public function list(int $limit = 10, int $offset = 0){
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
                $dataToSend['orderby'] = 'students.id';
                $dataToSend['direction'] = 'DESC';
            }
            if($_POST["length"] != -1){
                $dataToSend['start'] = $_POST['start'];
                $dataToSend['length'] = $_POST['length'];
            } 

            $list = $this->studentModalObj->getList($dataToSend);
            echo json_encode($list);
            
        } catch (Exception $e) {
            $message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
        }
    }
    
    public function create()
    {
        $postData = array();

        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Error Processing Request", 1);
            }
            $postData['first_name'] = $_POST['first_name'] ? $_POST['first_name'] : '';
            $postData['last_name'] = $_POST['last_name'] ? $_POST['last_name'] : '';
            $postData['email'] = $_POST['email'] ? $_POST['email'] : '';
            $postData['date_of_birth'] = $_POST['date_of_birth'] ? $_POST['date_of_birth'] : '';
            $postData['contact_number'] = $_POST['contact_number'] ? $_POST['contact_number'] : '';
            $response = $this->studentModalObj->create($postData);
            echo json_encode($response);

        } catch (Exception $e) {
            $message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
        }
    }

    public function delete() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Not able to delete the record", 1);
            }
            $studentId = $_POST['studentId'];
            $response = $this->studentModalObj->delete($studentId);
            echo json_encode($response);
        } catch (Exception $e) {
           $message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
        }
    }

    public function getStudentData() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Not able to get the record", 1);
            }
            $studentId = $_POST['studentId'];
            $response = $this->studentModalObj->getStudentData($studentId);
            echo json_encode($response);
        } catch (Exception $e) {
            $message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
        }
    }

    public function update() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("No data to update", 1);
            }
            $postData['first_name'] = $_POST['first_name'] ? $_POST['first_name'] : '';
            $postData['last_name'] = $_POST['last_name'] ? $_POST['last_name'] : '';
            $postData['email'] = $_POST['email'] ? $_POST['email'] : '';
            $postData['date_of_birth'] = $_POST['date_of_birth'] ? $_POST['date_of_birth'] : '';
            $postData['contact_number'] = $_POST['contact_number'] ? $_POST['contact_number'] : '';
            $postData['id'] = $_POST['studentId'] ? $_POST['studentId'] : '';
            $response = $this->studentModalObj->update($postData);
            echo json_encode($response);
        } catch (Exception $e) {
            $message =  $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
            $response = array('status'=>FAILED,'message' => $message);
            return $response;
        }
    }

}
