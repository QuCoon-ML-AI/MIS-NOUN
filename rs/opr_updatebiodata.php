<?php

require_once('../../fsher/fisher.php');
include('./const_def.php');
include(BASE_FILE_NAME.'lib_fn.php');
include('./std_lib_fn.php');

$mysqli = link_connect_db();



if (isset($_REQUEST["token_req"]))
{
    
    if ($_REQUEST["token_req"] == '0')
    {
        send_token('updating biodata');
        echo 'Token sent';
        exit;
    }else if ($_REQUEST["token_req"] == '1')
    {
        $valid_state = validate_token('updating biodata');
        
        if ($valid_state <> 'Token valid')
        {
            echo $valid_state;
            exit;
        }

        if (isset($_FILES['sbtd_pix']))
        {
            $file_chk = check_file('50000', '2');
            if ($file_chk <> '')
            {
                echo $file_chk;
                exit;
            }

            $stmt = $mysqli->prepare("select upld_passpic_no from pics where vApplicationNo = ? and cinfo_type = 'p'");
            $stmt->bind_param("i", $_REQUEST['vApplicationNo']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($upld_passpic_no);
            $stmt->fetch();
            $stmt->close();
            
            if ($_REQUEST["std_upld_passpic_no"] > 0)
            {
                $image_properties = getimagesize($_FILES['sbtd_pix']['tmp_name']);
                if (!is_array($image_properties))
                {
                    echo 'File of JPEG type to upload for passport'; exit;
                }

                if ($image_properties["mime"] <> 'image/jpg' && $image_properties["mime"]  <> 'image/jpeg' && $image_properties["mime"]  <> 'image/pjpeg')
                {
                    echo 'File of JPEG type to upload for passport'; exit;
                }
                
                $target_file = basename($_FILES["sbtd_pix"]["name"]); 
                $file_name_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                
                if ($file_name_ext <> 'jpg' && $file_name_ext  <> 'jpeg' && $file_name_ext  <> 'pjpeg')
                {
                    echo 'File of JPEG type to upload for passport'; exit;
                }
                
                if ($_FILES["sbtd_pix"]["size"] > 50000)
                {
                    echo '50KB exceeded for passport picture'; exit;
                }
                
                
                $search_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST["cFacultyId"])."/pp/p_".$_REQUEST["vmask"].".jpg";
                $pix_file_name = DEL_FILE_NAME_FOR_PP.strtolower($_REQUEST["cFacultyId"])."/pp/p_".$_REQUEST["vmask"].".jpg";
                
                if(file_exists($search_file_name))
                {
                    if (copy($search_file_name, $pix_file_name))
                    {
                        @unlink($search_file_name);
                    }
                    chmod($pix_file_name, 0755);
                }


                $vmask = '';

                //delete_std_pp_file($appl_frm);

                if (!move_uploaded_file($_FILES['sbtd_pix']['tmp_name'], BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name']))
                {
                    echo  "Upload failed, please try again"; exit;
                }

                $token = openssl_random_pseudo_bytes(6);
                $token = bin2hex($token);

                $new_file_name = BASE_FILE_NAME_FOR_PP.strtolower($_REQUEST["cFacultyId"])."/pp/p_".$token.".jpg";

                rename(BASE_FILE_NAME_FOR_PP . $_FILES['sbtd_pix']['name'], $new_file_name);
                chmod($new_file_name, 0755);

                $stmt = $mysqli->prepare("REPLACE INTO pics
                SET vApplicationNo = ?, 
                vmask = '$token', 
                cinfo_type = 'p', 
                vExamNo = '', 
                cQualCodeId = ''");
                $stmt->bind_param("s", $_REQUEST["vApplicationNo"]);
                $stmt->execute();
                $stmt->close();

                log_actv('changed passport picture');
            }else if ($_REQUEST["upld_passpic_no"] > 0)
            {
                echo 'Passport not uploaded, chances exhusted<br>';
            }			
        }

        $stmt = $mysqli->prepare("UPDATE s_m_t
        SET cMaritalStatusId = ?,
        cDisabilityId = ?,
        cResidenceCountryId = ?,
        cResidenceStateId = ?,
        cResidenceLGAId = ?,
        vResidenceCityName = ?,
        vResidenceAddress = ?,
        vEMailId = ?,
        vMobileNo = ?,
        w_vMobileNo = ?,
        vNOKName = ?,
        vNOKMobileNo = ?,
        vNOKEMailId = ?,
        vNOKAddress = ?,
        cNOKType = ?
        where vMatricNo = ?");
        $stmt->bind_param("ssssssssssssssss", 
        $_REQUEST["cMaritalStatusId"], 
        $_REQUEST["cDisabilityId"],  
        $_REQUEST["cResidenceCountryId"], 
        $_REQUEST["cResidenceStateId"], 
        $_REQUEST["cResidenceLGAId"], 
        $_REQUEST["vResidenceCityName"], 
        $_REQUEST["vResidenceAddress"], 
        $_REQUEST["vEMailId"], 
        $_REQUEST["vMobileNo"], 
        $_REQUEST["w_vMobileNo"], 
        $_REQUEST["vNOKName"], 
        $_REQUEST["vNOKMobileNo"], 
        $_REQUEST["vNOKEMailId"], 
        $_REQUEST["vNOKAddress"], 
        $_REQUEST["cNOKType"], 
        $_REQUEST["vMatricNo"]);
        $stmt->execute();
        $stmt->close();

        log_actv('updated bio data');
        echo 'Success';
    }
}
exit;
?>