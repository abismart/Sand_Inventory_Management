<?php
require "fpdf.php";
if(@$_GET["customer_name"]){
      $customername = $_GET["customer_name"];
      }
 $fromdate = $_GET["fromdate"];
 $todate = $_GET["todate"];
$db = new PDO('mysql:host=localhost;dbname=sandinventory','root','');
$date = date("d"+"/"+"m"+"/"+"y");
class myPDF extends FPDF{
	function header(){
		$this->SetFont('helvetica','B',20);
		$this->Cell(276,10,'SAND INVENTORY REPORT',0,0,'C');
		$this->Ln(20);
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',12);
		$this->Cell(0,10,"Page " . $this->PageNo() . "/{totalPages}",0,0,'C');
		$this->Cell(0, 10, "Date:".date("m/d/Y")."",0, 0, 'R');
		$this->SetFont('Arial','',12);
	}
	function headerTable(){
		 $customername = strtoupper($_GET["customer_name"]);
		$this->SetFont('helvetica','B',12);
		$this->setFillColor(65,105,225);
		$this->SetTextColor(255,255,255);
		$this->Cell(0,10,$customername,1,0,'C',TRUE);
		$this->Ln();
		$this->setFillColor(162,217,255);
		$this->SetTextColor(0,0,0);
		$this->Cell(20,10,'ID',1,0,'C',TRUE);
		$this->Cell(30,10,'DATE',1,0,'C',TRUE);
		$this->Cell(40,10,'VEHICLE NO',1,0,'C',TRUE);
		$this->Cell(30,10,'BILL NO',1,0,'C',TRUE);
		$this->Cell(55,10,'MATERIAL',1,0,'C',TRUE);
		$this->Cell(22,10,'UNIT',1,0,'C',TRUE);
		$this->Cell(40,10,'RATE',1,0,'C',TRUE);
		$this->Cell(40,10,'LOCATION NO',1,0,'C',TRUE);
		$this->Ln();
	}
	function viewTable($db){
		 $customername = $_GET["customer_name"];
		 $fromdate = $_GET["fromdate"];
		 $todate = $_GET["todate"];
		$this->SetFont('helvetica','',12);
		$stmt = $db->query('SELECT * FROM records WHERE date BETWEEN "'.$fromdate.'" AND "'.$todate.'" and customer_name = "'.$customername.'"');
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){
		$this->Cell(20,10,$data->id,1,0,'C');
		$this->Cell(30,10,$data->date,1,0,'C');
		$this->Cell(40,10,$data->vehicle_no,1,0,'C');
		$this->Cell(30,10,$data->bill_no,1,0,'C');
		$this->Cell(55,10,$data->material,1,0,'C');
		$this->Cell(22,10,$data->unit,1,0,'C');
		$this->Cell(40,10,$data->rate,1,0,'C');
		$this->Cell(40,10,$data->location_no,1,0,'C');		
		$this->Ln();
		}
		$this->Ln(10);
	}
	function reportTable(){
		 $customername = strtoupper($_GET["customer_name"]);
		$this->SetFont('helvetica','B',12);
		$this->setFillColor(65,105,225);
		$this->SetTextColor(255,255,255);
		$lMargin = ($this->GetPageWidth() - 247) / 2;
		$this->SetLeftMargin($lMargin);
		$this->Cell(30,10,'MATERIAL',1,0,'C',TRUE);
		$this->Cell(30,10,'UNIT*RATE',1,0,'C',TRUE);
		$this->Cell(40,10,'TOTAL RATE',1,0,'C',TRUE);
		$this->Cell(30,10,'DISEL',1,0,'C',TRUE);
		$this->Cell(55,10,'DRIVER',1,0,'C',TRUE);
		$this->Cell(22,10,'RENT',1,0,'C',TRUE);
		$this->Cell(40,10,'TOTAL',1,0,'C',TRUE);
		$this->Ln();
	}
	function viewreportTable($db){
		 $customername = $_GET["customer_name"];
		$this->SetTextColor(0,0,0);
		$this->SetFont('helvetica','',12);
		$fromdate = $_GET["fromdate"];
		$todate = $_GET["todate"];
		$lMargin = ($this->GetPageWidth() - 247) / 2;
		$this->SetLeftMargin($lMargin);
		$stmt = $db->query('SELECT DISTINCT unit,material FROM records WHERE date BETWEEN "'.$fromdate.'" AND "'.$todate.'" and customer_name = "'.$customername.'"');
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){
		$this->Cell(30,10,$data->material,1,0,'C');
		$rate = ($data->material == "msand" ? '2300' : '1700');

		$this->Cell(30,10,$data->unit."*".$rate,1,0,'C');
		$totalrate = $data->unit*$rate;
		$this->Cell(40,10,$totalrate,1,0,'C');
		$this->Cell(30,10,'1300',1,0,'C');
		$this->Cell(55,10,'700',1,0,'C');
		$rent = ($data->material == "msand" ? '2000' : '1800');
		$this->Cell(22,10,$rent,1,0,'C');
		$total = $totalrate+1300+700+$rent;
		$this->Cell(40,10,$total,1,0,'C');
		$this->Ln();
		}
	}
}
$pdf = new myPDF();
$pdf->AliasNbPages('{totalPages}');
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->reportTable();
$pdf->viewreportTable($db);
$pdf->Output();
?>