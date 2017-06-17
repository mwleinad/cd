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
    private $nodosConceptos;
    //TODO move the xml to an object to make it global
    private $xml;
    private $root;
    private $emisor;
    private $receptor;

    private $trasladosGlobales;
    //TODO debe de existir un campo en traslados por cada tipo de tasa, factor e impuesto :/

    private $tipoComprobante;

    public function CadenaOriginal($xmlFile) {
        $xslFile = DOC_ROOT."/xslt/cadenaoriginal_3_3.xslt";
        $xsl = new DOMDocument();
        $xsl->load($xslFile);

        $proc = new XSLTProcessor;
        $proc->importStyleSheet($xsl);

        $xml = new DOMDocument("1.0","UTF-8");
        $xml->load($xmlFile);
        $cadenaOriginal = $proc->transformToXML($xml);

        $cadenaOriginal = trim($cadenaOriginal);
        $cadenaOriginal = str_replace("\n        |", "|", $cadenaOriginal);

        return $cadenaOriginal;
    }

    function Generate($data, $totales, $nodosConceptos,$empresa)
    {
        $this->data = $data;
        $this->totales = $totales;

        $this->miEmpresa = $this->Info();

        $this->nodosConceptos = $nodosConceptos;

        $this->xml = new DOMdocument("1.0","UTF-8");

        $this->formatDate();
        $this->getTipoComprobante();

        $this->buildNodoRoot();

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
            $rootData["FormaPago"] = $this->Util()->CadenaOriginalVariableFormat($this->data["formaDePago"],false,false);
        }

        $rootData["NoCertificado"] = $this->Util()->CadenaOriginalVariableFormat($this->data["serie"]["noCertificado"],false,false);

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

        $decimals = 2;
        if($this->data["tiposDeMoneda"] == "MXN") {
            $decimals = 0;
        }


        //TODO algo raro con el % de asignacion, no me preocupare de ello por ahora, checar si
        //puede aplicar cuando sea MXN
        if(!$this->isPago()){
            $rootData["TipoCambio"] =  $this->Util()->CadenaOriginalFormat($this->tipoDeCambio, $decimal,false);;
        }

        //Si el campo es del tipo T o P debe de ser 0
        $rootData["Total"] = $this->Util()->CadenaOriginalVariableFormat($this->totales["total"], true,false);
        if($this->isPago() || $this->isTraspaso()){
            $rootData["Total"] = 0;
        }

        $rootData["TipoDeComprobante"] = $this->tipoComprobante;

        //TODO viene de catalogo metodo de pago
        //Revisar tipo de pago PPD, es posible que no lo soportemos por ahora.
        $rootData["MetodoPago"] = $this->Util()->CadenaOriginalVariableFormat($this->data["metodoDePago"],false,false);

        $rootData["LugarExpedicion"] = $this->Util()->CadenaOriginalVariableFormat($this->data["nodoEmisor"]["rfc"]["cp"],false,false);

        //TODO confirmacion, pendiente por ahora, posiblemente no se soporte
        //$rootData["Confirmacion"] = $this->Util()->CadenaOriginalVariableFormat($this->data["NumCtaPago"],false,false);

        //TODO No debe existir el nodo impuestos si el tipo es T, P o N

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
            "Rfc"=>$this->Util()->CadenaOriginalVariableFormat($this->data["nodoReceptor"]["rfc"],false,false),
            "Nombre"=>$this->Util()->CadenaOriginalVariableFormat($this->data["nodoReceptor"]["nombre"],false,false),
            //TODO Residencia fiscal, viene del catalogo c_Pais, obligatorio para rfcs extranjeros
            //NumRegIdTrib, obligatorio con complemento de comercio exterior (no se agregara ya que no lo soportamos)
            //solo para extranjeros
            "UsoCFDI"=>$this->Util()->CadenaOriginalVariableFormat($this->data["usoCfdi"],false,false)
        );

        $this->CargaAtt($this->receptor, $receptorData);
    }

    private function formatDate() {
        //$this->data["fecha"] = "2017-05-20T10:45:09";
        $this->data["fecha"] = explode(" ", $this->data["fecha"]);
        $this->data["fecha"] = $this->data["fecha"][0]."T".$this->data["fecha"][1];
    }

    private function buildNodoConceptos() {
        $conceptos = $this->xml->createElement("cfdi:Conceptos");
        $conceptos = $this->root->appendChild($conceptos);
        //TODO para complemento de pagos se debe capturar 84111506
        //para P no debe existir el NoIdentificacion, en unidad debe ser ACT, descripcion debe ser pago, unitario
        //importe deben de ser 0, descuento no debe existir
        foreach($this->nodosConceptos as $concepto)
        {
            $myConcepto = $this->xml->createElement("cfdi:Concepto");

            if($this->data["fromNomina"])
            {
                $cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false,false,false,true);
                $concepto["unidad"] = "ACT";
                $concepto["descripcion"] = "Pago de nómina";
                $concepto["valorUnitario"] = $this->totales["subtotal"];
                $concepto["importe"] = $this->totales["subtotal"];
            }
            else
            {
                $cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],true,false);
            }

            $myConcepto = $conceptos->appendChild($myConcepto);
            $this->CargaAtt($myConcepto, array(
                    "ClaveProdServ"=>$this->Util()->CadenaOriginalVariableFormat($concepto["claveProdServ"],false,false),
                    "NoIdentificacion"=>$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false),
                    "Cantidad"=>$cantidad,
                    "ClaveUnidad"=>$this->Util()->CadenaOriginalVariableFormat($concepto["claveUnidad"],false,false),
                    "Unidad"=>$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
                    "Descripcion"=>$this->Util()->CadenaOriginalVariableFormat($concepto["descripcion"],false,false),
                    "ValorUnitario"=>$this->Util()->CadenaOriginalVariableFormat($concepto["valorUnitario"],true,false),
                    "Importe"=>$this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true,false),
                    //TODO Decuento
                )
            );

            //print_r($this->totales);
            //print_r($concepto);

            if(!$this->isPago()) {

                //Si alguno de los impuestos o retenciones existe, este nodo debe existir sino no
                if($this->totales["iva"] + $this->totales["ieps"] + $this->totales["retIva"] + $this->totales["retIsr"]  > 0) {
                    $impuestosConcepto = $this->xml->createElement("cfdi:Impuestos");
                    $impuestosConcepto = $myConcepto->appendChild($impuestosConcepto);
                }

                //Si alguno de los impuestos existe el siguiente nodo debe de existir
                if($concepto["tasaIva"] > 0 || $concepto["porcentajeIeps"] > 0) {
                    $trasladosConcepto = $this->xml->createElement("cfdi:Traslados");
                    $trasladosConcepto = $impuestosConcepto->appendChild($trasladosConcepto);

                    //si esta exento de iva no debemos de agregar el nodo
                    if($concepto["tasaIva"] > 0) {
                        $trasladoConcepto = $this->xml->createElement("cfdi:Traslado");
                        $trasladoConcepto = $trasladosConcepto->appendChild($trasladoConcepto);

                        $tasa = $concepto["tasaIva"] / 100;
                        $importe = $concepto["importe"] * $tasa;

                        $this->CargaAtt($trasladoConcepto, array(
                                "Base" => $this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true,false),
                                "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("002",false,false),
                                "TipoFactor" => $this->Util()->CadenaOriginalVariableFormat("Tasa",false,false),
                                "TasaOCuota" => $this->Util()->CadenaOriginalFormat($tasa,6,false),
                                "Importe" => $this->Util()->CadenaOriginalVariableFormat($importe,true,false)
                            )
                        );

                        //construye nodo impuestos globales
                        $this->trasladosGlobales['002'][(string)$tasa] += $importe;
                    }

                    if($concepto["porcentajeIeps"] > 0) {
                        $trasladoConcepto = $this->xml->createElement("cfdi:Traslado");
                        $trasladoConcepto = $trasladosConcepto->appendChild($trasladoConcepto);

                        $tasaIeps = $concepto["porcentajeIeps"] / 100;
                        $importeIeps = $concepto["importe"] * $tasaIeps;

                        $this->CargaAtt($trasladoConcepto, array(
                                "Base" => $this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true,false),
                                "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("003",false,false),
                                "TipoFactor" => $this->Util()->CadenaOriginalVariableFormat("Tasa",false,false),
                                "TasaOCuota" => $this->Util()->CadenaOriginalFormat($tasaIeps,6,false),
                                "Importe" => $this->Util()->CadenaOriginalVariableFormat($importeIeps,true,false)
                            )
                        );

                        //construye nodo impuestos globales
                        $this->trasladosGlobales['003'][(string)$tasaIeps] += $importeIeps;
                    }

                    //TODO ish (aunque creo que ese es impuesto local y va en el complemento
                }

                if($this->totales["retIva"] + $this->totales["retIsr"] > 0) {

                    $retencionesConcepto = $this->xml->createElement("cfdi:Retenciones");
                    $retencionesConcepto = $impuestosConcepto->appendChild($retencionesConcepto);

                    if($this->totales["retIva"] > 0 && $concepto["tasaIva"] > 0) {
                        $retencionConcepto = $this->xml->createElement("cfdi:Retencion");
                        $retencionConcepto = $retencionesConcepto->appendChild($retencionConcepto);

                        $tasa = $this->totales["porcentajeRetIva"] / 100;
                        $importe = $concepto["importe"] * $tasa;

                        $this->CargaAtt($retencionConcepto, array(
                                "Base" => $this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true,false),
                                "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("002",false,false),
                                "TipoFactor" => $this->Util()->CadenaOriginalVariableFormat("Tasa",false,false),
                                "TasaOCuota" => $this->Util()->CadenaOriginalFormat($tasa,6,false),
                                "Importe" => $this->Util()->CadenaOriginalVariableFormat($importe,true,false)
                            )
                        );
                    }

                    if($this->totales["retIsr"] > 0) {
                        $retencionConcepto = $this->xml->createElement("cfdi:Retencion");
                        $retencionConcepto = $retencionesConcepto->appendChild($retencionConcepto);

                        $tasa = $this->totales["porcentajeRetIsr"] / 100;
                        $importe = $concepto["importe"] * $tasa;

                        $this->CargaAtt($retencionConcepto, array(
                                "Base" => $this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true,false),
                                "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("001",false,false),
                                "TipoFactor" => $this->Util()->CadenaOriginalVariableFormat("Tasa",false,false),
                                "TasaOCuota" => $this->Util()->CadenaOriginalFormat($tasa,6,false),
                                "Importe" => $this->Util()->CadenaOriginalVariableFormat($importe,true,false)
                            )
                        );
                    }
                }
            }
            //TODO hacer pruebas con conceptos exentos
            //TODO ahora cada concepto lleva Nodo Impuestos, Retenciones y Traslados

            //TODO informacion aduanera
            if(strlen($concepto["cuentaPredial"]) > 0)
            {
                $cuentaPredial = $this->xml->createElement("cfdi:CuentaPredial");
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
        $impuestos = $this->xml->createElement("cfdi:Impuestos");
        $impuestos = $this->root->appendChild($impuestos);

        if(!$this->data["fromNomina"])
        {
            $this->CargaAtt($impuestos, array(
                "TotalImpuestosRetenidos" => $this->Util()->CadenaOriginalVariableFormat($this->totales["retIsr"]+$this->totales["retIva"],true,false),
                "TotalImpuestosTrasladados" => $this->Util()->CadenaOriginalVariableFormat($this->totales["iva"]+$this->totales["ieps"],true,false))
            );

            if($this->totales["retIva"] + $this->totales["retIsr"] > 0) {

                $retenciones = $this->xml->createElement("cfdi:Retenciones");
                $retenciones = $impuestos->appendChild($retenciones);

                if($this->totales["retIva"] > 0) {
                    $retencion = $this->xml->createElement("cfdi:Retencion");
                    $retencion = $retenciones->appendChild($retencion);

                    $this->CargaAtt($retencion, array(
                            "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("002",false,false),
                            "Importe" => $this->Util()->CadenaOriginalVariableFormat($this->totales["retIva"],true,false)
                        )
                    );
                }

                if($this->totales["retIsr"] > 0) {
                    $retencion = $this->xml->createElement("cfdi:Retencion");
                    $retencion = $retenciones->appendChild($retencion);

                    $this->CargaAtt($retencion, array(
                        "Impuesto" => $this->Util()->CadenaOriginalVariableFormat("001",false,false),
                        "Importe" => $this->Util()->CadenaOriginalVariableFormat($this->totales["retIsr"],true,false))
                    );
                }
            }

            if(count($this->trasladosGlobales) > 0) {
                $traslados = $this->xml->createElement("cfdi:Traslados");
                $traslados = $impuestos->appendChild($traslados);
            }

            foreach($this->trasladosGlobales as $keyImpuesto => $impuesto ) {
                foreach($impuesto as $keyTasa => $importe) {
                    $traslado = $this->xml->createElement("cfdi:Traslado");
                    $traslado = $traslados->appendChild($traslado);

                    $this->CargaAtt($traslado, array(
                            "Impuesto" => $this->Util()->CadenaOriginalVariableFormat($keyImpuesto,false,false),
                            "TipoFactor" => $this->Util()->CadenaOriginalVariableFormat("Tasa",false,false),
                            "TasaOCuota" => $this->Util()->CadenaOriginalFormat($keyTasa,6,false),
                            "Importe" => $this->Util()->CadenaOriginalVariableFormat($importe,true,false)
                        )
                    );
                }
            }
        }
    }

    private function buildNodoComplementos() {
        //TODO Para tipo N, P, o T no debe existir
        $complementos = $this->xml->createElement("cfdi:Complemento");
        $complementos = $this->root->appendChild($complementos);

        if($this->data["fromNomina"])
        {
            include_once(DOC_ROOT."/classes/complemento_nomina_12_xml.php");
            $this->xsdNomina = "http://www.sat.gob.mx/nomina http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd";
        }

        if($this->miEmpresa["donatarias"] == "Si")
        {
            include_once(DOC_ROOT."/addComplementos/complemento_donataria_xml.php");
            $this->xsdDonataria = "http://www.sat.gob.mx/donat http://www.sat.gob.mx/sitio_internet/cfd/donat/donat11.xsd";
        }

        if($this->totales['porcentajeISH'] > 0){
            include_once(DOC_ROOT."/addImpuestos/complemento_ish_xml.php");
            $this->xsdImplocal = "http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd";
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
        $nufa = $this->miEmpresa["empresaId"]."_".$this->data["serie"]["serie"]."_".$this->data["folio"];

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

        return $this->xml->save($root.$nufa.".xml");
    }
}
?>
