<?php

require_once 'Actionontroller.php';
require_once ROOT_PATH.'src/Modal/CourseModal.php';


/**
 * Description of courseController
@author : Prashant Mishra
Project: Course Management system
Date: 28/03/2021
 */
class courseController extends Actionontroller
{
    private $courseModalObj;
    function __construct() {
        $this->courseModalObj = new CourseModal();
    }
    public function add()
    {
        $this->loadView('header');
        $this->loadView('course/registration');
        $this->loadView('footer');
    }
    
    public function view()
    {
        $this->loadView('header');
        $this->loadView('course/view');
        $this->loadView('course/create_course_modal');
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
                $dataToSend['orderby'] = 'courses.id';
                $dataToSend['direction'] = 'DESC';
            }
            if($_POST["length"] != -1){
                $dataToSend['start'] = $_POST['start'];
                $dataToSend['length'] = $_POST['length'];
            } 

            $list = $this->courseModalObj->getList($dataToSend);
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
            $postData['name'] = $_POST['name'] ? $_POST['name'] : '';
            $postData['details'] = $_POST['details'] ? $_POST['details'] : '';
            $response = $this->courseModalObj->create($postData);
            echo json_encode($response);

        } catch (Exception $e) {
            
        }
    }

    public function delete() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Not able to delete the record", 1);
            }
            $courseId = $_POST['courseId'];
            $response = $this->courseModalObj->delete($courseId);
            echo json_encode($response);
        } catch (Exception $e) {
            echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
        }
    }

    public function getcourseData() {
        try {
            if(!isset($_POST) && empty($_POST)) {
                throw new Exception("Not able to get the record", 1);
            }
            $courseId = $_POST['courseId'];
            $response = $this->courseModalObj->getcourseData($courseId);
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
            $postData['name'] = $_POST['name'] ? $_POST['name'] : '';
            $postData['details'] = $_POST['details'] ? $_POST['details'] : '';
            $postData['id'] = $_POST['courseId'] ? $_POST['courseId'] : '';
            $response = $this->courseModalObj->update($postData);
            echo json_encode($response);
        } catch (Exception $e) {
            echo $e->getMessage().'in file'.$e->getFile().' line number '. $e->getLine();
        }
    }

}
