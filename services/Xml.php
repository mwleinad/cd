<?php
class Xml extends Producto{

    private $data;
    private $totales;
    private $tipoDeCambio;

    private $horasExtraImporte;
    private $totalPercepciones;
    private $totalDeducciones;
    private $totalOtrosPagos;

    private $miEmpresa;
    //TODO move the xml to an object to make it global
    private $xml;
    private $root;
    private $emisor;
    private $receptor;

    private $tipoComprobante;

    function Generate($data, $totales, $nodosConceptos,$empresa)
    {
        $this->data = $data;
        $this->totales = $totales;

        $this->miEmpresa = $this->Info();

        $this->xml = new DOMdocument("1.0","UTF-8");

        $this->formatDate();
        $this->getTipoComprobante();

        $this->buildNodoRoot();
        exit;

        $this->buildNodoCfdisRelacionados();

        $this->buildNodoEmisor();

        $this->buildNodoReceptor();

        $this->buildNodoConceptos();

        $this->buildNodoImpuestos();

        $this->buildNodoComplementos();

        $this->root->setAttribute("xsi:schemaLocation", "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd ".$this->xsdNomina." ".$this->xsdDonataria." ".$this->xsdImplocal);

        return $this->save();
    }

    private function CargaAtt(&$nodo, $attr)
    {
        foreach ($attr as $key => $val)
        {
            if (strlen($val)>0)
            {
                $nodo->setAttribute($key,$val);
            }
        }
    }

    private function fromNominaChanges() {
        $this->tipoDeCambio = $this->Util()->CadenaOriginalVariableFormat($this->data["tipoDeCambio"], false,false, false, false, true);

        $this->horasExtraImporte = 0;
        if(count($_SESSION["horasExtras"]) > 0)
        {
            foreach($_SESSION["horasExtras"] as $myHoraExtra)
            {
                $this->horasExtraImporte += $myHoraExtra["importePagado"];
            }
        }

        $this->totalPercepciones = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] +
            $_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"];

        $this->totalDeducciones = $_SESSION["conceptos"]["1"]["deducciones"]["totalGravado"] +
            $_SESSION["conceptos"]["1"]["deducciones"]["totalExcento"] +
            $_SESSION["conceptos"]["1"]["incapacidades"]["total"];

        $this->totalOtrosPagos = 0;
        foreach($_SESSION["otrosPagos"] as $key => $value)
        {
            $this->totalOtrosPagos += $value["importe"];
        }

