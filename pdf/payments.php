<?php 

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$id_comprobante = $_GET['id'];			
$infoComprobante =  $comprobante->GetInfoComprobante($id_comprobante);
$payment->setComprobanteId($id_comprobante);
$payments = $payment->Enumerate($id_comprobante);

//print_r($payments); exit(0);

//require(DOC_ROOT.'/pdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Pagos realizados al comprobante numero '.$infoComprobante['comprobanteId']);

$pdf->setXY(10,30);
$pdf->Cell(40,10,'Fecha',1,'','C');
$pdf->setXY(50,30);
$pdf->Cell(100,10,'Importe',1,'','C');

$yy = 10;
$totalPayments = 0;
foreach($payments as $key => $resPayment)
{
	$pdf->setXY(10,30+$yy);
	$pdf->Cell(40,10,$resPayment['paymentDate'],1,'','C');
	$pdf->setXY(50,30+$yy);
	$pdf->Cell(100,10,'$'.$resPayment['amount'],1,'','R');
	$yy += 10;
	$totalPayments += $resPayment['amount'];
}

$pdf->setXY(10,30+$yy);
$pdf->Cell(40,10,'TOTAL',1,'','C');
$pdf->setXY(50,30+$yy);
$pdf->Cell(100,10,'$'.$totalPayments,1,'','R');

$pdf->Output();

?>
