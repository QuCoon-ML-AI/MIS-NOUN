<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
include ('remita_constants.php');

$mysqli = link_connect_db();

$orgsetins = settns();

if (isset($_REQUEST['ilin']) && isset($_REQUEST['mm']) && isset($_REQUEST['sm']))
{
	$file_chk = check_file('5000000', '1');
	if ($file_chk <> '')
	{
		//echo $file_chk;
		//exit;
	}
	
	$file_name = 'appl_record.csv';
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

		$err_count = 0;
		
		//$number_of_transactions = 0;
		$num_gen_cnt = 0;
		$cn = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			if ($cn > 99)
			{
				break;
			}
			
			if (count($data) <> 7) 
			{
				fclose($handle);
				chmod($file, 0755);
				unlink($file) or die("Couldn't continue process ");

				echo 'There should be 7 columns of data';
				exit;
			}

			//$prog_cat = strtoupper(trim($data[0]));
			$prog_cat = strtolower(clean_string($data[0], 'letters'));

			
			//$lastname = strtoupper(trim($data[1]));
			$lastname = strtoupper(clean_string($data[1], 'names'));

			//$firstname = ucfirst(strtolower(trim($data[2])));
			$firstname = ucfirst(strtolower(clean_string($data[2], 'names')));

			//$othernames = ucfirst(strtolower(trim($data[3])));
			$othernames = ucfirst(strtolower(clean_string($data[3], 'names')));

			$all_names = $lastname.' '.$firstname.' '.$othernames;

			//$gender = strtoupper(trim($data[5]));
			$gender = strtoupper(clean_string($data[4], 'letters'));

			//$emailid = trim($data[4]);
			$emailid = clean_string($data[5], 'email');

			//$phone = trim($data[6]);
			$phone = clean_string($data[6], 'numbers');

						
			if ($prog_cat == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty programme category <br>';
			    continue;
			}

			if ($prog_cat == 'phd')
			{
			    $prog_cat = 'PRX';
			}else if ($prog_cat == 'mphil')
			{
			    $prog_cat = 'PGZ';
			}else if ($prog_cat == 'masters')
			{
			    $prog_cat = 'PGY';
			}else if ($prog_cat == 'pgd')
			{
			    $prog_cat = 'PGX';
			}else if ($prog_cat == 'ug')
			{
			    $prog_cat = 'PSZ';
			}


			if ($prog_cat == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty name programme category<br>';
			    continue;
			}
			
			if ($lastname == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty name'.$firstname.' '.$othernames.'<br>';
			    continue;
			}

			if ($firstname == '' && $othernames == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty first and other names <br>';
			    continue;
			}

			if ($emailid == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty email ID<br>';
			    continue;
			}

			if ($gender == '')
			{
			    $feed_back .= ++$err_count.' '.$all_names.' empty gender<br>';
			    continue;
			}

			if ($phone == '' || !is_numeric($phone))
			{
			    $feed_back .= ++$err_count.' '.$all_names.' invalid phone number<br>';
			    continue;
			}


			
			while (1 == 1)
			{
				if ($cn > 99)
				{
					break;
				}
				
				$cn++;
				$cn = str_pad($cn, 2, "0", STR_PAD_LEFT);
				$afn = '0'.date("ymd").$cn;

				$stmt = $mysqli->prepare("SELECT * FROM remitapayments_app WHERE Regno = ?");
				$stmt->bind_param("s", $afn);
				$stmt->execute();
				$stmt->store_result();
				$remitapayments_app_chk = $stmt->num_rows;

				$stmt = $mysqli->prepare("SELECT * FROM prog_choice WHERE vApplicationNo  = ?");
				$stmt->bind_param("s", $afn);
				$stmt->execute();
				$stmt->store_result();
				$prog_choice_chk = $stmt->num_rows;

				$stmt = $mysqli->prepare("SELECT vApplicationNo FROM prog_choice WHERE vLastName  = ? AND vFirstName = ? AND vOtherName = ?");
				$stmt->bind_param("sss", $lastname, $firstname, $othernames);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows > 0)
				{
					$stmt->bind_result($vApplicationNo);
					$stmt->fetch();
					$feed_back .= ++$err_count.' '.$all_names.' already on record with AFN '. $vApplicationNo.'<br>';
					$afn = '';
					break;
				}

				$stmt = $mysqli->prepare("SELECT * FROM pers_info WHERE vApplicationNo  = ?");
				$stmt->bind_param("s", $afn);
				$stmt->execute();
				$stmt->store_result();
				$pers_info_chk = $stmt->num_rows;


				$stmt = $mysqli->prepare("SELECT * FROM app_client WHERE vApplicationNo  = ?");
				$stmt->bind_param("s", $afn);
				$stmt->execute();
				$stmt->store_result();
				$app_client_chk = $stmt->num_rows;

				if ($remitapayments_app_chk == 0 && $prog_choice_chk == 0 && $app_client_chk == 0 && $pers_info_chk == 0)
				{
					$num_gen_cnt++;
					echo $afn.' '.$all_names.' '.$gender.'<br>';
					break;
				}
			}

			if ($afn == '')
			{
				continue;
			}

			
			$date = date("Y-m-d h:i:s");

			$stmt = $mysqli->prepare("INSERT INTO prog_choice
			SET vApplicationNo = ?,
			cEduCtgId = ?,
			vLastName = ?,
			vFirstName = ?,
			vOtherName = ?,
			vEMailId = ?,
			vMobileNo = ?,
			cAcademicDesc = '".$orgsetins['cAcademicDesc']."',
			resident_ctry = '1',
			in_mate = '1',
			trans_time = '$date'");
			$stmt->bind_param("sssssss", 
			$afn,
			$prog_cat, 
			$lastname,
			$firstname, 
			$othernames, 
			$emailid, 
			$phone);
			$stmt->execute();

			$stmt = $mysqli->prepare("INSERT INTO app_client SET
			vPassword = '".MD5($afn)."', 
			vApplicationNo = '$afn'");
			$stmt->execute();
    		
			$c++;
		}
		
		if (isset($stmt))
		{
		    $stmt->close();
		}
	}
	
	echo $num_gen_cnt.' AFNs generated<br>';

	echo $c.' record(s) uploaded successfully';
	
	if ($feed_back <> '')
	{
	    echo '<p><b>Records not uploaded</b><br>'.$feed_back;
	}
	exit;
}?>