        $this->totales["subtotal"] = $this->totalPercepciones + $this->totalOtrosPagos + $this->horasExtraImporte;
        $this->totales["descuento"] = $this->totalDeducciones;
        $this->totales["total"] = $this->totales["subtotal"] - $this->totales["descuento"] ;
    }

    private function buildNodoCfdisRelacionados() {
        //TODO nodo cfdis relacionados
        //Para comprobante tipo P el tipo debe de ser 04 (si existen errores)
        //CFDIs relacionados 0, 1 o mas (probablemente lo limitare a uno)
        //CFDI relacionado
        //TipoRelacion
        //01 o 02, no pueden ser registradas tipos T, P o N
        //03, no se pueden registar tipos E, P o N
        //04 si es del tipo I o E puede sustituir a un comprobante tipo I o E de lo contrario debe de ser
        //del mismo tipo
        //05, debe de ser del tipo T y el comprobante relacionado debe ser del tipo I o E
        //06, debe de ser del tipo I o E, y el comprobante relacionado debe de ser del tipo Y
        //UUID

    }

    private function buildNodoRoot() {

        $this->root = $this->xml->createElement("cfdi:Comprobante");
        $this->root = $this->xml->appendChild($this->root);

        $this->root->setAttribute("xmlns:cfdi", "http://www.sat.gob.mx/cfd");
        $this->root->setAttribute("xmlns:cfdi", "http://www.sat.gob.mx/cfd/3");
        $this->root->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");

        if($this->totales['porcentajeISH'] > 0){
            $this->root->setAttribute("xmlns:implocal", "http://www.sat.gob.mx/implocal");
        }

        if($this->miEmpresa['donatarias'] == "Si"){
            $this->root->setAttribute("xmlns:implocal", "http://www.sat.gob.mx/donat");
        }

        $this->tipoDeCambio = $this->Util()->CadenaOriginalVariableFormat($this->data["tipoDeCambio"], true,false, true);
        if($this->data["fromNomina"])
        {
            $this->fromNominaChanges();
        }

        $this->CargaAtt($this->root, $this->buildRootData());
    }

    private function getTipoComprobante() {
        $this->tipoComprobante = strtoupper(substr($this->data["tipoDeComprobante"],0,1));
    }

    private function isTraspaso() {
        return $this->tipoComprobante == 'T';
    }

    private function isPago() {
        return $this->tipoComprobante == 'P';
    }

    private function isIngreso() {
        return $this->tipoComprobante == 'I';
    }

    private function isEgreso() {
        return $this->tipoComprobante == 'E';
    }

    private function isNomina() {
        return $this->tipoComprobante == 'N';
    }

    private function buildRootData() {

        $rootData["Version"] = "3.3";
        $rootData["Serie"] = $this->Util()->CadenaOriginalVariableFormat($this->data["serie"]["serie"],false,false);
        $rootData["Folio"] = $this->Util()->CadenaOriginalVariableFormat($this->data["folio"],false,false);
        $rootData["Fecha"] = $this->Util()->CadenaOriginalVariableFormat($this->data["fecha"],false,false);
        $rootData["Sello"] = $this->data["sello"];

        //TODO viene del catalogo de formas de pago
        if(!$this->isPago()) {
            $rootData["FormaDePago"] = $this->Util()->CadenaOriginalVariableFormat($this->data["formaDePago"],false,false);
        }

        $rootData["NoCertificado"] = $this->Util()->CadenaOriginalVariableFormat($this->data["noCertificado"],false,false);

        $rootData["Certificado"] = $this->data["certificado"];

        if($this->isIngreso() || $this->isEgreso()){
            $rootData["CondicionesDePago"] = $this->Util()->CadenaOriginalVariableFormat($this->data["condicionesDePago"],false,false);
        }

        $rootData["SubTotal"] = $this->Util()->CadenaOriginalVariableFormat($this->totales["subtotal"],true,false);
        if($this->isTraspaso() || $this->isPago()){
            $rootData["SubTotal"] = 0;
        }

        if(!$this->isTraspaso() && !$this->isPago() && $this->totales["descuento"] > 0){
            $rootData["Descuento"] = $this->Util()->CadenaOriginalVariableFormat($this->totales["descuento"], true,false);
        }

        $rootData["Moneda"] = $this->Util()->CadenaOriginalVariableFormat($this->data["tiposDeMoneda"], false,false);

        if($this->isPago()){
            $rootData["Moneda"] = "XXX";
        }

        //TODO algo raro con el % de asignacion, no me preocupare de ello por ahora, checar si
        //puede aplicar cuando sea MXN
        if(!$this->isPago()){
            $rootData["TipoCambio"] =  $this->Util()->CadenaOriginalVariableFormat($this->tipoDeCambio, true,false);;
        }

        //Si el campo es del tipo T o P debe de ser 0
        $rootData["Total"] = $this->Util()->CadenaOriginalVariableFormat($this->totales["total"], true,false);
        if($this->isPago() || $this->isTraspaso()){
            $rootData["Total"] = 0;
        }

        $rootData["TipoDeComprobante"] = $this->tipoComprobante;

        //TODO viene de catalogo metodo de pago
        //Revisar tipo de pago PPD, es posible que no lo soportemos por ahora.
        $rootData["MetodoDePago"] = $this->Util()->CadenaOriginalVariableFormat($this->data["metodoDePago"],false,false);

        $rootData["LugarExpedicion"] = $this->Util()->CadenaOriginalVariableFormat($this->data["nodoEmisor"]["rfc"]["cp"],false,false);

        //TODO confirmacion, pendiente por ahora, posiblemente no se soporte
        //$rootData["Confirmacion"] = $this->Util()->CadenaOriginalVariableFormat($this->data["NumCtaPago"],false,false);

        //TODO No debe existir el nodo impuestos si el tipo es T, P o N

        print_r($rootData);
        return $rootData;
    }

    private function buildNodoEmisor() {
        $this->emisor = $this->xml->createElement("cfdi:Emisor");
        $this->emisor = $this->root->appendChild($this->emisor);

        $emisorData = array(
            "Rfc"=>$this->Util()->CadenaOriginalVariableFormat($this->data["nodoEmisor"]["rfc"]["rfc"],false,false),
            "Nombre"=>$this->Util()->CadenaOriginalVariableFormat($this->data["nodoEmisor"]["rfc"]["razonSocial"],false,false),
            "RegimenFiscal"=>$this->Util()->CadenaOriginalVariableFormat($this->data["nodoEmisor"]["rfc"]["regimenFiscal"],false,false)
        );

        $this->CargaAtt($this->emisor, $emisorData);

    }

    private function buildNodoReceptor() {
        $this->receptor = $this->xml->createElement("cfdi:Receptor");
        $this->receptor = $this->root->appendChild($this->receptor);

        $receptorData = array(
            "Rfc"=>$this->Util()->CadenaOriginalVariableFormat($this->nodoReceptor["rfc"],false,false),
            "Nombre"=>$this->Util()->CadenaOriginalVariableFormat($this->nodoReceptor["nombre"],false,false)
            //TODO Residencia fiscal, viene del catalogo c_Pais, obligatorio para rfcs extranjeros
            //NumRegIdTrib, obligatorio con complemento de comercio exterior
            //solo para extranjeros
            //UsoCfdi para complemento de pagos se debe usar P01
        );

        $this->CargaAtt($receptor, $receptorData);
    }

    private function formatDate() {
        //	$this->data["fecha"] = "2010-09-22T07:45:09";
        $this->data["fecha"] = explode(" ", $this->data["fecha"]);
        $this->data["fecha"] = $this->data["fecha"][0]."T".$this->data["fecha"][1];
    }

    private function buildNodoConceptos() {
        $conceptos = $xml->createElement("cfdi:Conceptos");
        $conceptos = $root->appendChild($conceptos);
        //TODO para complemento de pagos se debe capturar 84111506
        //para P no debe existir el NoIdentificacion, en unidad debe ser ACT, descripcion debe ser pago, unitario
        //importe deben de ser 0, descuento no debe existir
        foreach($nodosConceptos as $concepto)
        {
            $myConcepto = $xml->createElement("cfdi:Concepto");

            if($data["fromNomina"])
            {
                $cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false,false,false,true);
                $concepto["unidad"] = "ACT";
                $concepto["descripcion"] = "Pago de nómina";
                $concepto["valorUnitario"] = $totales["subtotal"];
                $concepto["importe"] = $totales["subtotal"];
            }
            else
            {
                $cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],true,false);
            }

            $myConcepto = $conceptos->appendChild($myConcepto);
            $this->CargaAtt($myConcepto, array(
                    //TODO ClaveProdServ el generico es 01010101
                    "NoIdentificacion"=>$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false),
                    "Cantidad"=>$cantidad,
                    //TODO ClaveUnidad hacer un catalogo mas simple de posibles claves
                    "Unidad"=>$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
                    "Descripcion"=>$this->Util()->CadenaOriginalVariableFormat($concepto["descripcion"],false,false),
                    "ValorUnitario"=>$this->Util()->CadenaOriginalVariableFormat($concepto["valorUnitario"],true,false),
                    "Importe"=>$this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true,false),
                    //TODO Decuento
                )
            );

            //TODO ahora cada concepto lleva Nodo Impuestos, Retenciones y Traslados
            //para P esto no existe
            /*			$this->CargaAtt($traslado, array(
                                    //TODO Base, es el valor del calculo de impuesto que se traslada, Cuando TipoFactor sea Tasa
                                    //este campo puede tener solo los decimales que tenga la moneda y si es Cuota, hasta 6 decimales
                                    //TODO viene del catalogo impuesto
                                        "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("IVA",false,false),
                                    //TODO TipoFactor viene del catalogo c_TipoFactor
                                    //TODO TasaOCuota registrar
                                    //"tasa" => $this->Util()->CadenaOriginalVariableFormat($totales["tasaIva"],true,false),
                                    //TODO importe solo va si el tipo de factor es tasa o cuota
                                        "Importe" => $this->Util()->CadenaOriginalVariableFormat($totales["iva"],true,false)
                                )
                        );*/

            //TODO informacion aduanera
            if(strlen($concepto["cuentaPredial"]) > 0)
            {
                $cuentaPredial = $xml->createElement("cfdi:CuentaPredial");
                $cuentaPredial = $myConcepto->appendChild($cuentaPredial);
                $this->CargaAtt($cuentaPredial, array(
                        "Numero"=>$this->Util()->CadenaOriginalVariableFormat($concepto["cuentaPredial"],false,false),
                    )
                );
            }

            //TODO complemento concepto  (probablemente nunca se haga)
            //TODO parte (probablemente nunca se haga)
        }
    }

    private function buildNodoImpuestos() {
        $impuestos = $xml->createElement("cfdi:Impuestos");
        $impuestos = $root->appendChild($impuestos);

        if(!$data["fromNomina"])
        {
            $this->CargaAtt($impuestos, array(
                    "TotalImpuestosRetenidos" => $this->Util()->CadenaOriginalVariableFormat($totales["retIsr"]+$totales["retIva"],true,false),
                    "TotalImpuestosTrasladados" => $this->Util()->CadenaOriginalVariableFormat($totales["iva"]+$totales["ieps"],true,false))
            );

            $retenciones = $xml->createElement("cfdi:Retenciones");
            $retenciones = $impuestos->appendChild($retenciones);

            $retencion = $xml->createElement("cfdi:Retencion");
            $retencion = $retenciones->appendChild($retencion);

            $this->CargaAtt($retencion, array(
                    //TODO viene del catalogo impuesto
                    "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("IVA",false,false),
                    //TODO TasaOCuota registrar
                    "Importe" => $this->Util()->CadenaOriginalVariableFormat($totales["retIva"],true,false)
                )
            );

            //TODO checar esta otra retencion
            /*			$retencion = $xml->createElement("cfdi:Retencion");
                        $retencion = $retenciones->appendChild($retencion);

                        $this->CargaAtt($retencion, array(
                                        "impuesto" => $this->Util()->CadenaOriginalVariableFormat("ISR",false,false),
                                        "importe" => $this->Util()->CadenaOriginalVariableFormat($totales["retIsr"],true,false))
                        );*/

            $traslados = $xml->createElement("cfdi:Traslados");
            $traslados = $impuestos->appendChild($traslados);

            $traslado = $xml->createElement("cfdi:Traslado");
            $traslado = $traslados->appendChild($traslado);

            $this->CargaAtt($traslado, array(
                    //TODO Base, es el valor del calculo de impuesto que se traslada, Cuando TipoFactor sea Tasa
                    //este campo puede tener solo los decimales que tenga la moneda y si es Cuota, hasta 6 decimales
                    //TODO viene del catalogo impuesto
                    "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("IVA",false,false),
                    //TODO TipoFactor viene del catalogo c_TipoFactor
                    //TODO TasaOCuota registrar
                    //"tasa" => $this->Util()->CadenaOriginalVariableFormat($totales["tasaIva"],true,false),
                    //TODO importe solo va si el tipo de factor es tasa o cuota
                    "Importe" => $this->Util()->CadenaOriginalVariableFormat($totales["iva"],true,false)
                )
            );

            //TODO checar traslado del IEPS
            /*			$traslado = $xml->createElement("cfdi:Traslado");
                        $traslado = $traslados->appendChild($traslado);

                        $this->CargaAtt($traslado, array(
                                "impuesto" => $this->Util()->CadenaOriginalVariableFormat("IEPS",false,false),
                                "tasa" => $this->Util()->CadenaOriginalVariableFormat($totales["porcentajeIEPS"],true,false),
                                "importe" => $this->Util()->CadenaOriginalVariableFormat($totales["ieps"],true,false))
                                            );
                        }*/
        }
    }

    private function buildNodoComplementos() {
        //TODO Para tipo N, P, o T no debe existir
        $complementos = $xml->createElement("cfdi:Complemento");
        $complementos = $root->appendChild($complementos);

        if($data["fromNomina"])
        {
            include_once(DOC_ROOT."/classes/complemento_nomina_12_xml.php");
            $this->xsdNomina = "http://www.sat.gob.mx/nomina http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd";
        }

        if($miEmpresa["donatarias"] == "Si")
        {
            include_once(DOC_ROOT."/addComplementos/complemento_donataria_xml.php");
            $this->xsdDonataria = "http://www.sat.gob.mx/donat http://www.sat.gob.mx/sitio_internet/cfd/donat/donat11.xsd";
        }

        if($totales['porcentajeISH'] > 0){
            include_once(DOC_ROOT."/addImpuestos/complemento_ish_xml.php");
            $this->$xsdImplocal = "http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd";

        }

        //TODO complemento pagos
        /*Nodo Pagos
            Version 1.0
            Nodo Pago
                FechaPago (puede uno poner la fecha que uno desee)
                FormaPagoP (viene del catalogo c_FormaPago)
                MonedaP
                TipoCambioP (debe existir si es diferente de MXN)
                Monto
                NumOperacion
                RfcEmisorCtaOrd opcional (probablemente no se ponga) rfc de la cuenta del emisor a donde se hizo el deposito
                NomBancoOrdExt (requerido si el RfcEmosorCtaOrd es extranjera probablemente no lo usaremos)
                CtaOrdenante (opcional)
                RfcEmisorCtaBen (opcional)
                CtaBeneficiario (opcional)
                TipoCadPago (opcional)
                CertPago (opcional)
                CadPago (opcional)
                SelloPago (opcional)
            Nodo DoctoRelacionado
                idDocumento (uuid)
                Serie
                Folio
                MonedaDR
                TipoCambioDR (opcional)
                MetodoPagoDR (se debe capturar PPD)
                NumParcialidad
                ImpSaldoAnt (lo que aun se debe)
                ImpPagado (lo que se va pagando)
                ImpSaldoInsoluto (resta ImpSaldoAnt - ImpPagado)*/
    }

    private function save() {
        $nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];

        $rfcActivo = $this->getRfcActive();
        $root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/";
        $rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";

        if(!is_dir($rootFacturas))
        {
            mkdir($rootFacturas, 0777);
        }

        if(!is_dir($root))
        {
            mkdir($root, 0777);
        }

        return $xml->save($root.$nufa.".xml");
    }
}
?>
