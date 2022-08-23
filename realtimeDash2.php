<?php
    
    include 'realTimeDashBack.php';
    //$idNo = $idfb;

    //echo session_id();

    $_SESSION["currentIDwo"] = "";
    $_SESSION["currentID"] = "";

?>
<html>
    <head>
        <link rel="stylesheet" href="admins/dist/css/adminlte.min.css">
    </head>
    <style>
        .blueish {
            background-color: #DDEEFF  !important;
        }
        .greenish {
            background-color: #E7FEEC  !important;
        }

        .bg-card1 {
          background-color: #D8F6FF !important;
        }
        .bg-card2 {
          background-color: #D3FFD7 !important;
        }
        .body-bg {
          background-color : #FFEEEE !important;
        }

    
    </style>
    <body class="body-bg">
         <!-- Main content -->
    <div class="content">
      <div class="container-fluid" >
        <div class="row align-items-center" >
            <div class="col-lg-6">
              <div class="col-sm-12 ">
                <?php  include 'headerRealTime.html';   ?>
                <h1 class="float-left">Dashboard IT Feedback & Work Order</h1>
              </div>
              <div class="row col-lg-6">
                    <div class="col-sm-12 ">
                      <h1 class="float-left">IT Division</h1>
                    </div>
                  </div>
            </div>
            <div class="col-lg-6">
              <div class="row">
                  <div class="col-lg">
                  <img src="logotrans.png" alt="ain medicare logo" class="float-right w-50">
                  </div>
                </div>
                <h3 class="float-right">Today <?php echo $currentDate;  ?> - <span id='ct7'></span> </h3>
            </div>
        
          <div class="col-lg-6" >
            <div class="card bg-card1" >
              <div class="card-header border-0">
                <div class="d-flex justify-content-center">
                  <h2>Today's New Job Request(with no PIC)</h2>
                </div>
                <!--<div class="d-flex justify-content-center">
                  <h5><?php echo $currentDate;  ?></h5>
                </div> -->
                <div class="d-flex justify-content-center">
                    
                </div>
              </div>
              <div class="card-body pt-0" >
                <div class="d-flex">
                    <table class="table table-bordered table-hover table-borderless h5 font-weight-normal" >
                    <thead class="table-primary text-center">
                    <tr>
                            <th>No</th>
                            <th>Job No</th>
                            <th>Requestor</th>
                            <th>Service Type</th>
                            <th>Date/Time Issue</th>
                    </tr>
                    </thead>
                    <tbody class="blueish text-center" >
                    
                    <?php 

                            $counter = 1;
                            while ($row = $openNoITdata->fetch(PDO::FETCH_ASSOC)) { 
                              
                              if ($counter == 1) {
                                  //echo $counter;
                                  $_SESSION["currentID"] = $row['FBNo'];
                              }

                              /*if (!isset($_SESSION["oldID"])) {
                                $_SESSION["oldID"] = $_SESSION["currentID"]; 
                              }
                              //copy of old id, keep old id before new data added
                              $_SESSION["copyOldID"] = $_SESSION["oldID"];

                              /*if ($_SESSION["oldID"] == $_SESSION["currentID"]) { 
                                    echo "aa";  */ ?>
                    <tr>       
                                <td ><?php echo $counter++;  ?></td>
                                <td><?php echo $row['FBNo']; ?></td>
                                <td><?php echo $row['AddUser']; ?></td>
                                <td><?php echo $row['Service']; ?></td>
                            <?php if ($row['FBNo'] == $idfb ) { ?>
                                  <!--$images = "<img src='new-post.gif' alt='new-post'  height='30'>"; -->
                                <td ><?php echo date('d/M/Y', strtotime($row['AddDate'])); echo "  " . date("h:i A", strtotime($row['AddTime']));?> <img src='new-sticker.gif' alt='new-post'  height='35'>
                                </td>
                           <?php }  else { ?>
                                <td><?php echo date('d/M/Y', strtotime($row['AddDate'])); echo "  " . date("h:i A", strtotime($row['AddTime']));  ?> </td>
                            <?php }  ?>
                    </tr>           
                            <?php 
                            }
                            //echo $_SESSION["copyOldID"];echo $_SESSION["currentID"];
                  
                                if (!isset($_SESSION["oldID"])) {
                                      $_SESSION["oldID"] = $_SESSION["currentID"]; 
                                    }
                                     $_SESSION["copyOldID"] = $_SESSION["oldID"];

                                //nak buat condition first kluar and stop utk next condition jgn bunyi sound bilo refresh 2 minit 
                                //?? 
                                if ($_SESSION["copyOldID"] < $_SESSION["currentID"]) {
                                    $_SESSION["oldID"] = $_SESSION["currentID"]; //echo "aaaa";

                                      //for tele noti
                                      $openNOPICdata = $db->prepare( "  SELECT *
                                                                      FROM dbo.SY_0600 
                                                                      WHERE [Status] = 'OPEN'
                                                                      AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                                                      AND [PIC] IS NULL
                                                                      ORDER BY FBNo ASC
                                                                  ");
                                      $openNOPICdata->execute();

                                     //$apiToken = '5534095064:AAGfuaj6UbL55zqmfEcgEeGyOMXocBzmQlE';
                                     $apiToken = '5396046675:AAGbKO52X4njVuAAzSSKdVWKKaNkvWMKXl0';
                                    //  $chat_id = '-1001785753372';
                                    // chat id = -636777393


                                      while ($colA = $openNOPICdata->fetch(PDO::FETCH_ASSOC)) {

                                         /* $JobNo = $colA['FBNo'];
                                          $AddUser = $colA['AddUser'];
                                          $Service = $colA['Service'];
                                          $Date =  $colA['AddDate'];
                                          $Time = $colA['AddTime']; */
 
                                          $data = array( 'text' => "\nJob No : " . $colA['FBNo'] . "\nRequestor : " . $colA['AddUser'] .
                                                            "\nService : " . $colA['Service'] .  "\nDate : "  . date('d/M/Y', strtotime($colA['AddDate']))   .
                                                            "\nTime : " .  date("h:i A", strtotime($colA['AddTime']))  );
                                  
                                      }

                                      $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?chat_id=-636777393&".http_build_query ($data)  );  
                               ?>
                                      <audio controls autoplay hidden>
                                        <source src="bell-notification.wav" type="audio/wav">
                                      </audio>
                              <?php
                                } 
                                //echo "asd";
                               
                                 //echo $_SESSION["currentID"];
                                   
                                    $currentCounter = $counter;
                                   
                              ?>

          
                            <?php while ($row2 = $openNoWO->fetch(PDO::FETCH_ASSOC)) { 

                                  if ($counter == $currentCounter) {
                                    //echo $counter;
                                    $_SESSION["currentIDwo"] = $row2['WorkNo'];
                                  }
                                  
                            ?>  
                    <tr>
                              <td><?php echo $counter++;  ?></td>
                              <td><?php echo $row2['WorkNo']; ?></td>
                        <?php  if (($row2['EmpNo'] && $row2['EName'] ) <> '') { ?>
                              <td><?php echo $row2['EmpNo'] . "@" . $row2['EName'];?></td>
                        <?php } else { ?>
                                <td></td>
                        <?php } ?>
                              <!--<td><?php echo $row2['EmpNo'] . " " . $row2['EName'];?></td> -->
                              <td><?php echo $row2['Service']; ?></td>
                              <?php if ($row2['WorkNo'] == $idwo ) { ?>
                                  <!--$images = "<img src='new-post.gif' alt='new-post'  height='30'>"; -->
                                <td><?php echo date('d/M/Y', strtotime($row2['AddDate'])); echo "  " . date("h:i A", strtotime($row2['AddTime']));?> <img src='new-sticker.gif' alt='new-post'  height='35'>
                              </td>
                           <?php }  else { ?>
                                <td><?php echo date('d/M/Y', strtotime($row2['AddDate'])); echo "  " . date("h:i A", strtotime($row2['AddTime']));  ?> </td>
                            <?php } ?>
                    </tr>
                            <?php }  
                            
                              if (!isset($_SESSION["oldIDwo"])) {

                                $_SESSION["oldIDwo"] = $_SESSION["currentIDwo"]; ?>
                                  
                        
                            <?php }
                                $_SESSION["copyOldIDwo"] = $_SESSION["oldIDwo"];

                            /*  if ($_SESSION["copyOldIDwo"] != $_SESSION["currentIDwo"]) {
                                echo "asassas"; */
                                ?>
                                 
                                <?php
                             /* }  */


                                if ($_SESSION["copyOldIDwo"] < $_SESSION["currentIDwo"]) {
                                  $_SESSION["oldIDwo"] = $_SESSION["currentIDwo"]; 

                                  //echo "abcc";
                                //tele noti
                               $opennopicdataWO = $db->prepare(" SELECT *
                                                                  FROM dbo.IN_0080 
                                                                  WHERE [Status] = 'OPEN'
                                                                  AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                                                  AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                                                  AND [InCharge] IS NULL
                                                                  ORDER BY WorkNo ASC
                                                               ");
                                $opennopicdataWO->execute();

                              $apiToken1 = '5534095064:AAGfuaj6UbL55zqmfEcgEeGyOMXocBzmQlE';

                             // $apiToken1 = '5396046675:AAGbKO52X4njVuAAzSSKdVWKKaNkvWMKXl0';

                              // $apiToken1 = '5405504203:AAFKBsOfaZdTHkGh6jwkpc4_gtwkOQwo4p4';

                                while ($colB = $opennopicdataWO->fetch(PDO::FETCH_ASSOC) ) {

                                  $data1 = array( 'text' => "New IT Task Request Notification" . "\nJob No : " . $colB['WorkNo'] . "\nRequestor : " . $colB['EmpNo']."@". $colB['EName'].
                                                      "\nService : " . $colB['Service'] .  "\nDate : "  . date('d/M/Y', strtotime($colB['AddDate']))   .
                                                      "\nTime : " .  date("h:i A", strtotime($colB['AddTime']))  );
                                }

                                $response = file_get_contents("https://api.telegram.org/bot".$apiToken1."/sendMessage?chat_id=-1001785753372&".http_build_query ($data1)  ); 
                       
                                  ?>
                                      <audio controls autoplay hidden>
                                          <source src="bell-notification.wav" type="audio/wav">
                                      </audio>
                    <?php   } //echo  "current" . $_SESSION["copyOldIDwo"]; //echo $_SESSION["copyOldIDwo"],$_SESSION["currentIDwo"];?>
                              
                    </tbody>
                    </table> 
                </div>

                        <span class="font-italic ">Last Updated On : <?php echo $latestDate . " " .   $latestTime; ?></span>
                <!-- /.d-flex -->
              </div>
            </div>
            <!-- /.card -->
          </div>
          
        
          <!-- /.col-lg-12 -->
   
          <div class="col-lg-6">
            <div class="card bg-card2" >
              <div class="card-header border-0">
                <div class="d-flex justify-content-center">
                    <h2>Feedback & Work Order Status for last 30 days</h2>
                </div>
                <div class="d-flex justify-content-center">
                    <h3 class="text-center font-weight-normal"><?php echo $daysBefore; ?> to <?php echo $currentDate; ?></h3>
                </div>
              </div>
              <div class="card-body pt-0" >
                <div class="row justify-content-center">
                    <table class="table table-bordered table-hover w-100 h5 font-weight-normal">
                        <thead class="text-center table-success">
                            <tr>
                                <th >Feedback</th>
                                <th >Status</th>
                                <th>Work Order</th>
                            </tr>
                        </thead>
                        <tbody class="text-center greenish">
                            <tr>
                                <td><?php echo $countOpenNoIT30; ?></td>
                                <td>Open (No PIC)</td>
                                <td><?php echo $countopenWO30; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $countopenWithPICIT30; ?></td>
                                <td>Open (With PIC)</td>
                                <td><?php echo $countopenWithPICWO30; ?></td>
                            </tr>
                            <tr class="table-warning">
                                <td><?php echo $countoutstandingIT30; ?></td>
                                <td >Outstanding</td>
                                <td><?php echo $countoutstandingWO30; ?></td>
                            </tr>
                            <tr class="table-info">
                                <td><?php echo $countcompletedIT30; ?></td>
                                <td>Completed</td>
                                <td><?php echo $countcompletedWO30; ?></td>
                            </tr>
                       
                        </tbody>
                    </table>
               
                </div>
                <!-- /.d-flex -->

              </div>
            </div>
            <!-- /.card -->
          </div>
          
          <!-- /.col-lg-12 -->

        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

<script>
 
  //auto refresh every 2 minutes 
    setInterval(function(){
      var currTimeHr = new Date().getHours();
      var currTimeMin = new Date().getMinutes();
      if(currTimeHr >= 8){  //start at 8 or at any point after 8am
        if(currTimeMin%2 === 0){  // check every 2 mins
          window.location.reload(true); //refresh page
        }
      }
    }, 1000*60)


    //live time and date 
    function display_ct7() {
      var x = new Date()
      var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
      hours = x.getHours( ) % 12;
      hours = hours ? hours : 12;
      hours=hours.toString().length==1? 0+hours.toString() : hours;

      var minutes=x.getMinutes().toString()
      minutes=minutes.length==1 ? 0+minutes : minutes;

      var seconds=x.getSeconds().toString()
      seconds=seconds.length==1 ? 0+seconds : seconds;

      var month=(x.getMonth() +1).toString();
      month=month.length==1 ? 0+month : month;

      var dt=x.getDate().toString();
      dt=dt.length==1 ? 0+dt : dt;

      var x1=month + "/" + dt + "/" + x.getFullYear(); 
      x1 =  hours + ":" +  minutes + ":" +  seconds + " " + ampm; 
      document.getElementById('ct7').innerHTML = x1; 
      display_c7(); 
      }
      function display_c7(){
      var refresh=1000; // Refresh rate in milli seconds
      mytime=setTimeout('display_ct7()',refresh)
      }
      display_c7()

     /* function display_ct5() {
        var x = new Date();
        var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';

        //console.log(x);

        var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear(); 
        x1 =  x.getHours( )+ ":" +  x.getMinutes() + ":" +  x.getSeconds() + ampm;
        x.getSeconds()=x.getSeconds().length==1 ? 0+seconds : seconds;
        document.getElementById('ct5').innerHTML = x1;
        display_c5();
      }
      function display_c5(){
        var refresh=1000; // Refresh rate in milli seconds
        mytime=setTimeout('display_ct5()',refresh)
      }
      display_c5() */


      
</script>

    </body>
</html>