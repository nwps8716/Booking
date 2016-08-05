<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Create Active</title>

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
                <div class="test2 col-xs-12 col-sm-12 col-md-4 well well-sm">
                    <legend  align="center">建立活動</legend>
                    
                    <form action="create" method="post" class="form" role="form">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <label>活動名稱:</label>
                            <input class="form-control" name="activename" type="text" required autofocus />
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <label>人數限制:</label>
                            <input class="form-control" name="limit" type="number" min="0" value="0" required />
                        </div>
                    </div>
                    <label>報名起始日期:</label>
                        <input  name="startdate" id="startdate" maxDate="enddate" > <br /><br />
                    <label>報名結束日期:</label>
                        <input  name="enddate" id="enddate" minDate="startdate" > <br /><br />
                        
                    <label class="radio-inline">
                        <input type="radio" name="bringwith" value="1" />
                        攜伴
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="bringwith" value="0" />
                        不能攜伴
                    </label>
                    <!-- 這邊設定table的id 讓javascript用 -->
                    <div>
                        <table id="mytable" width="200">
                          <tr>
                            <td width="200" class="td01">員工編號</td>
                            <td width="200" class="td01">員工姓名</td>
                          </tr>
                          <tr>
                            <td>
                            <input name="userid[]" type="text" size="12">
                            </td>
                            <td>
                            <input name="username[]" type="text" size="12">
                            </td>
                          </tr>
                        </table>
                        <input type="button" value="新增一欄" onclick="add_new_data()"> 
                        <input type="button" value="減少一欄" onclick="remove_data()"><br />
                    </div>
                    <br />
                    <input type="hidden" name="status" value="0">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">送出</button>
                    </form>
                    
                </div>
            
            </div>
        </div>
    </div>
    <!-- /.container -->
    
</body>

</html>