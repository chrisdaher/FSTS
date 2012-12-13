<?php


$id= $_POST["id"];
$isEvent = $_POST["isEvent"];
$html = $_POST["toPrint"];
if($isEvent == "true"){
    $isEvent = true;
}else{
    $isEvent == false;
}

require_once('../../../fpdf/html2fpdf/html2fpdf.php');
$pdf=new HTML2FPDF();
@$pdf->AddPage();
@$pdf->setFont('Arial', "B", 18);
@$pdf->WriteHTML($html);
@$pdf->Output("../../../pdf/Attendance/Attendance_$id.pdf");
echo "pdf/Attendance/Attendance_$id.pdf";

?>