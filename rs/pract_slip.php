<?php

include('good_entry.php');
/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");*/

require_once('../../fsher/fisher.php');
require_once('const_def.php');
require_once(BASE_FILE_NAME.'lib_fn.php');

$mysqli = link_connect_db();


$orgsetins = settns();
$semester_begin_date = substr($orgsetins['regdate1'],4,4).'-'.substr($orgsetins['regdate1'],2,2).'-'.substr($orgsetins['regdate1'],0,2);

    $stmt = $mysqli->prepare("SELECT a.vApplicationNo, vTitle, a.vLastName, a.vFirstName, a.vOtherName, a.cFacultyId, b.vFacultyDesc, a.cdeptId, c.vdeptDesc,a.cProgrammeId, d.vObtQualTitle, e.vProgrammeDesc, a.tSemester, a.iStudy_level, session_reg, semester_reg, a.vEMailId, a.vMobileNo, e.cEduCtgId, e.iEndLevel, g.iBeginLevel, a.cAcademicDesc, a.cAcademicDesc_1, a.cStudyCenterId, f.vCityName, a.grad, a.cResidenceCountryId, e.max_crload, h.vEduCtgDesc
    from s_m_t a, faculty b, depts c, obtainablequal d, programme e, prog_choice g , studycenter f, educationctg h
    where a.cFacultyId = b.cFacultyId
    AND a.cdeptId = c.cdeptId
    AND a.cObtQualId = d.cObtQualId
    AND a.cProgrammeId = e.cProgrammeId 
    AND g.vApplicationNo = a.vApplicationNo
    AND a.cStudyCenterId = f.cStudyCenterId
    AND e.cEduCtgId = h.cEduCtgId
    AND a.vMatricNo = ?");
    $stmt->bind_param("s", $_REQUEST['vMatricNo']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vApplicationNo_loc, $vTitle_loc, $vLastName_loc, $vFirstName_loc, $vOtherName_loc, $cFacultyId_loc, $vFacultyDesc_loc, $cdeptId_loc, $vdeptDesc_loc, $cProgrammeId_loc, $vObtQualTitle_loc, $vProgrammeDesc_loc, $tSemester_loc, $iStudy_level_loc, $session_reg_loc, $semester_reg_loc, $vEMailId_loc, $vMobileNo_loc, $cEduCtgId_loc, $iEndLevel_loc, $iBeginLevel_loc, $cAcademicDesc, $cAcademicDesc_1, $cStudyCenterId_loc, $vCityName_loc, $grad, $cResidenceCountryId_loc, $max_crload_loc, $vEduCtgDesc_loc);
    $stmt->fetch();

    
    if (isset($_REQUEST["user_cat"]) && $_REQUEST["user_cat"] == '5')
	{
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
        $pdf->Cell(0,$row_height_25,'Admission slip for host centre for practical sessions',$border, 1,'C');

        $pdf->SetFont('', '',12);
        $pdf->Cell(0,$row_height_25,'Session : '.$orgsetins['cAcademicDesc'],$border, 1,'C');
        $pdf -> SetY(200);

        $pdf->SetFont('', '',12);
        $border = '';
        
        $pdf->Cell(0, $row_height_25, 'Print date : '.date("d-m-Y"), $border, 1,'R');

        $pdf->Cell(200, $row_height_25, 'Name', $border, 0,'L');
        $txt = $vLastName_loc.", ".$vFirstName_loc." ".$vOtherName_loc;
        $pdf->Cell(0, $row_height_25, $txt, $border, 1,'L');
        

        $pdf->Cell(200, $row_height_25, 'Matriculation number', $border, 0,'L');
        $pdf->Cell(0, $row_height_25, $_REQUEST['vMatricNo'], $border, 1,'L');
        

        $pdf->Cell(200, $row_height_25, 'Faculty', $border, 0,'L');
        $pdf->Cell(0, $row_height_25, $vFacultyDesc_loc, $border, 1,'L');
        

        $pdf->Cell(200, $row_height_25, 'Department', $border, 0,'L');
        $pdf->Cell(0, $row_height_25, $vdeptDesc_loc, $border, 1,'L');
        

        $pdf->Cell(200, $row_height_25, 'Programme', $border, 0,'L');
        $txt = $vObtQualTitle_loc." ".$vProgrammeDesc_loc;
        $pdf->Cell(0, $row_height_25, $txt , $border, 1,'L');

        //$pdf->Image(get_pp_pix(''),470,384,80,95,'JPG');
        
        $pdf-> SetY(368);

        $border = 1;


        $stmt = $mysqli->prepare("SELECT a.cCourseId, c.vCourseDesc, CONCAT(b.vCityName,' Study Centre'), a.cwindow
        from pract_centre a, studycenter b, courses c
        where  a.cCentreId = b.cStudyCenterId
        AND a.cCourseId = c.cCourseId
        AND tdate >= '$semester_begin_date'
        AND a.vMatricNo = ?");
        $stmt->bind_param("s", $_REQUEST['vMatricNo']);
        //$stmt->bind_param("ssi", $_REQUEST['cAcademicDesc_loc'], $_REQUEST['tSemester_loc'], $_REQUEST['vMatricNo']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($cCourseId, $vCourseDesc, $vCityName, $cwindow);

        $cnt = 0;
        while ($stmt->fetch())
        {
            $cnt++;
            
            if ($cnt == 1)
            {
                $border = 0;
                $pdf->Cell(0,$row_height_25,$vCityName,$border, 1,'C');
                
                $border = 1;
                $pdf->Cell(55, $row_height_25, 'Code', $border, 0,'L');
                $pdf->Cell(300, $row_height_25, 'Title', $border, 0,'L');
                $pdf->Cell(0, $row_height_25, 'Window', $border, 1,'L');
            }
            $border = 1;

            /*if ($cwindow == 'a')
            {
                $cwindow = '26th August - 7th Sept';
            }else */if ($cwindow == 'b')
            {
                $cwindow = '9th sept - 21st Sept';
            }else if ($cwindow == 'c')
            {
                $cwindow = '23rd Sept - 5th Oct';
            }else if ($cwindow == 'd')
            {
                $cwindow = '7th Oct - 19th Oct';
            }else if ($cwindow == 'e')
            {
                $cwindow = '21st Oct - 2nd Nov';
            }

            $pdf->Cell(55, $row_height_25, $cCourseId, $border, 0,'L');
            $pdf->Cell(300, $row_height_25, $vCourseDesc, $border, 0,'L');
            $pdf->Cell(0, $row_height_25, $cwindow, $border, 1,'L');
        }
               
        $pdf->Output();  
    }?>