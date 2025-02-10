
<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$mysqli = link_connect_db();



function alloc_dum_pin($rrr)
{
	$mysqli = link_connect_db();
	
	$c = 0;
	while (1 == 1 /*|| $c <= 10*/)
	{
    	$randomid = mt_rand(100000,999999);
		$randomid = date("y").$randomid;
    	
		$remitapayments_app_record = 0;

    	$stmt_g = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE Regno = '$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
		$remitapayments_app_record = $stmt_g->num_rows;


		$app_client_record = 0;

    	$stmt_g = $mysqli->prepare("SELECT * FROM app_client WHERE vApplicationNo = '$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
		$app_client_record = $stmt_g->num_rows;

		

		$prog_choice_record = 0;

    	$stmt_g = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo = '$randomid';");
    	$stmt_g->execute();
    	$stmt_g->store_result();
		$prog_choice_record = $stmt_g->num_rows;

    	if ($remitapayments_app_record == 0 && $app_client_record == 0 && $prog_choice_record == 0)
    	{
            try
        	{
        		$mysqli->autocommit(FALSE); //turn on transactions
        		
        		$stmt = $mysqli->prepare("UPDATE remitapayments_app SET Regno = '$randomid' WHERE RetrievalReferenceNumber = ? AND Regno = ''");	
        		$stmt->bind_param("s", $rrr);
        		$stmt->execute();
        
        		$stmt = $mysqli->prepare("INSERT IGNORE INTO app_client SET
        		vPassword = 'frsh', 
        		cpwd = '0',
        		vApplicationNo = '$randomid'");
        		$stmt->execute();
        
        		$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries
        		
        		$stmt->close();
        	    $stmt_g->close();
        	    
        	    return $randomid;
        	}catch(Exception $e) 
        	{
        		$mysqli->rollback(); //remove all queries from queue if error (undo)
        		throw $e;
        	}
    	}
    	
    	$c++;
    }
    $stmt_g->close();
}


$orgsetins = settns();

$date2 = date("Y-m-d h:i:s");


if (isset($_REQUEST['ilin']) && isset($_REQUEST['mm']) && isset($_REQUEST['sm']))
{
	$file_chk = check_file('5000000', '1');
	if ($file_chk <> '')
	{
		//echo $file_chk;
		//exit;
	}
	
	$file_name = 'appl_record_inmate.csv';
	$dir_name = "../../ext_docs/docs/";
	$file = $dir_name . '/' . $file_name;
	
	@unlink($file);
	
	if (!move_uploaded_file($_FILES["sbtd_pix"]["tmp_name"], $file))
	{
		echo "We are Sorry, there was an error uploading your file.";exit;
	}else
	{
		chmod($file, 0755);
		log_actv('Uploaded file '.$file);
		
		$handle = fopen("$file", "r");
		
		$c = 0;
		$feed_back = '';
		$feed_back1 = '';
		$feed_back2 = '';
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			if (count($data) <> 9) 
			{
				fclose($handle);
				chmod($file, 0755);
				unlink($file) or die("Couldn't continue process ");

				echo 'There should be 9 columns of data';
				exit;
			}
			
			$afn = trim($data[0]);
			if ($afn == 'x' || strlen($afn) <> 8)
			{
			    $afn = '';
			}
			
			$lastname = trim($data[1]);
			$firstname = trim($data[2]);
			$othernames = trim($data[3]);
			$all_names = $lastname.' '.$firstname.' '.$othernames;
			
			$phone = trim($data[4]);
			
			if (!is_numeric($phone))
			{
			    $feed_back1 .= $afn.' '.$all_names.' '.$phone.' phone number<br>';
			    continue;
			}
			
			if (substr($phone,0,1) <> '0')
			{
			    $phone = '0'.$phone;
			}
			
			$email = trim($data[5]);
			$educat = trim($data[6]);
			if ($educat == 'phd')
			{
			    $educat = 'PRX';
			}else if (strtolower($educat) == 'mphil')
			{
			    $educat = 'PGZ';
			}else if (strtolower($educat) == 'masters')
			{
			    $educat = 'PGY';
			}else if (strtolower($educat) == 'pgd')
			{
			    $educat = 'PGX';
			}else if (strtolower($educat) == 'ug')
			{
			    $educat = 'PSZ';
			}
			
			$amount = trim($data[7]);
			if (!is_numeric($amount))
			{
			    $feed_back1 .= $afn.' '.$all_names.' '.$amount.' invalid amount<br>';
			    continue;
			}
			
			if ($educat == 'PSZ')
			{
			    if ($amount <> 5000)
			    {
			        $feed_back1 .= $afn.' '.$all_names.' '.$amount.' wrong amount<br>';
			        continue;
			    }
			}else if ($educat == 'PRX' || $educat == 'PGZ')
			{
			    if ($amount <> 20000)
			    {
			        $feed_back1 .= $afn.' '.$all_names.' '.$amount.' wrong amount<br>';
			        continue;
			    }
			}else if ($amount <> 7500)
			{
			    $feed_back1 .= $afn.' '.$all_names.' '.$amount.' wrong amount<br>';
			    continue;
			}
			
			$orderid = DATE("dmyHis");
			
			$rrr = trim($data[8]);
			if ($rrr == '')
			{
			     $feed_back1 .= $afn.' '.$all_names.' '.$amount.' no rrr<br>';
			    continue;
			}
			
			if (!is_numeric($rrr))
			{
			     $feed_back1 .= $afn.' '.$all_names.' '.$amount.' invalid rrr<br>';
			    continue;
			}
			
			$date = date("Y-m-d H:i:s");
			
			$rrr_i = $rrr.'_'.$c;
			
    		$stmt = $mysqli->prepare("REPLACE INTO remitapayments_app
    		SET Regno = ?,
            payerName = ?,
            vLastName = ?,
            vFirstName = ?,
            vOtherName = ?,
            payerEmail = ?,
            payerPhone = ?,
            cEduCtgId = ?,
            Amount = ?, 
            vDesc = 'Application Fee', 
            MerchantReference = ?,
            AcademicSession = '".$orgsetins['cAcademicDesc']."',
            tSemester = ".$orgsetins['tSemester'].",
            RetrievalReferenceNumber = ?,
            ResponseCode = '01',
			ResponseDescription = 'Approved',
            TransactionDate = ?,
            Status = 'Successful'");
			$stmt->bind_param("ssssssssdsss", 
			$afn,
			$all_names, 
			$lastname,
    		$firstname, 
			$othernames, 
			$email, 
			$phone, 
			$educat,
			$amount,
			$orderid,
			$rrr_i,
			$date);
			$stmt->execute();
			
			$afn = alloc_dum_pin($rrr_i);
						
			$stmt = $mysqli->prepare("REPLACE INTO prog_choice
			SET vApplicationNo = ?,
			cEduCtgId = ?,
			vLastName = ?,
			vFirstName = ?,
			vOtherName = ?,
			vEMailId = ?,
			vMobileNo = ?,
			dAmnt = ?,
			cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
			resident_ctry = '1',
			in_mate = '1',
			trans_time = '$date'");
			$stmt->bind_param("sssssssd", 
			$afn,
			$educat, 
			$lastname,
			$firstname, 
			$othernames, 
			$email, 
			$phone, 
			$amount);
			$stmt->execute();

			$stmt = $mysqli->prepare("UPDATE app_client SET
			vPassword = '".MD5('pasword')."' 
			WHERE vApplicationNo = '$afn'");
			$stmt->execute();

			$c++;

			$feed_back2 .= $afn . $all_names.'<br>';
		}
		
		if (isset($stmt))
		{
		    $stmt->close();
		}
	}

	echo $c.' records uploaded successfully<br>';
	if ($feed_back2 <> '')
	{
	    echo $feed_back2;
	}
	
	if ($feed_back1 <> '')
	{
	    echo '<p><b>Records not uploaded</b><br>'.$feed_back1;
	}
	exit;
}?>