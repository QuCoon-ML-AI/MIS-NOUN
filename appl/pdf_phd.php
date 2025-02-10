<?php
require_once('good_entry.php');
require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once('lib_fn.php');
require_once('lib_fn_2.php');

$mysqli = link_connect_db();


$orgsetins = settns();

if (isset($_REQUEST["user_cat"]))
{
    if ($_REQUEST["user_cat"] == 6)
    {
        if (isset($_REQUEST["uvApplicationNo"]) && $_REQUEST["uvApplicationNo"] <> '')
        {
            $vApplicationNo = $_REQUEST["uvApplicationNo"];
        }
    }else
    {
        if (isset($_REQUEST["vApplicationNo"]) && $_REQUEST["vApplicationNo"] <> '')
        {
            $vApplicationNo = $_REQUEST["vApplicationNo"];
        }
    }
}

$stmt_last = $mysqli->prepare("SELECT a.* FROM pics a, prog_choice b WHERE a.vApplicationNo = b.vApplicationNo AND b.vApplicationNo = ? AND cinfo_type = 'p'");
$stmt_last->bind_param("s", $vApplicationNo);
$stmt_last->execute();
$stmt_last->store_result();
if ($stmt_last->num_rows == 0)
{
    echo 'Not yet available';
    $stmt_last->close();
    exit;
}

$trans_time = '';
$leter_ref_no = '';
$vTitle = '';
$namess = '';
$vFacultyDesc = '';
$vObtQualDesc = '';
$vObtQualTitle = '';
$vProgrammeDesc = '';
$Programme = '';
$iBeginLevel = '';
$vdeptDesc = '';
$cdeptId = '';
$vCityName = '';
$cEduCtgId = '';
$cStudyCenterId = '';
$cFacultyId = '';
$iprnltr = '';


$ref_table = src_table("pers_info");


