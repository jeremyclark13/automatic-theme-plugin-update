<?php
/*
*
* One Time Download
* Jacob Wyke
* jacob@frozensheep.com
*
*/

//The directory where the download files are kept - random folder names are best
$strDownloadFolder = "./update/";

//If you can download a file more than once
$boolAllowMultipleDownload = 0;

//connect to the DB

/***********************
DATABASE INFO
************************/

  $resDB = mysql_connect("DB_SERVER", "DB_USER", "DB_PASSWORD");
  mysql_select_db("DB_NAME", $resDB);

if(!empty($_GET['key'])){
  //check the DB for the key
  $resCheck = mysql_query("SELECT * FROM downloads WHERE downloadkey = '".mysql_real_escape_string($_GET['key'])."' LIMIT 1");
  $arrCheck = mysql_fetch_assoc($resCheck);
  if(!empty($arrCheck['file'])){
    //check that the download time hasnt expired
    if($arrCheck['expires']>=time()){
      if(!$arrCheck['downloads'] OR $boolAllowMultipleDownload){
        //everything is hunky dory - check the file exists and then let the user download it
        $strDownload = $strDownloadFolder.$arrCheck['file'];
        
        if(file_exists($strDownload)){
          
          //get the file content
          $strFile = file_get_contents($strDownload);
          
          //set the headers to force a download
          header("Content-type: application/force-download");
          header("Content-Disposition: attachment; filename=\"".str_replace(" ", "_", $arrCheck['file'])."\"");
          
          //echo the file to the user
          echo $strFile;
          
          //update the DB to say this file has been downloaded
          mysql_query("UPDATE downloads SET downloads = downloads + 1 WHERE downloadkey = '".mysql_real_escape_string($_GET['key'])."' LIMIT 1");
          
          exit;
          
        }else{
          echo "We couldn't find the file to download.";
        }
      }else{
        //this file has already been downloaded and multiple downloads are not allowed
        echo "This file has already been downloaded.";
      }
    }else{
      //this download has passed its expiry date
      echo "This download has expired.";
    }
  }else{
    //the download key given didnt match anything in the DB
    echo "No file was found to download.";
  }
}else{
  //No download key wa provided to this script
  echo "No download key was provided. Please return to the previous page and try again.";
}

?>