<?php
class HomeController extends Controller {
    
    function index() {
        $this->view("index");
    }
    
    function create() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_POST['limit'])) {
            
            $name = $_POST['activename'];
            $limit = $_POST['limit'];
            $startdate = $_POST['startdate'];
            $enddate = $_POST['enddate'];
            $bringwith = $_POST['bringwith'];
            $userid = $_POST['userid'];
            $username = $_POST['username'];
            
            $showArray = Array();
            
         	$row = $crud->creatactive($name,$limit,$startdate,$enddate,$bringwith);
        	//$row = $pdo->lastInsertId(); 最後一個activeID
        	
        	$member = $crud->addmember($row,$userid,$username);
        	
        	$active = $crud->getactive($row);
        	
        	$showArray['active'] = $active;
        	
        	$this->view('show',$showArray);
        }
    }
    
    function signup() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            
            $signupArray = Array();
            
            $row = $crud->getactive($id);
            
            $signupArray['active'] = $row;
            
            $this->view("signup",$signupArray);
        }
    }
    
    function check() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_POST["button"])){
            $activeID = $_POST["activeID"];
            $userid = $_POST["userid"];
            $username = $_POST["username"];
            
            $checkArray = Array();
            
            $row = $crud->getmember($activeID,$userid,$username);
            
            if($row>0) {
                $this->view("index");
            }
            else if($row == FALSE){
                $test = $crud->getactive($activeID);
                
                $checkArray['active'] = $test; 
                
                $this->view("signup",$checkArray);
            }
        }
    }
    
}

?>