if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
{
    $mysqli_arch = link_connect_db_arch();
    $stmt = $mysqli_arch->prepare("SELECT trans_time, leter_ref_no, a.vTitle, concat(ucase(a.vLastName),' ',a.vFirstName,' ',a.vOtherName) namess, e.vFacultyDesc, i.vObtQualDesc, i.vObtQualTitle, g.vProgrammeDesc, concat(i.vObtQualTitle,' ',g.vProgrammeDesc) Programme, f.iBeginLevel, h.vdeptDesc, g.cdeptId, j.vCityName, i.cEduCtgId, f.cStudyCenterId, e.cFacultyId, f.iprnltr, f.cAcademicDesc, f.cProgrammeId
    FROM arch_pers_info a, faculty e, arch_prog_choice f, programme g, obtainablequal i, depts h, studycenter j
    WHERE f.cFacultyId = e.cFacultyId and
    f.vApplicationNo = a.vApplicationNo and
    f.cProgrammeId = g.cProgrammeId and
    i.cObtQualId = g.cObtQualId and 
    g.cdeptId = h.cdeptId and 
    j.cStudyCenterId = f.cStudyCenterId and
    f.cSbmtd <> '0' and 
    a.vApplicationNo = ?");
}else
{
    $stmt = $mysqli->prepare("SELECT trans_time, leter_ref_no, concat(ucase(f.vLastName),' ',f.vFirstName,' ',f.vOtherName) namess, e.vFacultyDesc, i.vObtQualDesc, i.vObtQualTitle, g.vProgrammeDesc, concat(i.vObtQualTitle,' ',g.vProgrammeDesc) Programme, f.iBeginLevel, h.vdeptDesc, g.cdeptId, j.vCityName, i.cEduCtgId, f.cStudyCenterId, e.cFacultyId, f.iprnltr, f.cAcademicDesc, f.cProgrammeId
    FROM faculty e, prog_choice f, programme g, obtainablequal i, depts h, studycenter j
    WHERE f.cFacultyId = e.cFacultyId and
    f.cProgrammeId = g.cProgrammeId and
    i.cObtQualId = g.cObtQualId and 
    g.cdeptId = h.cdeptId and 
    j.cStudyCenterId = f.cStudyCenterId and
    f.cSbmtd <> '0' and 
    f.vApplicationNo = ?");
}

$stmt->bind_param("s", $vApplicationNo);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($trans_time, $leter_ref_no, $namess, $vFacultyDesc, $vObtQualDesc, $vObtQualTitle, $vProgrammeDesc, $Programme, $iBeginLevel, $vdeptDesc, $cdeptId, $vCityName, $cEduCtgId, $cStudyCenterId, $cFacultyId, $iprnltr, $cAcademicDesc, $cProgrammeId);
$stmt->fetch();

$vObtQualTitle = substr($vObtQualTitle, 0, strlen($vObtQualTitle)-1);

if ($stmt->num_rows <> 0)
{
    $staff_can_access = 0;

    $staff_study_center = '';
    if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '6')
    {
        $staff_study_center = $_REQUEST['user_centre'];

        $staff_study_center_new = str_replace("|","','",$staff_study_center);
        $staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);
        
        $ref_table = src_table("prog_choice");

        $stmt = $mysqli->prepare("SELECT concat(b.vCityName,' centre')  
        from $ref_table a, studycenter b
        WHERE a.cStudyCenterId = b.cStudyCenterId
        AND a.cStudyCenterId IN ($staff_study_center_new)
        AND a.vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);			
        $stmt->execute();
        $stmt->store_result();
        $staff_can_access = $stmt->num_rows;
        $stmt->close();

        if ($staff_can_access == 0)
        {?>
            <div style="margin:50px auto; width:350px; text-align:center; padding:20px; background-color:#eff5f0; font-family:Arial, Helvetica, Verdana, sans-serif; font-size: 0.9em;">
                Student study centre does not match that of staff that is logged in
            </div><?php
            exit;
        }
    }

    if ((isset($_REQUEST["user_cat"]) && ($_REQUEST["user_cat"] == '7' || $_REQUEST["user_cat"] == '6' || $_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '3' || $_REQUEST["user_cat"] == '1')))
	{
        if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '3')
        {
            $ref_table = src_table("prog_choice");
            $stmt = $mysqli->prepare("UPDATE $ref_table SET iprnltr = iprnltr + 1 WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->close();
            log_actv('Printed admission letter for '.$vApplicationNo);
        }

        $ref_table = src_table("prog_choice");
        $stmt1 = $mysqli->prepare("select trans_time, leter_ref_no from $ref_table where vApplicationNo = ? and iprnltr <> '' and iprnltr <> '0'");
        $stmt1->bind_param("s", $vApplicationNo);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($trans_time_01, $leter_ref_no_01);

        $letter_date = '';
        if ($stmt1->num_rows <> 0)
        {
            $stmt1->fetch();
            $letter_date = formatdate($trans_time_01,'fromdb');
            $leter_ref_no = $leter_ref_no_01;
        }
        $stmt1->close();
        
        if($leter_ref_no == '')
        {
            $ref_table = src_table("remitapayments_app");
            $stmt2 = $mysqli->prepare("SELECT MerchantReference FROM $ref_table WHERE Regno = '$vApplicationNo'");
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($MerchantReference);
            $stmt2->fetch();
            $stmt2->close();
            
            
            $ref_table = src_table("prog_choice");
            
            $stmt2 = $mysqli->prepare("SELECT MAX(RIGHT(leter_ref_no,3))+1 FROM $ref_table WHERE vApplicationNo = '$vApplicationNo' AND iprnltr <> 0");
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($next_seria_no);
            $stmt2->fetch();
            $stmt2->close();
            
            $next_seria_no = $next_seria_no ?? 1;
            $seria_no = $next_seria_no;

            $letter_date = date("d-m-Y");
            
            $leter_ref_no = $cProgrammeId.'/'.$MerchantReference.'/'.substr($orgsetins["cAcademicDesc"],2,2). $orgsetins["tSemester"].'/'.$next_seria_no;
            
            $stmt2 = $mysqli->prepare("UPDATE $ref_table SET leter_ref_no = '$leter_ref_no', trans_time = CURDATE() WHERE vApplicationNo = ?");
            $stmt2->bind_param("s", $vApplicationNo);
            $stmt2->execute();
            $stmt2->close();
        }  

        require('../../ppddff/fpdf.php');

        $pdf = new FPDF('P', 'pt', 'A4');
            
        $row_height_25 = 25;
        $row_height_17 = 17;
        $border = 0;
        $pdf->SetLeftMargin(60.0);
        $pdf->SetRightMargin(45.0);

        $pdf->AddPage();

        $pdf->Image(BASE_FILE_NAME_FOR_IMG.'wm_logo_1.png',90,180,0,0,'PNG');


        $pdf->Image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png',275,20,60,70,'PNG');
        $pdf->SetFont('Arial', 'B',14);
        $pdf-> SetY(88);

        $pdf->SetTextColor(6, 137, 80);
        $pdf->Cell(0,$row_height_25,'NATIONAL OPEN UNIVERSITY OF NIGERIA',$border, 1,'C');

        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('', '',8);
        $pdf->Cell(0,10,'University Village, Plot 9, Cadastral Zone, Nnamdi Azikiwe Express Way, Jabi, Abuja, Nigeria',$border, 1,'C');

        $pdf->SetFont('', '',12);
        $pdf->Cell(0,$row_height_25,'(School of Postgraduate Studies)',$border, 1,'C');
        $pdf -> SetY(160);

        $pdf->SetFont('', '',11);
        $row_height_25 = 20;

        $txt = "Our reference: ".$leter_ref_no;

        $pdf->Cell(245,$row_height_25,$txt, $border, 0,'L');
        if ($letter_date < date("d-m-Y"))
        {
            $txt = 'Re-print: '.date("d-m-Y");
            $pdf->Cell(245,$row_height_25,$txt,$border, 1,'R');
        }else
        {
            $pdf->Cell(245,$row_height_25,$letter_date,$border, 1,'R');
        }

        try
        {
            $pdf->Image(get_pp_pix(''),450,185,100,110,'JPG');
        }catch(Exception $e) 
        {
            echo 'Upload passport picture';
            exit;
        }

        $txt = "Application form number: ".$vApplicationNo;
        $pdf->Cell(245,$row_height_25,$txt, $border, 0,'L');
        $pdf->Cell(245,$row_height_25,'',$border, 1,'R');
        
        //if ($vTitle <> ''){$namess .= ' ('.$vTitle.')';}
        $pdf->Cell(0,$row_height_25, $namess ,$border, 1,'L');

        $vPostalAddress = ''; 
        $vPostalCityName = ''; 
        $vPostalLGADesc = ''; 
        $vPostalStateName = ''; 
        $vPostalCountryName = ''; 
        $vEMailId = ''; 
        $vMobileNo = '';
        $w_vMobileNo = '';

        $ref_table = src_table("post_addr");
        $stmt = $mysqli->prepare("select vPostalAddress, f.vLGADesc, vPostalCityName, e.vStateName, d.vCountryName, vEMailId, vMobileNo, w_vMobileNo
        from $ref_table a, country d, ng_state e, localarea f 
        where a.cPostalCountryId = d.cCountryId and
        a.cPostalStateId = e.cStateId and
        a.cPostalLGAId = f.cLGAId and 
        vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($vPostalAddress, $vPostalLGADesc, $vPostalCityName, $vPostalStateName, $vPostalCountryName, $vEMailId, $vMobileNo, $w_vMobileNo);
        $stmt->fetch();
        $stmt->close();        

        if (is_null($vPostalAddress))
        {
            $vPostalAddress = '';
        }
        
        if (is_null($vPostalLGADesc))
        {
            $vPostalLGADesc = '';
        }
        
        if (is_null($vPostalCityName))
        {
            $vPostalCityName = '';
        }
        
        if (is_null($vPostalStateName))
        {
            $vPostalStateName = '';
        }
       
        if (is_null($vPostalCountryName))
        {
            $vPostalCountryName = '';
        }
        
        if (is_null($vEMailId))
        {
            $vEMailId = '';
        }
        
        if (is_null($vMobileNo))
        {
            $vMobileNo = '';
        }
        
        if (is_null($w_vMobileNo))
        {
            $w_vMobileNo = '';
        }

        $row_height_25 = 15;

        if ($vPostalAddress <> '')
        {
            if ($vPostalLGADesc <> '')
            {
                $pdf->Cell(0,$row_height_25, $vPostalAddress, $border, 1,'L');
            }else
            {
                $pdf->Cell(0,$row_height_25, $vPostalAddress, $border, 1,'L');
            }
        }

        
        /*if ($vPostalCityName <> '')
        {
            if ($vPostalStateName <> '')
            {
                $pdf->Cell(0,$row_height_25, $vPostalCityName, $border, 1,'L');
            }else
            {
                $pdf->Cell(0,$row_height_25, $vPostalCityName, $border, 1,'L');
            }
        }*/

        
        if ($vPostalLGADesc <> '')
        {
            $vPostalLGADesc = ucwords(strtolower($vPostalLGADesc));

            if ($vPostalCityName <> '')
            {
                $pdf->Cell(0,$row_height_25, $vPostalLGADesc, $border, 1,'L');
            }else
            {
                $pdf->Cell(0,$row_height_25, $vPostalLGADesc, $border, 1,'L');
            }
        }

        
        if ($vPostalStateName <> '')
        {
            if ($vPostalCountryName <> '')
            {
                $pdf->Cell(0,$row_height_25, $vPostalStateName, $border, 1,'L');
            }else
            {
                $pdf->Cell(0,$row_height_25, $vPostalStateName, $border, 1,'L');
            }
        }
        
        if ($vPostalCountryName <> '')
        {
            $pdf->Cell(0,$row_height_25, $vPostalCountryName, $border, 1,'L');
        }
        

        $row_height_25 = 25;

        $pdf -> SetY(310);

        $pdf->SetFont('', 'B',11);
        $txt = 'Offer of Provisional Admission ['.$orgsetins["cAcademicDesc"].' Session]';
        $pdf->Cell(0,$row_height_25,$txt,$border, 1,'C');
        $pdf -> SetY(295);

        $pdf->SetFont('', '',10);

        $pdf -> SetY(340);

        $ref_table = src_table("prog_choice");
        $stmt1 = $mysqli->prepare("select cEduCtgId from $ref_table where vApplicationNo = ?");
        $stmt1->bind_param("s", $vApplicationNo);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($cEduCtgId_01);
        $stmt1->fetch();
        $stmt1->close();

        $row_height_25 = 15;

        $txt = "With reference to your application for admission to a postgraduate programme of the National Open University of Nigeria (NOUN), I am pleased to inform you that you have been offered a provisional admission to pursue a postgraduate programme leading to the award of $vObtQualTitle $vProgrammeDesc in the Department of $vdeptDesc, Faculty of $vFacultyDesc of the University with effect from ".$orgsetins["cAcademicDesc"]."_".$orgsetins["tSemester"]." semester.";
        $pdf->MultiCell(0, $row_height_25, $txt, $border);
        
        if ($cEduCtgId_01 == 'PRX')
        {
            $pdf -> SetY(420);
            $txt = "The Minimum duration for the programme is six (6) semesters and upon completion of screening, you are required to pay an acceptance/compulsory fee through your section of the University portal."; 
        }else if ($cEduCtgId_01 == 'PGZ')
        {
            $pdf -> SetY(422);
            $txt = "The Minimums duration for the programme is two (2) semesters and upon completion of screening, you are required to pay an acceptance/compulsory fee through your section of the University portal. In addition, you will be required to write and pass your examinations at the end of each semester to be eligible for migration to full PhD (Please note that the University does not offer Master of Philosophy (MPhil) as a terminal degree)";
        }
        $pdf->MultiCell(0, $row_height_25, $txt, $border);

        if ($cEduCtgId_01 == 'PRX')
        {
            $pdf -> SetY(460);
        }else if ($cEduCtgId_01 == 'PGZ')
        {
            $pdf -> SetY(490);
        }

        $txt = "At the time of screening, you are requested to produce the following documents at the School of Postgraduate Studies, NOUN, Headquarters, Abuja.";
        $pdf->MultiCell(0,$row_height_25,$txt,$border);

        if ($cEduCtgId_01 == 'PRX')
        {
            $pdf -> SetY(500);
        }else if ($cEduCtgId_01 == 'PGZ')
        {
            $pdf -> SetY(530);
        }

        $pdf->Cell(25,$row_height_25,"(i)", $border, 0,'R');
        $txt = 'A copy of Remita Receipt obtained for the application form.';
        $pdf->Cell(0,$row_height_25,$txt,$border, 1,'L');        

        $pdf->Cell(25,$row_height_25,"(ii)", $border, 0,'R');
        $txt = 'A copy of your most recent Curriculum Vitae (CV).';
        $pdf->Cell(0,$row_height_25,$txt,$border, 1,'L');      

        $pdf->Cell(25,$row_height_25,"(iii)", $border, 0,'R');
        $txt = 'Original and two (2) photocopies of all the academic certificates as claimed in your application form.';
        $pdf->Cell(0,$row_height_25,$txt,$border, 1,'L');     

        $pdf->Cell(25,$row_height_25,"(iv)", $border, 0,'R');
        $txt = 'Original and two (2) photocopies of your birth certificate or sworn declaration of age.';
        $pdf->Cell(0,$row_height_25,$txt,$border, 1,'L');

        $pdf->Cell(25,$row_height_25,"(v)", $border, 0,'R');
        $txt = 'Two (2) recent passport photographs.';
        $pdf->Cell(0,$row_height_25,$txt,$border, 1,'L');

        $pdf->Cell(25,$row_height_25,"(vi)", $border, 0,'R');
        $txt = 'Two (2) reference letters one of which must be from an academic.';
        $pdf->Cell(0,$row_height_25,$txt,$border, 1,'L');

        
        if ($cEduCtgId_01 == 'PRX')
        {
            $pdf -> SetY(600);
        }else if ($cEduCtgId_01 == 'PGZ')
        {
            $pdf -> SetY(630);
        }

        $txt = "The University further reserves the right to withdraw your admission without the option of refund of fees paid, if it is discovered that you have given false information to the University or falsified any result or record.";
        $pdf->MultiCell(0, $row_height_17, $txt, $border);

        
        if ($cEduCtgId_01 == 'PRX')
        {
            $pdf -> SetY(650);
        }else if ($cEduCtgId_01 == 'PGZ')
        {
            $pdf -> SetY(670);
        }
        $pdf->Cell(0,$row_height_25, 'Congratulations!',$border, 1,'L');

        $pdf->Image(BASE_FILE_NAME_FOR_IMG.'reg_sig2.png',59,705,100,20,'PNG');

        $pdf -> SetY(725);
        $txt = "Folashade T. Oritogun (Mrs)";
        $pdf->SetFont('', 'B',10);
        $pdf->Cell(0,15,$txt,$border, 1,'L');

        $pdf->SetFont('', '',8);
        $pdf->Cell(0,10,'Secretary, School of Postgraduate Studies',$border, 1,'L');

        $pdf -> SetY(-67);
        $pdf->SetFont('', '',8);
        $txt = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $pdf->Cell(0,10,$txt,$border, 1,'R');

        $pdf->Output();  
    }
}else
{?>
    <div style="margin:50px auto; width:350px; text-align:left; padding:20px; background-color:#eff5f0; line-height:1.6; font-family:Arial, Helvetica, Verdana, sans-serif; font-size: 0.9em;">
        Admission letter not found<br>Possible reasons are:<br>(a) Forma not submitted<br>(b) Record not in the archive<br>(c) Record not in the selected faculty
    </div><?php
    exit;
}?>