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
            
         	$row = $crud->creatactive($name,$limit,$startdate,$enddate,$bringwith,$limit);
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
            
            $startdate = new DateTime($signupArray["active"][0]['startdate']);
            $enddate = new DateTime($signupArray["active"][0]['enddate']);
            $enddate->add(new DateInterval('P1D')); //為截止日的隔天凌晨00:00 +1天
            
            date_default_timezone_set('Asia/Taipei');
            $nowdate = new DateTime("now");;
            
            if($nowdate < $startdate){
                echo "報名時間為:".$signupArray["active"][0]['startdate'];
                exit;
            }
            else if($nowdate > $enddate){
                echo "已經超過報名時間囉";
                exit;
            }
            
            $this->view("signup",$signupArray);
        }
    }
    
    function checksignup() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_POST["button"])){
            $activeID = $_POST["activeID"];
            $userid = $_POST["userid"];
            $username = $_POST["username"];
            $bringwith = $_POST["bringwith"];
            
            $bringwith = $bringwith + 1; //報名人加上攜伴人數
            
            $checkArray = Array();
            
            $row = $crud->getmember($activeID,$userid,$username);
            
            if($row>0) {
                $test = $crud->getactive($activeID);
                // var_dump($test[0]["count"]); 取出count值
                // exit;
                $newcount = $test[0]["count"] - $bringwith;
                if($newcount >= 0){
                    $count = $crud->updatecount($newcount,$activeID);
                    $this->view("index");
                }else{
                    $checkArray['active'] = $test;
                    $message = $crud->message();
                    $this->view("signup",$checkArray);
                }
                
            }
            else if($row == FALSE){
                $test = $crud->getactive($activeID);
                
                $checkArray['active'] = $test; 
                
                $this->view("signup",$checkArray);
            }
        }
    }
    
    function ajaxgetconut($id){
        $this->model("CRUD");
        $crud = new CRUD();
        
        $row = $crud->getactive($id);
        $this->view("showajaxcount",$row[0]['count']);
    }
}

?>
