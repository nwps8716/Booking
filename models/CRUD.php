<?php
class CRUD {
    
    public function creatactive($name,$limit,$startdate,$enddate,$bringwith,$limit) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO `active`(`name`, `limit`, `startdate`, `enddate`, `bringwith`,`count`) VALUES (:name, :limit, :startdate, :enddate, :bringwith, :count)";
    	$stmt = $pdo->prepare($sql);
    	
    	$stmt->bindValue(':name',$name);
    	$stmt->bindValue(':limit',$limit);
    	$stmt->bindValue(':startdate',$startdate);
    	$stmt->bindValue(':enddate',$enddate);
    	$stmt->bindValue(':bringwith',$bringwith);
    	$stmt->bindValue(':count',$limit);  //用來計算報名人數的欄位
    	
    	$result = $stmt->execute();
    	$result = $pdo->lastInsertId();  //抓到最後一個activeID，丟給addmember使用
    	
    	$db->closeConnection();
    	
    	return $result;
    }
    
    public function addmember($activeID,$userid,$username){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO `member`(`activeID`,`userid`, `username`) VALUES (:activeID, :userid, :username)";
        $stmt = $pdo->prepare($sql);
    	
    	for($i=0 ; $i<count($userid) ; $i++){  //可報名活動人員新增到資料庫
    	    $id = $userid[$i];
            $name = $username[$i];
    	    $stmt->bindParam(':activeID',$activeID);
            $stmt->bindParam(':userid',$id);
    	    $stmt->bindParam(':username',$name);
            $result = $stmt->execute();
    	}
    	
    	$db->closeConnection();
    	
    	if($result>0) {
    	    $_SESSION['alert'] = "活動新增成功";
    	    return $result;
    	}else{
    	    $_SESSION['alert'] = "活動新增失敗";
        }
    }
    
    public function getactive($activeID){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `active` WHERE `activeID` = :activeID";
        $stmt= $pdo->prepare($sql);
        
        $stmt->bindParam(':activeID',$activeID);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $db->closeConnection();
	    
	    return $result; 
    }
    
    public function getmember($activeID,$userid,$username){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `member` WHERE `activeID`=:activeID AND `userid`=:userid AND `username`=:username ;";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':activeID', $activeID);
        $stmt->bindValue(':userid', $userid);
        $stmt->bindValue(':username', $username);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $db->closeConnection();
        
        if ($result) {
            $_SESSION['alert'] = "資格符合";
            return $result;
        }else{
            $_SESSION['alert'] = "資格不符";
            return FALSE;
        }
    }
    
    public function updatecount($newcount,$activeID){
        $db = new myPDO();
        $pdo = $db->getConnection();
        
        $sql = "SELECT `count` FROM `active` WHERE `avtiveID`=:activeID FOR UPDATE ";
        //sleep(5);
        $sql = "UPDATE `active` SET `count`=:count WHERE `activeID`=:activeID ";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':count', $newcount);
        $stmt->bindValue(':activeID', $activeID);
        
        $result = $stmt->execute();
	    $db->closeConnection();
	    
	    if($result) {
	        $_SESSION['alert'] = "報名成功";
	        return $result;
	    }
    }
    
    public function message(){
        $_SESSION['alert'] = "此次報名人數超過報名餘額";
    }
    
}
?>