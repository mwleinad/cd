<?php

class PaymentCompra extends Util
{
	private $amount;
	public function setAmount($value)
	{
		if(!is_numeric($value)){
			$this->Util()->setError(10041, "error", "El importe solo permite números");
		}elseif($value <= 0){
			$this->Util()->setError(10041, "error", "El importe no permite números menores o igual a cero");
		}else{
			$this->Util()->ValidateRequireField($value, 'Importe del Pago');
			//$this->Util()->ValidateFloat($value,2,10000000,1);		
			$this->amount = $value;		
		}
	}//setAmount($value)
	
	public function getAmount()
	{
		return $this->amount;
	}	

	private $paymentId;
	
	public function setPaymentId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->paymentId = $value;
	}
	
	public function getPaymentId()
	{
		return $this->paymentId;
	}	

	private $comprobanteId;
	
	public function setComprobanteId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->comprobanteId = $value;
	}
	
	public function getComprobanteId()
	{
		return $this->comprobanteId;
	}	
	
	function AddPayment()
	{		
		$compra = new Compra;
		$infoComprobante = $compra->GetInfo($this->comprobanteId);

		if($this->amount > round( $infoComprobante["debt_noformat"] , 2 ))
		{
			$this->Util()->setError(10041, "error", "El pago no puede ser mayor a la deuda");
		}
		if($this->Util()->PrintErrors()){ return false; }
				
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			INSERT INTO `paymentCompra` ( 
				`compraId`, 
				`amount`, 
				`paymentDate`
				) 
			VALUES (
				'".$this->comprobanteId."',
				'".$this->amount."',
				'".date("Y-m-d")."'
			)"
			);
		$sucursalId = $this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();

		$this->Util()->setError(20030, "complete", "");
		$this->Util()->PrintErrors();
	echo "jere";		
		return true;
	}

	function Info()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			SELECT * FROM paymentCompra 
			WHERE paymentId ='".$this->paymentId."'");
		$payment = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
	
		return $payment;
	}

	function Enumerate()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			SELECT * FROM paymentCompra 
			WHERE compraId ='".$this->comprobanteId."'");
		$payments = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
	
		return $payments;
	}
	
		
	function GetSucursalesByRfc()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			SELECT * FROM sucursal 
			LEFT JOIN rfc ON rfc.rfcId = sucursal.rfcId
			WHERE sucursal.rfcId ='".$this->getRfcId()."'");
		$sucursales = $this->Util()->DBSelect($this->getEmpresaId())->GetResult();
	
		return $sucursales;
	}
	
	function DeletePayment()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("DELETE FROM paymentCompra WHERE paymentId = '".$this->paymentId."'");
		$this->Util()->DBSelect($_SESSION["empresaId"])->DeleteData();
		$this->Util()->setError(20008, "complete", "Has eliminado el pago exitosamente");
		$this->Util()->PrintErrors();
		return true;
	}
	
	function GetVentaByCompId()
	{	
		$sql = "SELECT notaVentaId FROM notaVenta
				WHERE comprobanteId = '".$this->comprobanteId."'";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$notaVentaId = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
	
		return $notaVentaId;
	}
	
}


?>