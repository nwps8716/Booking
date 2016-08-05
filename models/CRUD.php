<?php
class CRUD {
    
    public function creatactive($name,$limit,$startdate,$enddate,$bringwith,$limit) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO `active`(`name`, `limit`, `startdate`, `enddate`, `bringwith`,`count`, `url`) VALUES (:name, :limit, :startdate, :enddate, :bringwith, :count, SUBSTRING(MD5(RAND()) FROM 1 FOR 10) )";
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
    
    
    public function addmember($activeID,$userid,$username,$status){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO `member`(`activeID`,`userid`, `username`, `status`) VALUES (:activeID, :userid, :username, :status)";
        $stmt = $pdo->prepare($sql);
    	
    	for($i=0 ; $i<count($userid) ; $i++){  //可報名活動人員新增到資料庫
    	    $id = $userid[$i];
            $name = $username[$i];
    	    $stmt->bindParam(':activeID',$activeID);
            $stmt->bindParam(':userid',$id);
    	    $stmt->bindParam(':username',$name);
    	    $stmt->bindParam(':status',$status);
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
    
    public function getactive($url){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `active` WHERE `url` = :url";
        $stmt= $pdo->prepare($sql);
        
        $stmt->bindValue(':url',$url);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $db->closeConnection();
	    
	    return $result;
    }
    
    public function geturl($row){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT * FROM `active` WHERE `activeID` = :activeID";
        $stmt= $pdo->prepare($sql);
        
        $stmt->bindParam(':activeID',$row);
        
        $stmt->execute();
        
        $result = $stmt->fetch();
        $db->closeConnection();
	    
	    return $result['url'];
    }
    
    public function checkmember($activeID,$userid,$username){
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
        
        try{
            $pdo->beginTransaction();
            
            $sql = "SELECT `count` FROM `active` WHERE `avtiveID`=:activeID FOR UPDATE ";
            //sleep(5); 用來測試是否有 row lock.
            $sql = "UPDATE `active` SET `count`=:count WHERE `activeID`=:activeID ";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindValue(':count', $newcount);
            $stmt->bindValue(':activeID', $activeID);
            
            $result = $stmt->execute();
    	    $db->closeConnection();
    	    
    	    $pdo->commit();
    	    
    	    if($result) {
    	        $_SESSION['alert'] = "報名成功";
    	        return $result;
	        }else{
	            throw new Exception("你出錯了!");
	        }
	        
        }catch (Exception $error) {
            $pdo->rollBack();
        }
    }
    
    public function updatestatus($activeID,$userid){
        $db = new myPDO();
        $pdo = $db->getConnection();
        
        $sql = "UPDATE `member` SET `status`= 1 WHERE `activeID`=:activeID AND `userid`=:userid";
        $stmt= $pdo->prepare($sql);
        
        $stmt->bindValue(':activeID',$activeID);
        $stmt->bindValue(':userid',$userid);
        
        $result = $stmt->execute();
    	$db->closeConnection();
    }
    
    public function getmemberstatus($activeID,$userid){
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "SELECT `status` FROM `member` WHERE `activeID`=:activeID AND `userid`=:userid";
        $stmt= $pdo->prepare($sql);
        
        $stmt->bindValue(':activeID',$activeID);
        $stmt->bindValue(':userid',$userid);
        
        $stmt->execute();
        $result = $stmt->fetch();
        
        $db->closeConnection();
	    
	    return $result; 
    }
    
    public function message(){
        $_SESSION['alert'] = "此次報名人數超過報名餘額";
    }
    
    public function statusmessage(){
        $_SESSION['alert'] = "你已經報名過了!!";
    }
    
    public function countmessage(){
        $_SESSION['alert'] = "報名人數額滿!!";
    }
}
?>