<?php

class Cancelation extends Main {

    const REJECTED = 'Solicitud rechazada';
    const CANCELLED = 'Cancelado';
    const CANCELLED_NO_ACCEPTED= 'Cancelado sin aceptación';

    public function addPetition($orgId, $cfdiId, $taxPayerId, $rTaxPayerId, $uuid, $total, $cancelationMotive) {
        //TODO there might be a chance that the total has to come directly from the xml just in case
        $this->Util()->DB()->setQuery("
			INSERT INTO
				vin_cfdi_cancel
			(
				
				`org_id`,
				`cfdi_id`,
				`taxpayer_id`,
				`rtaxpayer_id`,
				`uuid`,
				`total`,
				`cancelation_motive`
				
		)
		VALUES
		(
				
				'".$orgId."',
				'".$cfdiId."',
				'".$taxPayerId."',
				'".$rTaxPayerId."',
				'".$uuid."',
				'".$total."',
				'".$cancelationMotive."'
			
		);");
        return $this->Util()->DB()->InsertData();
    }

    public function getStatus($orgId, $taxPayerId, $rTaxPayerId, $uuid, $total) {

        $url = $orgId === 15 ? "https://demo-facturacion.finkok.com/servicios/soap/cancel.wsdl" :
            "https://facturacion.finkok.com/servicios/soap/cancel.wsdl";

        $client = new SoapClient($url);

        $params = array(
            'username' => PAC_USER,
            'password' => PAC_PASS,
            "taxpayer_id" => $taxPayerId,
            "rtaxpayer_id" => $rTaxPayerId,
            "uuid" => $uuid,
            "total" => $total,
        );

        $response = $client->__soapCall("get_sat_status", array($params));
        return $response->get_sat_statusResult->sat;
    }

    public function processCancelation($cfdi, $response) {
        if($response->EstatusCancelacion === self::REJECTED) {
            $this->deleteCancelRequest($cfdi["solicitud_cancelacion_id"]);
        }

        if($response->Estado === self::CANCELLED || $response->Estado) {
            $date = date("Y-m-d");

            $sqlQuery = 'UPDATE comprobante SET motivoCancelacion = "'.$cfdi['cancelation_motive'].'", 
                status = "0", fechaPedimento = "'.$date.'" WHERE comprobanteId = '.$cfdi['cfdi_id'];
            $this->Util()->DBSelect($cfdi['org_id'])->setQuery($sqlQuery);
            $this->Util()->DBSelect($cfdi['org_id'])->UpdateData();
            $this->deleteCancelRequest($cfdi["solicitud_cancelacion_id"]);
        }
    }

    private function deleteCancelRequest($id) {
        $this->Util()->DB()->setQuery("
			DELETE FROM
				vin_cfdi_cancel
			WHERE
				solicitud_cancelacion_id = '".$id."'");
        $this->Util()->DB()->DeleteData();
    }
}


?>