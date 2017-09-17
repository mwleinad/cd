<?php

class XmlReaderService extends Comprobante
{
    function execute($pathXml)
    {
        $xml = simplexml_load_file($pathXml);
        $ns = $xml->getNamespaces(true);
        $xml->registerXPathNamespace('c',$ns['cfdi']);
        $xml->registerXPathNamespace('t',$ns['tfd']);

        //cfdi
        $data["cfdi"] = $xml->xpath('//cfdi:Comprobante')[0];

        //Obtenemos la informacion del Comprobante, esto es solo para saber si esta cancelado. Lo demas se obtiene del xml
        $sql = 'SELECT * FROM comprobante
				WHERE serie = "'.$data["cfdi:Comprobante"]['Serie'].'" AND folio = "'. $data["cfdi:Comprobante"]['Folio'].'"';
        $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
        $data["db"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();

        //Emisor
        $data["emisor"] = $xml->xpath('//cfdi:Emisor')[0];
        $data["receptor"] = $xml->xpath('//cfdi:Receptor')[0];

        //Conceptos
        //El punto hace que sea relativo al elemento, y solo una / es para buscar exactamente eso
        foreach($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $con){
            $concepto["concepto"] = $con;
            $concepto["traslados"] = $con->xpath('./cfdi:Impuestos/cfdi:Traslados/cfdi:Traslado');
            $concepto["retenciones"] = $con->xpath('./cfdi:Impuestos/cfdi:Retenciones/cfdi:Retencion');

            $data["conceptos"][] = $concepto;
        }

        //Impuestos
        //El punto hace que sea relativo al elemento
        $impuesto["impuestos"] = $xml->xpath('/cfdi:Comprobante/cfdi:Impuestos')[0];
        $impuesto["traslados"] = $impuesto["impuestos"]->xpath('./cfdi:Traslados/cfdi:Traslado');
        $impuesto["retenciones"] = $impuesto["impuestos"]->xpath('.//cfdi:Retenciones/cfdi:Retencion');

        $data["impuestos"] = $impuesto;

        //Timbre fiscal
        foreach($xml->xpath('//t:TimbreFiscalDigital') as $con){
            $data['timbreFiscal'] = $con;
        }

        $cfdiUtil = new CfdiUtil();
        $data["timbre"] = $cfdiUtil->cadenaOriginalTimbre($data['timbreFiscal']);

        //Importe en letra
        $temp = new CNumeroaLetra ();
        $temp->setMayusculas(1);
        $temp->setGenero(1);
        $temp->setMoneda($data['cfdi']["Moneda"]);
        $temp->setDinero(1);
        $temp->setPrefijo('');
        $temp->setSufijo('');
        $temp->setNumero($data['cfdi']["Total"]);
        $data["letra"] = $temp->letra();

        //TODO complementos y addendas

        return $data;
    }
}



?>