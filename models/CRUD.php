<?php
class CRUD {
    
    public function creatactive($name,$limit,$startdate,$enddate,$bringwith) {
        $db = new myPDO();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO `active`(`name`, `limit`, `startdate`, `enddate`, `bringwith`) VALUES (:name, :limit, :startdate, :enddate, :bringwith)";
    	$stmt = $pdo->prepare($sql);
    	
    	$stmt->bindValue(':name',$name);
    	$stmt->bindValue(':limit',$limit);
    	$stmt->bindValue(':startdate',$startdate);
    	$stmt->bindValue(':enddate',$enddate);
    	$stmt->bindValue(':bringwith',$bringwith);
    	
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
    	
    	for($i=0 ; $i<count($userid) ; $i++){
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
    
}
?>