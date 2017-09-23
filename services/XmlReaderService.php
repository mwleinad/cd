<?php

class XmlReaderService extends Comprobante
{
    function execute($pathXml, $empresaId)
    {
        $xml = simplexml_load_file($pathXml);
        $ns = $xml->getNamespaces(true);
        $xml->registerXPathNamespace('c',$ns['cfdi']);
        $xml->registerXPathNamespace('t',$ns['tfd']);
        $xml->registerXPathNamespace('pago10',$ns['pago10']);
        $xml->registerXPathNamespace('impLocal',$ns['implocal']);

        //cfdi
        $data["cfdi"] = $xml->xpath('//cfdi:Comprobante')[0];

        //Obtenemos la informacion del Comprobante, esto es solo para saber si esta cancelado. Lo demas se obtiene del xml
        $sql = 'SELECT * FROM comprobante
				WHERE serie = "'.$data["cfdi"]['Serie'].'" AND folio = "'. $data["cfdi"]['Folio'].'"';
        $this->Util()->DBSelect($empresaId)->setQuery($sql);
        $data["db"] = $this->Util()->DBSelect($empresaId)->GetRow();

        $sql = 'SELECT * FROM serie
				WHERE serie = "'.$data["cfdi"]['Serie'].'"';
        $this->Util()->DBSelect($empresaId)->setQuery($sql);
        $data["serie"] = $this->Util()->DBSelect($empresaId)->GetRow();

        //Emisor
        $data["emisor"] = $xml->xpath('//cfdi:Emisor')[0];
        $data["receptor"] = $xml->xpath('//cfdi:Receptor')[0];

        //Conceptos
        //El punto hace que sea relativo al elemento, y solo una / es para buscar exactamente eso
        foreach($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $con){
            $concepto["concepto"] = $con;
            $concepto["traslados"] = $con->xpath('./cfdi:Impuestos/cfdi:Traslados/cfdi:Traslado');
            $concepto["retenciones"] = $con->xpath('./cfdi:Impuestos/cfdi:Retenciones/cfdi:Retencion');
            $concepto["cuentaPredial"] = $con->xpath('./cfdi:CuentaPredial')[0];

            $data["conceptos"][] = $concepto;
        }

        //Impuestos
        if(isset($xml->xpath('/cfdi:Comprobante/cfdi:Impuestos')[0])){
            //El punto hace que sea relativo al elemento
            $impuesto["impuestos"] = $xml->xpath('/cfdi:Comprobante/cfdi:Impuestos')[0];
            $impuesto["traslados"] = $impuesto["impuestos"]->xpath('./cfdi:Traslados/cfdi:Traslado');
            $impuesto["retenciones"] = $impuesto["impuestos"]->xpath('.//cfdi:Retenciones/cfdi:Retencion');

            $data["impuestos"] = $impuesto;
        }

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
        //Complementos ImpuestosLocales
        $impuestos = $xml->xpath('//impLocal:ImpuestosLocales');

        if(isset($impuestos[0])){
            $data['impuestosLocales']['totales'] = $impuestos[0];

            $trasladosLocales = $impuestos[0]->xpath('//implocal:TrasladosLocales');

            foreach($trasladosLocales as $con){
                if($con['ImpLocTrasladado'] == 'ISH') {
                    $data['impuestosLocales']['ish'] = $con;
                } else {
                    $data['impuestosLocales']['traslados'] = $con;
                }
            }
        }

        $pagos = $xml->xpath('//pago10:Pagos');

        if(isset($pagos[0])){
            $pagos = $pagos[0]->xpath('//pago10:Pago');

            foreach($pagos as $pago){
                $card['data'] = $pagos[0];
                $card['pago'] = $pago[0];
                $card['doctoRelacionado'] =  $pago[0]->xpath('//pago10:DoctoRelacionado ')[0];

                $data["pagos"][] = $card;
            }
        }

        return $data;
    }
}



?>