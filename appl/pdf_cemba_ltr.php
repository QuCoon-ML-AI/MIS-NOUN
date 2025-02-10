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

if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
{
    $mysqli_arch = link_connect_db_arch();
    $stmt = $mysqli->prepare("SELECT trans_time, leter_ref_no, concat(ucase(a.vLastName),' ',a.vFirstName,' ',a.vOtherName) namess, e.vFacultyDesc, i.vObtQualDesc, i.vObtQualTitle, g.vProgrammeDesc, concat(i.vObtQualTitle,' ',g.vProgrammeDesc) Programme, f.iBeginLevel, h.vdeptDesc, g.cdeptId, j.vCityName, i.cEduCtgId, f.cStudyCenterId, e.cFacultyId, f.iprnltr, f.cAcademicDesc, f.cProgrammeId
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
if ($stmt->num_rows <> 0)
{
    
    if ($vObtQualTitle == 'CEMBA')
    {
        $vObtQualTitle = 'Commonwealth Executive Masters of Business Administration';
    }else if ($vObtQualTitle == 'CEMPA')
    {
        $vObtQualTitle = 'Commonwealth Executive Masters of Public Administration';
    }

    $staff_can_access = 0;

    $staff_study_center = '';
    if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '6')
    {
        $staff_study_center = $_REQUEST['user_centre'];

        $staff_study_center_new = str_replace("|","','",$staff_study_center);
        $staff_study_center_new = substr($staff_study_center_new,2,strlen($staff_study_center_new)-4);

        $stmt = $mysqli->prepare("SELECT concat(b.vCityName,' centre')  
        from prog_choice a, studycenter b
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
            <div style="margin:50px auto; width:350px; text-align:center; padding:20px; background-color:#eff5f0">
                Student study centre does not match that of staff that is logged in
            </div><?php
            exit;
        }
    }

    if ((isset($_REQUEST["user_cat"]) && ($_REQUEST["user_cat"] == '7' || $_REQUEST["user_cat"] == '6' || $_REQUEST["user_cat"] == '5' || $_REQUEST["user_cat"] == '3')))
	{
        if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '3')
        {
            $stmt = $mysqli->prepare("UPDATE prog_choice SET iprnltr = iprnltr + 1 WHERE vApplicationNo = ?");
            $stmt->bind_param("s", $vApplicationNo);
            $stmt->execute();
            $stmt->close();
            log_actv('Printed admission letter for '.$vApplicationNo);
        }

        $stmt1 = $mysqli->prepare("select trans_time, leter_ref_no from prog_choice where vApplicationNo = ? and iprnltr <> '' and iprnltr <> '0'");
        $stmt1->bind_param("s", $vApplicationNo);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($trans_time_01, $leter_ref_no_01);

        if ($stmt1->num_rows <> 0)
        {
            $stmt1->fetch();
            $letter_date = formatdate($trans_time_01,'fromdb');
            $leter_ref_no = $leter_ref_no_01;
        }
        $stmt1->close();
        
        if($leter_ref_no == '')
        {
            $stmt2 = $mysqli->prepare("SELECT MerchantReference, AcademicSession FROM remitapayments_app WHERE Regno = '$vApplicationNo'");
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($MerchantReference, $cAcademicDesc);
            $stmt2->fetch();
            $stmt2->close();
            
            $stmt2 = $mysqli->prepare("SELECT MAX(RIGHT(leter_ref_no,3))+1 FROM prog_choice WHERE vApplicationNo = '$vApplicationNo' AND iprnltr <> 0");
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($next_seria_no);
            $stmt2->fetch();
            $stmt2->close();
            
            $next_seria_no = $next_seria_no ?? 1;
            $seria_no = $next_seria_no;

            $letter_date = date("d-m-Y");
            
            $leter_ref_no = $cProgrammeId.'/'.$MerchantReference.'/'.substr($cAcademicDesc,2,2). $orgsetins["tSemester"].'/'.$next_seria_no;
            
            $stmt2 = $mysqli->prepare("UPDATE prog_choice SET leter_ref_no = '$leter_ref_no', trans_time = CURDATE() WHERE vApplicationNo = ?");
            $stmt2->bind_param("s", $vApplicationNo);
            $stmt2->execute();
            $stmt2->close();
        }  

        require('../../ppddff/fpdf.php');

        $pdf = new FPDF('P', 'pt', 'A4');
            
        $row_height_25 = 25;
        $border = 0;
        $pdf->SetLeftMargin(60.0);
        $pdf->SetRightMargin(45.0);

        $pdf->AddPage();

        $pdf->Image(BASE_FILE_NAME_FOR_IMG.'wm_logo_1.png',90,180,0,0,'PNG');


        $pdf->Image(BASE_FILE_NAME_FOR_IMG.'left_side_logo.png',275,20,60,70,'PNG');
        $pdf->SetFont('Arial', 'B',14);
        $pdf -> SetY(100);

        $pdf->SetTextColor(6, 137, 80);
        $pdf->Cell(0,$row_height_25,'NATIONAL OPEN UNIVERSITY OF NIGERIA',$border, 1,'C');

        $pdf->SetTextColor(0, 0, 0);

        $pdf->SetFont('', '',8);
        $pdf->Cell(0,10,'University Village, Plot 9, Cadastral Zone, Nnamdi Azikiwe Express Way, Jabi, Abuja, Nigeria',$border, 1,'C');

        $pdf->SetFont('', '',12);
        $pdf->Cell(0,$row_height_25,'School of Postgraduate Studies',$border, 1,'C');
        $pdf -> SetY(160);

        $pdf->SetFont('', '',10);

        $txt = "Our reference: ".$leter_ref_no;
        $pdf->Cell(245,15,$txt, $border, 0,'L');
        $pdf->Cell(245,15,$letter_date,$border, 1,'R');

        if ($letter_date < date("d-m-Y"))
        {
            $txt = 'Re-print: '.date("d-m-Y");
            $pdf->Cell(0,20,$txt,$border, 1,'R');
        }

        $vPostalAddress = ''; 
        $vPostalCityName = ''; 
        $vPostalLGADesc = ''; 
        $vPostalStateName = ''; 
        $vPostalCountryName = ''; 
        $vEMailId = ''; 
        $vMobileNo = '';
        $w_vMobileNo = '';

        $stmt = $mysqli->prepare("SELECT vPostalAddress, f.vLGADesc, vPostalCityName, e.vStateName, d.vCountryName, vEMailId, vMobileNo, w_vMobileNo
        FROM post_addr a, country d, ng_state e, localarea f 
        WHERE a.cPostalCountryId = d.cCountryId
        AND a.cPostalStateId = e.cStateId
        AND a.cPostalLGAId = f.cLGAId
        AND vApplicationNo = ?");
        $stmt->bind_param("s", $vApplicationNo);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($vPostalAddress, $vPostalLGADesc, $vPostalCityName, $vPostalStateName, $vPostalCountryName, $vEMailId, $vMobileNo, $w_vMobileNo);
        $stmt->fetch();
        $stmt->close();

        $txt = $vPostalAddress.', '.$vPostalCityName.', '.$vPostalLGADesc.', '.$vPostalStateName.', '.$vPostalCountryName;
        $pdf->Cell(0,15, $txt, $border, 1,'L');

        $txt = "Dear $namess";
        //if ($vTitle <> ''){$txt .= ' ('.$vTitle.')';}
        $txt .=   ' ['.$vApplicationNo.']';
        $pdf->Cell(0, 15, $txt ,$border, 1,'L');

        $pdf -> SetY(235);

        $pdf->SetFont('', 'B',11);
        $pdf->Cell(0,$row_height_25,'Offer of Conditional Admission',$border, 1,'C');
        $pdf->SetFont('', 'B',10);
        $pdf -> SetY(260);

        $txt = '['.$cAcademicDesc.' Session]';
        $pdf->Cell(0,10, $txt, $border, 1,'C');
        
        $pdf->SetFont('', '',10);

        $pdf -> SetY(280);
        
        $orgsetins = settns();

        $txt = "1. I am pleased to inform you that you have been offered a conditional offer of admission into ".$orgsetins['vOrgName']." to pursue a programme leading to the award of $vObtQualTitle in the Commonwealth of Learning.";
        $pdf->MultiCell(0, 17, $txt, $border);

        $pdf -> SetY(340);
        $txt = "2. To gain a full admission, you are expected to request your institution to forward your academic transcript to the address below:
        The Secretary,
        School of Postgraduate Studies,
        National Open University of Nigeria (NOUN),
        Plot 91, Cadastral Zone, University Village,
        Nnamdi Azikiwe Expressway,
        Jabi, Abuja, FCT.
        Note: NOUN does not receive transcripts from prospective students directly";
        $pdf->MultiCell(0, 17, $txt, $border);

        $pdf -> SetY(490);
        $txt = "3. You are required to undergo interview as prescribed by the Faculty.";
        $pdf->MultiCell( 0, 30, $txt, $border);

        $pdf -> SetY(520);
        $txt = "4. The University reserves the right to change your programme if you do not meet the criteria for admission into the programme for which you have been conditionally admitted.";
        $pdf->MultiCell(0, 17, $txt, $border);

        $pdf -> SetY(560);
        $txt = "5. The University further reserves the right to withdraw your admission whenever it is discovered that you have given false information or falsified any result or record.";
        $pdf->MultiCell(0, 17, $txt, $border);

        $pdf -> SetY(600);
        $txt = "6. Applicants are to note that graduation from their chosen programme is predicated on meeting all Department, Faculty and University graduation requirements including a CGPA of 3.00.";
        $pdf->MultiCell(0, 17, $txt, $border);

        $pdf -> SetY(640);
        $txt = "7. For Further enquiries contact the National Open University of Nigeria Commonwealth of Learning via cemba.cempa@noun.edu.ng";
        $pdf->MultiCell(0, 17, $txt, $border);

        $pdf -> SetY(680);
        $pdf->Cell(0,$row_height_25, 'Congratulations!',$border, 1,'L');

        $pdf->Image(BASE_FILE_NAME_FOR_IMG.'reg_sig.png',59,715,100,20,'PNG');

        try
        {
            $pdf->Image(get_pp_pix(''),455,173,100,110,'JPG');
        }catch(Exception $e) 
        {
            echo 'Upload passport picture';
            exit;
        }
        //$pdf->Image(get_pp_pix(''),470,680,80,95,'JPG');

        $pdf -> SetY(740);
        $txt = "Oladipo A. Ajayi";
        $pdf->SetFont('', 'B',10);
        $pdf->Cell(0,15,$txt,$border, 1,'L');        
        
        $pdf -> SetY(755);
        $pdf->SetFont('', '',8);
        $pdf->Cell(0,10,'Registrar',$border, 1,'L');
        //$pdf->Cell(0,11,'Deputy Registrar,',$border, 1,'L');        
        //$pdf->Cell(0,11,'Secretary, School of Postgraduate Studies',$border, 1,'L');
        $pdf->Output();  
    }
}else if (isset($_REQUEST["arch_mode_hd"]) && $_REQUEST["arch_mode_hd"] == '1')
{?>
    <div style="margin:50px auto; width:350px; text-align:center; padding:20px; background-color:#eff5f0">
        Application form not in the archive
    </div><?php
    exit;
}else
{?>
    <div style="margin:50px auto; width:350px; text-align:center; padding:20px; background-color:#eff5f0">
        Application form not submitted
    </div><?php
    exit;
}?>