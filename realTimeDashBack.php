<?php
//session_start();
  require __DIR__ . '/database.php';
  //include 'testing.php';
  $db = DB();
  $addTimeWO = "";
  $addTimeFB = "";
  $latestTime = "";
  $latestDate = "";
  $addDateWO = "";
  $addDateFB = "";
/*************IT FEEDEBACK RECORD */

    //select data for new with no pic
    $openNoITdata =  $db->prepare( "  SELECT *
                                      FROM dbo.SY_0600 
                                      WHERE [Status] = 'OPEN'
                                      AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                      AND [PIC] IS NULL
                                      ORDER BY FBNo DESC
                            ");
    $openNoITdata->execute();


    //FOR TELEGRAM PURPOSE
   /* $openNOPICdata = $db->prepare( "  SELECT *
                                      FROM dbo.SY_0600 
                                      WHERE [Status] = 'OPEN'
                                      AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                      AND [PIC] IS NULL
                                      ORDER BY FBNo ASC
                                  ");
    $openNOPICdata->execute();

    $apiToken = '5534095064:AAGfuaj6UbL55zqmfEcgEeGyOMXocBzmQlE';

    while ($colA = $openNOPICdata->fetch(PDO::FETCH_ASSOC)) {

      $JobNo = $colA['FBNo'];
      $AddUser = $colA['AddUser'];
      $Service = $colA['Service'];
      $Date =  $colA['AddDate'];
      $Time = $colA['AddTime']; 

    }

    $data = array("\nJob No : " . $JobNo . "\nAdd User : " . $AddUser .
                  "\nService : " . $Service .  "\nDate : "  . date('d/M/Y', strtotime($Date))   .
                "\nTime : " .  date("h:i A", strtotime($Time))  );

    $response = file_get_contents("https://api.telegram.org/bot".$apiToken."/sendMessage?chat_id=-1001785753372&text=" .http_build_query ($data)  ); 
    */

  
   /* $openNoITdata1 =  $db->prepare( "  SELECT *
                                      FROM dbo.SY_0600 
                                      WHERE [Status] = 'OPEN'
                                      AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                      AND [PIC] IS NULL
                                      ORDER BY FBNo ASC
                                
                            ");
    $openNoITdata1->execute();

    while ($col9 = $openNoITdata1->fetch(PDO::FETCH_ASSOC)) {
        
      $idNo = $col9['FBNo'];
        $data = array(
          'FBNo'   => $idNo
        );
        //echo json_encode($data);
    } */

    /****************WORK ORDER RECORD*/
    //count
    /*$openNoWO =  $db->prepare( "  SELECT count([WorkNo])
                                FROM dbo.IN_0080 
                                WHERE [Status] = 'OPEN'
                                AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                AND [InCharge] IS NULL
                            " );
    $openNoWO->execute();
    $countopenNoWO = $openNoWO->fetchColumn(); */

    //select data for new with no pic
    $openNoWO =  $db->prepare( "  SELECT *
                                  FROM dbo.IN_0080 
                                  WHERE [Status] = 'OPEN'
                                  AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                  AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                  AND [InCharge] IS NULL
                                  ORDER BY WorkNo DESC
                            " );
   $openNoWO->execute();

    /****************************************LAST 30 DAYS  */
    /*********IT FEEDBACK */
    //COUNT NEW WITH NO PIC 
    $openNoIT =  $db->prepare( "  SELECT count([FBNo])
                                  FROM dbo.SY_0600 
                                  WHERE [Status] = 'OPEN'
                                  AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                  AND [PIC] IS NULL
                                  AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                            ");
    $openNoIT->execute();
    $countOpenNoIT30 = $openNoIT->fetchColumn();

    //openwithpic
    $openWithPICIT =  $db->prepare( "   SELECT count([FBNo])
                                        FROM dbo.SY_0600 
                                        WHERE [Status] = 'OPEN'
                                        AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                        AND [PIC] IS NOT NULL
                                        AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                                    ");
    $openWithPICIT->execute();
    $countopenWithPICIT30 = $openWithPICIT->fetchColumn();

    //outstanding
    $outstandingIT =  $db->prepare( "   SELECT count([FBNo])
                                        FROM dbo.SY_0600 
                                        WHERE [Status] != 'COMPLETED' 
                                        AND [Status] != 'CANCEL'
                                        AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                            ");
    $outstandingIT->execute();
    $countoutstandingIT30 = $outstandingIT->fetchColumn();

    //completed
    $completedIT =  $db->prepare( "   SELECT count([FBNo])
                                      FROM dbo.SY_0600 
                                      WHERE [Status] = 'COMPLETED' 
                                      AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                            ");
    $completedIT->execute();
    $countcompletedIT30 = $completedIT->fetchColumn();

    /************WORK ORDER */
    //count new with no pic
    $openWO =  $db->prepare( "  SELECT count([WorkNo])
                                FROM dbo.IN_0080 
                                WHERE [Status] = 'OPEN'
                                AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                AND [InCharge] IS NULL
                                AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                            " );
    $openWO->execute();
    $countopenWO30 = $openWO->fetchColumn();

    //openwithpic
    $openWithPICWO =  $db->prepare( "  SELECT count([WorkNo])
                                        FROM dbo.IN_0080 
                                        WHERE [Status] = 'OPEN'
                                        AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                        AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                        AND [InCharge] IS NOT NULL
                                        AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                                    ");
    $openWithPICWO->execute();
    $countopenWithPICWO30 = $openWithPICWO->fetchColumn();

    //outstanding 
    $outstandingWO =  $db->prepare( "  SELECT count([WorkNo])
                                        FROM dbo.IN_0080  
                                        WHERE [Status] != 'COMPLETED' 
                                        AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                        AND [Status] != 'CANCEL'
                                        AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                                    ");
    $outstandingWO->execute();
    $countoutstandingWO30 = $outstandingWO->fetchColumn();

    //completed
    $completedWO =  $db->prepare( " SELECT count([WorkNo])
                                    FROM dbo.IN_0080  
                                    WHERE [Status] = 'COMPLETED' 
                                    AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                    AND DATEDIFF(day,AddDate,GETDATE()) between 0 and 30 
                                ");
    $completedWO->execute();
    $countcompletedWO30 = $completedWO->fetchColumn();

    //select date 30 days before the current date
    /*$daysbefore = $db->prepare("SELECT DATEADD(DAY, -29, cast(GETDATE() as date))");
    $daysbefore->execute();

    echo $daysbefore; */

    //date 30 days before the current date
    $daysBefore = date('d/M/Y', strtotime('-29 days'));
    //echo $d2;

    //current date
    $currentDate = date('d/M/Y');

    //GET LAST UPDATED ROW NEWLY ADDED feedback
    $getLastUpdatedFB = $db->prepare("SELECT TOP 1 AddDate, AddTime
                                    FROM [AINDATA].[dbo].[SY_0600]
                                    WHERE [AddDate] >= DATEADD(day,-1,GETDATE())
                                    AND [Status] = 'OPEN'
                                    ORDER BY AddTime DESC"); 
    $getLastUpdatedFB->execute();

    ///GET LAST UPDATED ROW NEWLY ADDED work order
    $getLastUpdatedWO = $db->prepare("SELECT TOP 1 AddDate, AddTime
                                    FROM [AINDATA].[dbo].[IN_0080]
                                    WHERE Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                    AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                    AND [Status] = 'OPEN'
                                    ORDER BY AddTime DESC"); 
    $getLastUpdatedWO->execute();

    while ($col = $getLastUpdatedFB->fetch(PDO::FETCH_ASSOC)) {

        $addDateFB = date('d/M/Y', strtotime($col['AddDate']));
        $addTimeFB = date("h:i A", strtotime($col['AddTime']));

    }

    while ($col2 = $getLastUpdatedWO->fetch(PDO::FETCH_ASSOC)) {

        $addDateWO = date('d/M/Y', strtotime($col2['AddDate']));
        $addTimeWO = date('h:i A', strtotime($col2['AddTime'])); 

    }
    
    //$addTimeWO = "";

          if ($addTimeFB > $addTimeWO) {

              $latestTime = $addTimeFB;
              $latestDate = $addDateFB;

          } else {
              $latestTime = $addTimeWO;
              $latestDate = $addDateWO;
          }
          //echo $latestTime;
 


      //get latest id feedback 
      $latestfbID = $db->prepare("  SELECT TOP 1 FBNo
                                  FROM [AINDATA].[dbo].[SY_0600]
                                  where [AddDate] >= DATEADD(day,-1,GETDATE())
                                  AND [Status] = 'OPEN'
                                  ORDER BY FBNo DESC
                              ");
      $latestfbID->execute();

      while ($col5 = $latestfbID->fetch(PDO::FETCH_ASSOC)) {

         $idfb = $col5['FBNo'];
      }
    
      //get latest id work order
      $latestwoID = $db->prepare("SELECT TOP 1 WorkNo
                                  FROM [AINDATA].[dbo].[IN_0080]
                                  WHERE Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                  AND [AddDate] >= DATEADD(day,-1,GETDATE())
                                  AND [Status] = 'OPEN'
                                  ORDER BY WorkNo DESC
                                ");
      $latestwoID->execute();

      while ($col6 = $latestwoID->fetch(PDO::FETCH_ASSOC)) {
        
        $idwo = $col6['WorkNo'];
     }




?>