<?php
    session_start();
    $name="";
    $gender="";
    $mobno="";
    $dob="";
    $email="";
    $status="";
    $i=0;
    if(isset($_SESSION['auth'])=='true'){
    $serverName = ""; // update me
        $connectionOptions = array(
        "Database" => "maindatabase", // update me
        "Uid" => "", // update me
        "PWD" => "" // update me
        );
        //Establishes the connection
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if($conn==false){
            die(print_r(sqlsrv_errors(), true));
        }else{
            // echo "Connection Redy";
            // left info..
            $sql="SELECT * FROM users";
            $results=sqlsrv_query($conn,$sql);
            // print_r($details);
            if (isset($_GET['id'])) {
                $mobno=$_GET['id'];
                $_SESSION['mobno']=$mobno;
                // echo $mobno;
                $basicinfo="SELECT * FROM users WHERE mobno='$mobno'";
                $basicinf_r=sqlsrv_query($conn,$basicinfo);
                $basicinf_det=sqlsrv_fetch_array($basicinf_r,SQLSRV_FETCH_ASSOC);
                // print_r($basicinf_det);
                $email=$basicinf_det['email'];
                $name=$basicinf_det['name'];
                $gender=$basicinf_det['gender'];
                $dob=$basicinf_det['dob'];
                $status=$basicinf_det['status'];
            } 
            
            if (isset($_SESSION['mobno'])){     
                $mobno=$_SESSION['mobno'];
                $basicinfo="SELECT * FROM users WHERE mobno='$mobno'";
                $basicinf_r=sqlsrv_query($conn,$basicinfo);
                $basicinf_det=sqlsrv_fetch_array($basicinf_r,SQLSRV_FETCH_ASSOC);
                // print_r($basicinf_det);
                $email=$basicinf_det['email'];
                $name=$basicinf_det['name'];
                $gender=$basicinf_det['gender'];
                $dob=$basicinf_det['dob'];
                $status=$basicinf_det['status'];
                
            }
            // if (isset($_GET['se'])==1) {
            //     session_unset();
            //     session_destroy();
            //     header("Location: admin.php");
            //     exit();
                    
            // }

            if (isset($_POST['se'])) {
                if ($_POST['status'] == 'close') {
                    // echo $_POST['status'];
                $sql="UPDATE users SET status='Closed' WHERE mobno='$mobno'";
                $results=sqlsrv_query($conn,$sql);
                }
                session_unset();
                session_destroy();
                header("Location: admin.php");
                exit();
            }


            $tablename="a$mobno";
            // echo $tablename;
            $message_info="SELECT * FROM $tablename ORDER BY i";
            $message_res=sqlsrv_query($conn,$message_info);
            // $message_det=sqlsrv_fetch_array($message_res,SQLSRV_FETCH_ASSOC);
            // print_r($message_det);
            
            if(array_key_exists("send",$_POST)) {
                // echo "Ready";
                $message = $_REQUEST['message'];
                // print_r($message);
                date_default_timezone_set('Asia/Kolkata');
                $date = date('d-m-Y', time());
                $time = date('H:i:s',time());
                // echo $message."=>".$time."=>".$date."=>".$i+1;
                $p="SELECT count(*) from $tablename;";
                $q=sqlsrv_query($conn,$p);
                $j=sqlsrv_fetch_array($q,SQLSRV_FETCH_ASSOC);
                // print_r($j['']);
                $i=$j['']+1;
                
                $sql="INSERT INTO $tablename(sender,message,time,date,i)VALUES ('A','$message','$time','$date','$i')";
                $results=sqlsrv_query($conn,$sql);
                if ($results){
                    // echo "Inserted";
                    $_SESSION['mobno']=$mobno;
                    header("Location: chat_app.php");
                }else{
                    echo "Not Inserted";
                }
            }
        }
    }else{
        header("Location: admin.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>chat app - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="chat_app.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="admin.js"></script>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="container">
<div  class="basic-info clearfix">

    <div class="label-2"><label>Contact No</label>
        <input type="" name="" placeholder="Mobile number" readonly value=" <?php echo $mobno ?>" class="cl1">
    </div>

    <div class="label-2"><label>Email Id</label>
        <input type="" name="" placeholder="Email id" readonly value="<?php echo $email ?>" class="cl1">
    </div>

    <div class="label-2"><label>Gender</label>
    <input type="" name="" placeholder="Gender" readonly value="<?php echo $gender?>">
    </div>
    <div class="label-2"><label>Date Of Birth</label>
    <input type="" name="" placeholder="Date of birth" readonly value="<?php echo $dob ?>">
    </div>
    
    
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card chat-app">
            <div id="plist" class="people-list">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search..." id="my-input" onkeyup ="search()">
                </div>
                <ul class="list-unstyled chat-list mt-2 mb-0" id="ul">
                    
                <?php 
                
                   while( $row = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC)) {
                    // echo $row['name'];
                        $statusinfo="<i class='fa fa-circle offline'></i> Closed";
                        if($row['status']=='open'){$statusinfo="<i class='fa fa-circle online'></i> Opened";}
                        if ($row['gender']=='Male') {
                            // echo "Male";
                            // if($row['status']=='open')
                            echo "<li class='clearfix'><a href='chat_app.php?id=".$row['mobno']."' title='view more'>
                                <img src='avatar1.png' alt='avatar'>
                                <div class='about'>
                                    <div class='name'>".$row['mobno']."</div>
                                    <div class='status'>".$statusinfo."</div>
                                </div></a>
                            </li>";
                        }
                        else if ($row['gender']=='Female'){
                            // echo "Female";
                            echo "<li class='clearfix'><a href='chat_app.php?id=".$row['mobno']."' title='view more'>
                                <img src='avatar2.png' alt='avatar'>
                                <div class='about'>
                                    <div class='name'>".$row['mobno']."</div>
                                    <div class='status'> ".$statusinfo."</div>
                                </div></a>
                            </li>";
                        }else {
                            // echo "NULL";
                            echo "<li class='clearfix'><a href='chat_app.php?id=".$row['mobno']."' title='view more'>
                                <img src='avatar3.png' alt='avatar'>
                                <div class='about'>
                                    <div class='name'>".$row['mobno']."</div>
                                    <div class='status'> ".$statusinfo."</div>
                                </div></a>
                            </li>";
                        }
                    }
                    
            ?>
                                                      
                   
                </ul>
            </div>

            
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                            </a>
                            <div class="chat-about">
                                <h6 class="m-b-0"><?php echo $name ?></h6>
                                <h6><?php echo $mobno ;?></h6>
                            </div>
                        </div>
                        <div class="col-lg-6 hidden-sm text-right">
                            <form method="POST">
                                <label>Status</label>
                                <select name="status" class="btn btn-outline-primary" title="Change status">
                                    <option><?php echo $status ?></option>
                                    <option value="open" class='fa fa-circle online'>Opened</option>
                                    <option value="close" class='fa fa-circle offline'>Closed</i></option>
                                </select>
                                <button class="btn btn-outline-info" title="save&exit" name="se">Save&Exit <i class="fa fa-save"></i></button>
                            </form>
                            
                        </div>
                    </div>
                </div>

                <div class="chat-history" id="chatbox">
                    <ul class="m-b-0">
                        
                        <?php
                            if( $message_res === false) {
                                die( print_r( sqlsrv_errors(), true) );
                            }else{
                            
                            while($row2=sqlsrv_fetch_array($message_res,SQLSRV_FETCH_ASSOC)){
                                // echo $row2['message'];
                                if ($row2['sender']=='A') {
                                    // echo $row2['message'];
                                    echo "<li class='clearfix'>
                                                <div class='message-data text-right'>
                                                    <span class='message-data-time'>".$row2['date']." ( ".$row2['time']." )</span>
                                                    <img src='avatar4.png' alt='avatar'>
                                                </div>
                                                <div class='message other-message float-right'>".$row2['message']."</div>
                                            </li>";
                                }else if ($row2['sender']=='U') {
                                    echo "<li class='clearfix'>
                                                <div class='message-data'>
                                                    <span class='message-data-time'>".$row2['date']." ( ".$row2['time']." )</span>
                                                </div>
                                                <div class='message my-message'>".$row2['message']."</div>
                                            </li>";
                                }
                            }
                        }
                           
                        ?>                              
                       
                    </ul>
                </div>

                <div class="chat-message clearfix">
                    <form method="POST">
                    <div class="input-group mb-0">
                        <textarea id="textarea"type="text" class="form-control" placeholder="Enter text here..." name='message' required></textarea>
                        <div class="input-group-prepend">
                            <button name="send" class="input-group-text" id="send"><i class="fa fa-send"></i></button>
                        </div>
                                                            
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var element = document.getElementById("chatbox");
    element.scrollTop = element.scrollHeight;
</script>
</body>
</html>
