<?php

class CfdiUtil extends Comprobante
{
    public function getUUID($serie, $folio) {
        $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM comprobante
        WHERE serie = '".$serie."'
        AND folio = '".$folio."'");

        $cfdiRelacionado = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();

        if(!$cfdiRelacionado) {
            return null;
        }

        $timbre = unserialize($cfdiRelacionado["timbreFiscal"]);
        return $timbre["UUID"];
    }

    public function getInfoComprobanteRelacionado($serie, $folio) {
        $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM comprobante
        WHERE serie = '".$serie."'
        AND folio = '".$folio."'");

        $cfdiRelacionado = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();

        if(!$cfdiRelacionado) {
            return null;
        }

        return $cfdiRelacionado;
    }

    public function cadenaOriginalTimbre($timbre){
        $cadenaOriginal = "||";
        $cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($timbre["Version"]);
        $cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($timbre["UUID"]);
        $cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($timbre["FechaTimbrado"]);
        $cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($timbre["SelloCFD"]);
        $cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($timbre["NoCertificadoSAT"]);
        $cadenaOriginal .= "|";

        $cadena = utf8_encode($cadenaOriginal);
        $data["original"] = $cadena;
        $data["sha1"] = sha1($cadena);
        return $data;
    }
}


?>