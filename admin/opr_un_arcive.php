<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');
include('const_def.php');

$staff_study_center = '';
if (isset($_REQUEST['staff_study_center']))
{
	$staff_study_center = $_REQUEST['staff_study_center'];
}

$orgsetins = settns();

$mysqli_arch = link_connect_db_arch();

$who_is_this = '';
$str = '';

if (isset($_REQUEST['ilin']))
{
	if (isset($_REQUEST['bulk_change']))
	{
		$invalid_afn = '';
		$invalid_afn_count = 0;

		$arch_afn = '';
		$arch_afn_count = 0;		

		$not_arch_afn = '';
		$not_arch_afn_count = 0;

		$not_submmited_afn = '';
		$not_submmited_afn_count = 0;

		$valid_afn = '';
		$valid_afn_count = 0;

		$splitLine = explode("\n", str_replace("\r", "", $_REQUEST["bulk_change"]));

		try
		{
			$mysqli->autocommit(FALSE); //turn on transactions

			foreach ($splitLine as $val_arr)
			{
				if (!is_bool(strripos($invalid_afn, $val_arr)) || 
				!is_bool(strripos($not_submmited_afn, $val_arr)) || 
				!is_bool(strripos($valid_afn, $val_arr)))
				{
					continue;
				}

				if ($_REQUEST["id_no"] == '0')
				{
					if ($_REQUEST["action_to_do"] == '0')//archive
					{
						$stmt = $mysqli_arch->prepare("select * from arch_prog_choice where vApplicationNo = ?");
						$stmt->bind_param("s", $val_arr);
						$stmt->execute();
						$stmt->store_result();
						if ($stmt->num_rows == 1)
						{
							$arch_afn_count++;
							$arch_afn .= $arch_afn.'. '.$val_arr.'<br>';							
						}else
						{
							$stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
							$stmt->bind_param("s", $val_arr);
							$stmt->execute();
							$stmt->store_result();
							if ($stmt->num_rows == 0)
							{
								$invalid_afn++;
								$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
							}else
							{
								if (archive_appl($val_arr) == 1)
								{
									$valid_afn_count++;
									$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
								}
							}
						}
						$stmt->close();
					}else if ($_REQUEST["action_to_do"] == '1')//unarchive
					{
						$stmt = $mysqli_arch->prepare("select * from arch_prog_choice where vApplicationNo = ?");
						$stmt->bind_param("s", $val_arr);
						$stmt->execute();
						$stmt->store_result();
						if ($stmt->num_rows == 0)
						{
							$not_arch_afn_count++;
							$not_arch_afn .= $not_arch_afn.'. '.$val_arr.'<br>';							
						}else
						{
							$stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
							$stmt->bind_param("s", $val_arr);
							$stmt->execute();
							$stmt->store_result();
							if ($stmt->num_rows == 0)
							{
								$invalid_afn++;
								$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
							}else
							{
								if (unarchive_appl($val_arr) == 1)
								{
									$valid_afn_count++;
									$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
								}
							}
						}
						$stmt->close();
					}
				}else if ($_REQUEST["id_no"] == '1')
				{
					if ($_REQUEST["action_to_do"] == '0')//archive
					{
						$stmt = $mysqli_arch->prepare("select * from arch_afnmatric where vMatricNo = ?");
						$stmt->bind_param("s", $val_arr);
						$stmt->execute();
						$stmt->store_result();
						if ($stmt->num_rows == 1)
						{
							$arch_afn_count++;
							$arch_afn .= $arch_afn.'. '.$val_arr.'<br>';
						}else
						{
							$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
							$stmt->bind_param("s", $val_arr);
							$stmt->execute();
							$stmt->store_result();
							if ($stmt->num_rows == 0)
							{
								$invalid_afn++;
								$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
							}else
							{
								if (archive_student($val_arr) == 1)
								{
									$valid_afn_count++;
									$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
								}
							}
						}
		
						$stmt->close();
					}else if ($_REQUEST["action_to_do"] == '1')//unarchive
					{
						$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
						$stmt->bind_param("s", $val_arr);
						$stmt->execute();
						$stmt->store_result();
						if ($stmt->num_rows == 1)
						{
							$not_arch_afn_count++;
							$not_arch_afn .= $not_arch_afn.'. '.$val_arr.'<br>';
						}else
						{
							$stmt = $mysqli_arch->prepare("select * from arch_afnmatric where vMatricNo = ?");
							$stmt->bind_param("s", $val_arr);
							$stmt->execute();
							$stmt->store_result();
							if ($stmt->num_rows == 0)
							{
								$invalid_afn++;
								$invalid_afn .= $invalid_afn_count.'. '.$val_arr.'<br>';
							}else
							{
								if (unarchive_student($val_arr) == 1)
								{
									$valid_afn_count++;
									$valid_afn .= $valid_afn_count.'. '.$val_arr.'<br>';
								}
							}
						}
		
						$stmt->close();
					}
				}
			}
			
			$mysqli->autocommit(TRUE); //turn off transactions + commit queued queries

			$strng = '';
			if ($invalid_afn <> '')
			{
				$strng = '<b>Invalid numbers (not treated)</b><br>'.$invalid_afn.'<p>';
			}

			if ($not_submmited_afn <> '')
			{
				$strng .= '<b>Form not submitted (not treated)</b><br>'.$not_submmited_afn.'<p>';
			}

			if ($valid_afn <> '')
			{
				$strng .= '<b>Valid numbers (treated)</b><br>'.$valid_afn;
			}
			echo $strng;
			exit;
		}catch(Exception $e) 
		{
			$mysqli->rollback(); //remove all queries from queue if error (undo)
			throw $e;
		}
	}else if (isset($_REQUEST['uvApplicationNo']))
	{
		if ($_REQUEST["id_no"] == '0')
		{
			if ($_REQUEST["action_to_do"] == '0')
			{
				$stmt = $mysqli_arch->prepare("select * from arch_prog_choice where vApplicationNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 1)
				{
					$stmt->close();
					echo 'Application form number is already archived';exit;
				}

				$stmt = $mysqli->prepare("select * from prog_choice where vApplicationNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 0)
				{
					$stmt->close();
					echo 'Invalid Application form number';exit;
				}
				$stmt->close();
			}else if ($_REQUEST["action_to_do"] == '1')
			{
				$stmt = $mysqli_arch->prepare("select * from arch_prog_choice where vApplicationNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 0)
				{
					$stmt->close();
					echo 'Application form number is not in the archive';exit;
				}
				$stmt->close();
			}
		}else if ($_REQUEST["id_no"] == '1')
		{
			if ($_REQUEST["action_to_do"] == '0')
			{
				$stmt = $mysqli_arch->prepare("select * from arch_afnmatric where vMatricNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 1)
				{
					$stmt->close();
					echo 'Matriculation number is already archived';exit;
				}

				$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 0)
				{
					$stmt->close();
					echo 'Invalid matriculation number';exit;
				}
				$stmt->close();
			}else if ($_REQUEST["action_to_do"] == '1')
			{
				$stmt = $mysqli_arch->prepare("select * from arch_afnmatric where vMatricNo = ?");
				$stmt->bind_param("s", $_REQUEST["uvApplicationNo"]);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 0)
				{
					$stmt->close();
					echo 'Matriculation number is not in the archive<br>
					Is the entered number a matriculation number?';exit;
				}
				$stmt->close();
			}
		}	
		
		if ($_REQUEST["action_to_do"] == '0')
		{
			if (archive_student($_REQUEST["uvApplicationNo"]) == 1)
			{
				echo 'success';
				exit;
			}
		}else if ($_REQUEST["action_to_do"] == '1')
		{
			if (unarchive_student($_REQUEST["uvApplicationNo"]) == 1)
			{
				echo 'success';
				exit;
			}
		}
	}
}
