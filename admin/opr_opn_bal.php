<?php
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('fn_l01b.php');
require_once('fn_l02b.php');

include ('../appl/remita_constants.php');


$orgsetins = settns();
$session = $orgsetins['cAcademicDesc'];

date_default_timezone_set('Africa/Lagos');
$date2 = date("Y-m-d h:i:s");

require_once('var_colls.php');

if (isset($_REQUEST['ilin']) && $_REQUEST['ilin'] <> '')
{
    if (isset($_REQUEST['conf']) && $_REQUEST['conf'] == '1')
    {
        if (isset($_FILES['sbtd_pix']))
        {
            $date2 = date("ymd");
            $file_name = 'batch_balance_'.$orgsetins['cAcademicDesc'].'_'.$orgsetins['tSemester'].'_'.$date2;
            $file = "../../ext_docs/bat_cr/".$file_name.'.csv';
            
            if (!move_uploaded_file($_FILES["sbtd_pix"]["tmp_name"], $file))
            {
                echo "Your file could not be uploaded. Try again later";
                exit;
            }else
            {
                $listed_matnos = "'";
                $valid_matnos = "'";
                $invalid_matnos = "";
                
                $valid_matnos_count = 0;
                $invalid_matnos_count = 0;

                chmod($file, 0755);
                log_actv('Uploaded file '.$file);

                $handle = fopen("$file", "r");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                {
                    if (count($data) <> 3) 
                    {
                        fclose($handle);
                        unlink($file) or die("Couldn't continue process ");

                        echo 'File not valid';
                        exit;
                    }
                    
                    $listed_matnos .= $data[0]."', '";
                }
                
                fclose($handle);

                if ($listed_matnos <> "'")
			    {
                    $stmt = $mysqli->prepare("UPDATE s_tranxion_prev_bal1 
                    SET n_balance = ?,
                    narata = ?
                    WHERE vMatricNo = ?");

                    $err_mg = '';
					$count_r = 0;
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
					{
                        
						$matno = strtoupper(clean_string($data[0], 'matno'));
                        if (!(strlen($matno) == 12 && is_numeric(substr($matno,3,9)) && (substr($matno,0,3) == 'NOU' || substr($matno,0,3) == 'COL')))
						{
							$err_mg .= $names." Invalid matric number ".$matno.'<br>';
							continue;
						}

						$amount = strtoupper(clean_string($data[1], 'numbers'));
						$narat = ucfirst(strtolower(clean_string($data[2], 'sentence')));
                       
                        $stmt->bind_param("dss", $amount, $narat, $matno);
                        $stmt->execute();
                        $count_r += $stmt->affected_rows;
                    }
                    
                    $stmt->close();
                    echo $count_r. ' records updated successfully<p>'.$err_mg;exit;
                }
            }
        }else
        {
            $narat = ucfirst(strtolower(clean_string($_REQUEST["narat"], 'sentence')));

            $stmt = $mysqli->prepare("UPDATE s_tranxion_prev_bal1 
            SET n_balance = ?,
            narata = ?
            WHERE vMatricNo = ?");
            $stmt->bind_param("dss", $_REQUEST["new_balance"], $narat, $_REQUEST["vMatricNo"]);
            $stmt->execute();
            $record3 = $stmt->affected_rows;
            $stmt->close();
            
            log_actv('Adjusted ewallet balance for '. $_REQUEST["vMatricNo"]);

            echo $record3.' record updated successfully';
        }
    }else
    {
        if (!isset($_FILES['sbtd_pix']))
        {
            $stmt = $mysqli->prepare("SELECT h.vFacultyDesc, i.vdeptDesc, f.iBegin_level, f.iStudy_level, f.tSemester, c.vObtQualTitle, b.vProgrammeDesc, f.vLastName, f.vFirstName, f.vOtherName, g.vCityName, vMobileNo  
            FROM programme b, obtainablequal c, afnmatric e, s_m_t f, studycenter g, faculty h, depts i
            WHERE f.cProgrammeId = b.cProgrammeId  
            AND b.cObtQualId = c.cObtQualId
            AND e.vMatricNo = f.vMatricNo 
            AND f.cStudyCenterId = g.cStudyCenterId
            AND f.cFacultyId = h.cFacultyId
            AND b.cdeptId = i.cdeptId
            AND e.vMatricNo = ?");
            $stmt->bind_param("s", $_REQUEST["vMatricNo"]);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($vFacultyDesc, $vdeptDesc, $iBegin_level_01, $iStudy_level_01, $tSemester_01, $vObtQualTitle_01, $vProgrammeDesc_01, $vLastName_01, $vFirstName_01, $vOtherName_01, $vCityName, $vMobileNo_01);
            if ($stmt->num_rows === 0 && check_grad_student($_REQUEST["vMatricNo"]) == 0)
            {	
                $stmt->close();
                echo 'Invalid matriculation number';exit;
            }
            
            $stmt->fetch();
            $stmt->close();
            
            echo $vLastName_01.' '.$vFirstName_01.' '.$vOtherName_01.'#'.$vFacultyDesc.'#'.$vdeptDesc.'#'.$vObtQualTitle_01.' '.$vProgrammeDesc_01.'#'.$iBegin_level_01.'#'.$iStudy_level_01.'#'.$tSemester_01.'#'.$vCityName.'#'.$vMobileNo_01;

            exit;
        }
    }
}?>