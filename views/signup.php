<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signup Active</title>

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
    <?php require_once "signupmenu.php"; ?>
    
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="test2 col-xs-12 col-sm-12 col-md-4 well well-sm">
                    <?php $signupArray = $data; ?>
                    <legend align="center">活動名稱:<?php echo $signupArray["active"][0]["name"]; ?></legend>
                    <form action="checksignup" name="reg" method="post" class="form" role="form">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <label>員工編號:</label>
                            <input class="form-control" name="userid" type="text" required autofocus />
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <label>員工姓名:</label>
                            <input class="form-control" name="username" type="text" required />
                        </div>
                    </div>
                    
                    <?php if($signupArray["active"][0]["bringwith"]==1) { ?>
                    <label>攜伴人數:</label>
                    <input class="form-control" name="bringwith" type="number" min="0" max="10"/>
                    
                    <?php }else if($signupArray["active"][0]["bringwith"]==0) { ?>
                    <input type="hidden" name="bringwith" value="0"/>
                    <?php echo "<h5>"."此活動無法攜伴參加"."</h5>"; }?>
                    
                    <input type="hidden" name="activeID" value="<?php echo $signupArray["active"][0]["activeID"];?>">
                    <input class=" tn btn-lg btn-primary btn-block" type="submit" name="button" value="報名" />
                    </form>
                    <h3>
                        可報名餘額:
                        <span value="<?php echo $signupArray["active"][0]["url"];?>" id="count"></span>
                    </h3>
                    <script type="text/javascript">
                        setInterval(function()
                        {
                            activeID = $("#count").attr("value");
                            // alert(activeID);
                            $.ajax({url: "/Event_Register/Home/ajaxgetconut/" + activeID,
                            success: function(data){
                            $("#count").html(data);
                            // alert(data);
                            }});
                        },10)
                    </script>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
    <?PHP
    if(isset($_SESSION['alert'])){
        echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
        unset($_SESSION['alert']);
    }
    ?>
</body>

</html>