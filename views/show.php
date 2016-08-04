<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Show Active</title>

    <!-- Bootstrap Core CSS -->
    <link href="../views/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../views/css/business-casual.css" rel="stylesheet">
    <link href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="/resources/demos/style.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="../views/js/main.js"></script>
</head>

<body>
    <?php require_once "indexmenu.php"; ?>
    
    <div class="container">
        <div class="row">
            <div class="box">
                <?php 
                $showArray = $data;
                $activeID = $showArray["active"][0]["activeID"]
                    // var_dump($showArray['active'][0]['name']);
                    // exit;
                ?>
                <table class="table table-bordered">
                    <tr class="info">
                        <td>活動名稱</td>
                        <td>報名人數上限</td>
                        <td>報名截止時間</td>
                        <td>是否可攜伴</td>
                    </tr>
                    <tr>
                        <td><?php echo $showArray["active"][0]["name"]; ?></td> 
                        <td><?php echo $showArray["active"][0]["limit"]; ?></td> 
                        <td><?php echo $showArray["active"][0]["enddate"]; ?></td>
                        <td>
                            <?php 
                            if ($showArray["active"][0]["bringwith"]==1){
                                echo "可攜伴";
                            }else{
                                echo"不可攜伴";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <h4>報名網址:</h4></br>
                <p><?php echo '<a href="signup?&id='.$activeID.'";>https://testweb-lid-chen.c9users.io/Event_Register/Home/signup?&id='.$activeID.'</a>'; ?> </p>
            </div>
        </div>
    </div>
    <!-- /.container -->
    
</body>

</html>