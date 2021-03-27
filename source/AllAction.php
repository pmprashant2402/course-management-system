<?php

include '../dbconfig.php';

/**
 * 
 */

class AllAction
{


	private $connect;
	function __construct()
	{
		$this->connect = $this->connect();
	}


	public function handleRequest() {

		$response = array('status' => 'failed', 'error_code' => 1 );
		if(!isset($_POST['api']) && empty($_POST['api'])) {
			return $response;
		}

		$class = $this->getClassName($_POST['api']);
		$classObj = new $class;

		if(isset($_POST['action']) && !empty($_POST['action'])) {
			switch ($_POST['action']) {
				case 'value':
					case 'create':
						echo "innn"; exit;
					break;

					case 'list':
						$classObj->list(); 
					break;

					case 'get':
						
					break;

					case 'update':
						
					break;

					case 'delete':
						
					break;
				
				default:
					# code...
					break;
			}
		}
	}

	private function getClassName($api) {
		if(isset($api) && !empty($api)) {
			$classApi = ucfirst($api);
			return $classApi;
		}
	}
}


?>
