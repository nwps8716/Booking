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
            $status = $_POST['status'];
            
            $showArray = Array();
            
         	$row = $crud->creatactive($name,$limit,$startdate,$enddate,$bringwith,$limit);
    
        	$member = $crud->addmember($row,$userid,$username,$status);
        	
        	$url = $crud->geturl($row);
        	
        	$active = $crud->getactive($url);

        	$showArray['active'] = $active;
        	
        	$this->view('show',$showArray);
        }
    }
    
    function signup() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        if(isset($_GET['id'])){
            $url = $_GET['id'];
            
            $signupArray = Array();
            
            $row = $crud->getactive($url);
            
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
            
            $status = $crud->getmemberstatus($activeID,$userid);
            
            $row = $crud->checkmember($activeID,$userid,$username);
            
            $url = $crud->geturl($activeID);
            if($row>0) {
                
                $test = $crud->getactive($url);
                $checkArray['active'] = $test;
                
                $newcount = $test[0]["count"] - $bringwith;  //確認報名餘額
                if($newcount >= 0 && $status['status'] == 0){
                    $count = $crud->updatecount($newcount,$activeID);
                    $status = $crud->updatestatus($activeID,$userid);
                    $this->view("index");
                }else if($test[0]["count"] == 0){
                    $message = $crud->countmessage();
                    $this->view("signup",$checkArray);
                }else if($newcount < 0 && $status['status'] == 0){
                    $message = $crud->message();
                    $this->view("signup",$checkArray);
                }else if($status['status'] == 1){
                    $message = $crud->statusmessage();
                    $this->view("signup",$checkArray);
                }
                
            }
            else if($row == FALSE){
                
                $test = $crud->getactive($url);
                
                $checkArray['active'] = $test; 
                
                $this->view("signup",$checkArray);
            }
        }
    }
    
    function ajaxgetconut($url){
        $this->model("CRUD");
        $crud = new CRUD();
        
        $row = $crud->getactive($url);
        $this->view("showajaxcount",$row[0]['count']);
    }
}

?>
