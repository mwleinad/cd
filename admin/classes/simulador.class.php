<?php 

class Simulador extends Main
{
	private $idSimulador;
	private $montoAFinanciar;
	private $tasa;
	private $ivaTasa;
	private $totalTasa;
	private $cuotaApertura;
	private $ivaCuota;
	private $totalCoutaApertura;
	private $tipoDeNomina;
	private $descuento;
	private $pago;
	private $sueldoMensual;

	public function setIdSimulador($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idSimulador = $this->Util->EncodeSpanish($value);
	}

	public function getIdSimulador()
	{
		return $this->idSimulador;
	}

	public function setMontoAFinanciar($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->montoAFinanciar = $this->Util->EncodeSpanish($value);
	}

	public function getMontoAFinanciar()
	{
		return $this->montoAFinanciar;
	}

	public function setTasa($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->tasa = $this->Util->EncodeSpanish($value);
	}

	public function getTasa()
	{
		return $this->tasa;
	}

	public function setIvaTasa($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->ivaTasa = $this->Util->EncodeSpanish($value);
	}

	public function getIvaTasa()
	{
		return $this->ivaTasa;
	}

	public function setTotalTasa($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->totalTasa = $this->Util->EncodeSpanish($value);
	}

	public function getTotalTasa()
	{
		return $this->totalTasa;
	}

	public function setCuotaApertura($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->cuotaApertura = $this->Util->EncodeSpanish($value);
	}

	public function getCuotaApertura()
	{
		return $this->cuotaApertura;
	}

	public function setIvaCuota($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->ivaCuota = $this->Util->EncodeSpanish($value);
	}

	public function getIvaCuota()
	{
		return $this->ivaCuota;
	}

	public function setTotalCoutaApertura($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->totalCoutaApertura = $this->Util->EncodeSpanish($value);
	}

	public function getTotalCoutaApertura()
	{
		return $this->totalCoutaApertura;
	}

	public function setTipoDeNomina($value)
	{
		$this->tipoDeNomina = $this->Util->EncodeSpanish($value);
	}

	public function getTipoDeNomina()
	{
		return $this->tipoDeNomina;
	}

	public function setDescuento($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->descuento = $this->Util->EncodeSpanish($value);
	}

	public function getDescuento()
	{
		return $this->descuento;
	}

	public function setPago($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->pago = $this->Util->EncodeSpanish($value);
	}

	public function getPago()
	{
		return $this->pago;
	}

	public function setSueldoMensual($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->sueldoMensual = $this->Util->EncodeSpanish($value);
	}

	public function getSueldoMensual()
	{
		return $this->sueldoMensual;
	}

	public function Enumerate()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM simulador ORDER BY idSimulador ASC');
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
		}
		return $result;
	}

	public function Info()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM simulador WHERE idSimulador = '".$this->idSimulador."'");
		$row = $this->Util()->DB()->GetRow();
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				simulador
			SET
				`idSimulador` = '".$this->idSimulador."',
				`montoAFinanciar` = '".$this->montoAFinanciar."',
				`tasa` = '".$this->tasa."',
				`ivaTasa` = '".$this->ivaTasa."',
				`totalTasa` = '".$this->totalTasa."',
				`cuotaApertura` = '".$this->cuotaApertura."',
				`ivaCuota` = '".$this->ivaCuota."',
				`totalCoutaApertura` = '".$this->totalCoutaApertura."',
				`tipoDeNomina` = '".$this->tipoDeNomina."',
				`descuento` = '".$this->descuento."',
				`pago` = '".$this->pago."',
				`sueldoMensual` = '".$this->sueldoMensual."'
			WHERE idSimulador = '".$this->idSimulador."'");
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				simulador
			(
				`idSimulador`,
				`montoAFinanciar`,
				`tasa`,
				`ivaTasa`,
				`totalTasa`,
				`cuotaApertura`,
				`ivaCuota`,
				`totalCoutaApertura`,
				`tipoDeNomina`,
				`descuento`,
				`pago`,
				`sueldoMensual`
		)
		VALUES
		(
				'".$this->idSimulador."',
				'".$this->montoAFinanciar."',
				'".$this->tasa."',
				'".$this->ivaTasa."',
				'".$this->totalTasa."',
				'".$this->cuotaApertura."',
				'".$this->ivaCuota."',
				'".$this->totalCoutaApertura."',
				'".$this->tipoDeNomina."',
				'".$this->descuento."',
				'".$this->pago."',
				'".$this->sueldoMensual."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20003, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			DELETE FROM
				simulador
			WHERE
				idSimulador = '".$this->idSimulador."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(20002, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

}

?>