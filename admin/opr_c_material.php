<?php
require_once('../../fsher/fisher.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

$mysqli = link_connect_db();

if (isset($_REQUEST['save']) && $_REQUEST['save'] == '1' && isset($_REQUEST['currency']) && $_REQUEST['currency'] == '1')
{
	if (isset($_REQUEST['mm']) && isset($_REQUEST['sm']))
	{
		$stmt = $mysqli->prepare("select * from afnmatric where vMatricNo = ?");
		$stmt->bind_param("s",$_REQUEST["uvApplicationNo"]);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows === 0)
		{
			$stmt->close();
			echo 'Invalid matriculation number';exit;
		}else if (check_grad_student($_REQUEST["uvApplicationNo"]) == 1)
		{
			//echo 'Matriculation number gradauted'; 
			//exit;
		}
		
		//$str = array(); 
		$str1 = "'";
		if (isset($_REQUEST['numofreg']) && isset($_REQUEST['tabno']) && $_REQUEST['tabno'] == '1')
		{ 
			$stmt = $mysqli->prepare("UPDATE coursereg_arch SET
			c_mat = '0'
			WHERE vMatricNo = ?
			AND tSemester = ? 
			AND siLevel = ?");
			$stmt->bind_param("sii", $_REQUEST["uvApplicationNo"], $_REQUEST["tSemester"], $_REQUEST["iStudy_level"]);
			$stmt->execute();
			$stmt->close();
			
			$number_of_courses_treated = 0;
			$stmt = $mysqli->prepare("UPDATE coursereg_arch SET
			c_mat = '1',
			date_c_mat = CURDATE()
			WHERE cCourseId = ?
			AND vMatricNo = ?
			AND tSemester = ? 
			AND siLevel = ?");
			
			for ($k = 1; $k <= $_REQUEST["numofreg"]; $k++)
			{   
				if (isset($_REQUEST["regCourses$k"]))
				{
					$stmt->bind_param("ssii", $_REQUEST["regCourses$k"], $_REQUEST["uvApplicationNo"],$_REQUEST["tSemester"],$_REQUEST["iStudy_level"]);
					$stmt->execute();
					log_actv(" issued course material for ".$_REQUEST["regCourses$k"]." to ".$_REQUEST["uvApplicationNo"]);
					$number_of_courses_treated++;
				}
			}
			$stmt->close();
			echo 'Record updated successfully. '. $number_of_courses_treated.' course material(s) issued';exit;
		}else if (isset($_REQUEST['tabno']) && $_REQUEST['tabno'] == '2')
		{	
			$stmt = $mysqli->prepare("update s_m_t SET
			ret_gown = ?,
			col_gown = ?
			where vMatricNo = ?");
			$stmt->bind_param("sss",$_REQUEST["ret_gown"],$_REQUEST["col_gown"],$_REQUEST["uvApplicationNo"]);
			$stmt->execute();
			$stmt->close();
			
			if ($_REQUEST["col_gown"] == '0' && $_REQUEST["ret_gown"] == '1')
			{
				log_actv('retrieved gown from '.$_REQUEST["uvApplicationNo"]);
			}else if ($_REQUEST["col_gown"] == '1' && $_REQUEST["ret_gown"] == '0')
			{
				log_actv('issued gown to '.$_REQUEST["uvApplicationNo"]);
			}else if ($_REQUEST["col_gown"] == '0' && $_REQUEST["ret_gown"] == '0')
			{
				log_actv('Gown neither collected nor issued for '.$_REQUEST["uvApplicationNo"]);
			}
			echo 'Gown collection record updated successfully';exit;
		}else
		{
			echo '';
		}
	}
}