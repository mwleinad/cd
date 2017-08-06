<?php

class ComprobantePago extends Comprobante {

    private function generateSerieIfNotExists() {
        $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM serie");
        $serieExistente = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();

        //Create series if it doesn't exists TODO do not let this serie to be deleted or modified, also hide it from other places
        $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM serie WHERE tiposComprobanteId = 10");
        $serie = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();

        if(!$serie) {

            $vs = new User;
            $activeRfc =  $vs->getRfcActive();
            $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			INSERT INTO `serie` (
				`empresaId`,
				`sucursalId`,
				`serie`,
				`folioInicial`,
				`folioFinal`,
				`tiposComprobanteId`,
				`lugarDeExpedicion`,
				`noCertificado`,
				`consecutivo`,
				`rfcId`,
				`sucursalAsignada`
			) VALUES
			(
				'".$_SESSION["empresaId"]."',
				'0',
				'COMPAGO',
				'1',
				'999999999',
				'10',
				'0',
				'".$serieExistente['noCertificado']."',
				'1',
				'".$activeRfc."',
				'0'
			)");
            return $this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
        }

        return $serie['serieId'];
    }

    private function addConcept() {
        unset($_SESSION["conceptos"]);
        $_SESSION["conceptos"][0] = [
            'claveProdServ' => '84111506',
            'cantidad' => 1,
            'claveUnidad' => 'ACT',
            'descripcion' => 'Pago',
            'valorUnitario' => 0,
            'importe' => 0,
            'unidad' => 'NO DEBE EXISTIR', //esto lo quita en la clase xml, pero la clase cfdi espera un valor

        ];
        //TODO check if this needs something else
       /* Array
        (
            [1] => Array
            (
            [] => 1
            [cuentaPredial] =>
            [iepsTasaOCuota] => Tasa
            [porcentajeIeps] => 0
            [totalIeps] => 0
            [porcentajeIsh] => 2
            [totalIsh] => 0.02
            [excentoIsh] =>
            [excentoIva] => no
            [tasaIva] => 16
            [descuento] => 0
            [importeTotal] => 1
            [totalIva] => 0.16
            [totalRetencionIva] => 0
            [totalRetencionIsr] => 0
        )*/
    }

    private function getCfdiRelacionado($infoComprobante) {
        $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM comprobante WHERE comprobanteId = '".$infoComprobante["comprobanteId"]."'");
        $comprobante = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();

        return $comprobante;
    }

    public function generar($infoComprobante, $infoPago){
        $cfdi = new Cfdi();

        $serieId = $this->generateSerieIfNotExists();

        $comprobante = $cfdiRelacionado = $this->getCfdiRelacionado($infoComprobante);

        //no hay comprobante al que asignar el pago
        if(!$comprobante) {
            return;
        }

        $this->addConcept();

        $data = [
            'formatoNormal' => 0,
            'tiposComprobanteId' => '10-'.$serieId,
            'tiposDeMoneda' => 'XXX',
            'cfdiRelacionadoSerie' => $comprobante["serie"],
            'cfdiRelacionadoFolio' => $comprobante["folio"],
            'tipoRelacion' => '04',
            'userId' => $comprobante['userId'],
            'usoCfdi' => 'P01',
            'formaDePago' => 'NO DEBE EXISTIR', //esto lo quita en la clase xml, pero la clase cfdi espera un valor
            'metodoDePago' => 'NO DEBE EXISTIR', //esto lo quita en la clase xml, pero la clase cfdi espera un valor

        ];

/*        Array
        (
    [calle] => CALLE%206
    [pais] => MEXICO
    [ticketChain] =>
    [rfc] => ACO971119HFA
    [razonSocial] => ABASTECEDORA%20DE%20CORRUGADOS%20SA%20DE%20CV%0ADIRECCION%3A%20CALLE%206%20NO%2015%20%20COL%20RUSTICA%20XALOSTOC%20ECATEPEC%20ESTADO%20DE%20MEXICO%20ECATEPEC%20%20MEXICO%20CP%3A%2055340%20%0AEMAIL%3A%20ventas%40trazzos.com
    [formaDePago] => 01
    [NumCtaPago] =>
    [tasaIva] => 16
    [tiposDeMoneda] => MXN
    [tipoDeCambio] =>
    [porcentajeDescuento] =>
    [metodoDePago] => PUE
    [condicionesDePago] =>
    [porcentajeRetIva] => 0
    [porcentajeRetIsr] => 0
    [porcentajeIEPS] =>
    [sucursalId] => 1
    [tiposComprobanteId] => 1-5
    [usoCfdi] => G03
    [type] => agregarConcepto
    [cantidad] => 1
    [noIdentificacion] =>
    [unidad] => a
    [valorUnitario] => 1.000000
    [valorUnitarioCI] => 1.180000
    [excentoIva] => no
    [c_ClaveProdServ] => 01010101
    [c_ClaveUnidad] => EA
    [cuentaPredial] =>
    [iepsTasaOCouta] => Tasa
    [iepsConcepto] =>
    [ishConcepto] => 2
    [descripcion] => a
    [tasa] =>
    [impuestoId] =>
    [iva] => 0
    [importe] => 0
    [tipo] => retencion
    [folioSobre] =>
)*/
        echo "kere";
        if(!$cfdi->Generar($data))
        {
            $error = new Error;
            print_r($error->PrintErrors());
            echo "test";
            $vs = new User;
            $vs->Util()->PrintErrors();
        }
    }
}


?>