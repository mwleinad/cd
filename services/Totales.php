<?php

class Totales extends Comprobante
{
    public function calculate($data) {
        if(!$_SESSION["conceptos"])
        {
            return false;
        }

        $data["subtotal"] = 0;
        $data["descuento"] = 0;
        $data["iva"] = 0;
        $data["ieps"] = 0;
        $data["ish"] = 0;
        $data["retIva"] = 0;
        $data["retIsr"] = 0;
        $data["total"] = 0;

        foreach($data as $key => $value)
        {
            $data[$key] = $this->Util()->RoundNumber($data[$key]);
        }

        foreach($_SESSION["conceptos"] as $key => $concepto)
        {
            $data["ish"] += $concepto["totalIsh"];
        }

        $countConceptos = 0;
        foreach($_SESSION["conceptos"] as $key => $concepto)
        {
            $countConceptos++;
            $totalImpuesto = 0;
            //al primer concepti correrle los impuestos extra.
            if($_SESSION["impuestos"] && $countConceptos == 1)
            {
                $importe = $concepto["importe"];
                foreach($_SESSION["impuestos"] as $keyImpuesto => $impuesto)
                {
                    //impuesto extra, suma
                    if($_SESSION["impuestos"][$keyImpuesto]["importe"] != 0)
                    {
                        if($impuesto["tipo"] == "impuesto")
                        {
                            $concepto["importe"] = $concepto["importe"] + $_SESSION["impuestos"][$keyImpuesto]["importe"];
                            $totalImpuesto += $_SESSION["impuestos"][$keyImpuesto]["importe"];
                        }
                        elseif($impuesto["tipo"] == "retencion")
                        {
                            $concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
                            $totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
                        }
                        elseif($impuesto["tipo"] == "deduccion")
                        {
                            $concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
                            $totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
                        }
                        elseif($impuesto["tipo"] == "amortizacion")
                        {
                            $concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
                            $totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
                        }

                        continue;
                    }

                    if($impuesto["tipo"] == "impuesto")
                    {
                        $concepto["importe"] = $concepto["importe"] + ($importe * ($impuesto["tasa"] / 100));
                        $_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
                    }
                    elseif($impuesto["tipo"] == "retencion")
                    {
                        $concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
                        $_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
                    }
                    elseif($impuesto["tipo"] == "deduccion")
                    {
                        $concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
                        $_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
                    }
                }//foreach
            }//impuestos

            $data["subtotal"] = $this->Util()->RoundNumber($data["subtotal"] + $concepto["importe"]);
            if($concepto["excentoIva"] == "si")
            {
                $_SESSION["conceptos"][$key]["tasaIva"] = 0;
            }
            else
            {
                $_SESSION["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
            }

            //porcentaje de descuento
            if($data["porcentajeDescuento"])
            {
                $data["porcentajeDescuento"];
            }

            $data["descuentoThis"] = $this->Util()->RoundNumber($_SESSION["conceptos"][$key]["importe"] * ($data["porcentajeDescuento"] / 100));
            $data["descuento"] += $data["descuentoThis"];

            $afterDescuento = $_SESSION["conceptos"][$key]["importe"] - $data["descuentoThis"];
            if($concepto["excentoIva"] == "si")
            {
                $_SESSION["conceptos"][$key]["tasaIva"] = 0;
            }
            else
            {
                $_SESSION["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
            }

            $data["ivaThis"] = $this->Util()->RoundNumber($afterDescuento * ($_SESSION["conceptos"][$key]["tasaIva"] / 100));
            $data["iva"] += $data["ivaThis"];

            $data["valorUnitario"] = $concepto["valorUnitario"];
            $concepto["importe"] = $importe;

            //para retencion de iva'
            if($concepto["excentoIva"] == "no")
            {
                $paraRetencionIva += $_SESSION["conceptos"][$key]["importe"] - $data["descuentoThis"];
            }

            $data["ieps"] += $this->Util()->RoundNumber($_SESSION["conceptos"][$key]["totalIeps"]);
        }
        $afterDescuento = $data["subtotal"] - $data["descuento"];

        //ieps de descuento
        if(!$data["porcentajeIEPS"])
        {
            $data["porcentajeIEPS"] = 0;
        }

        //si la factura tiene descuento, descontar al ieps
        if($data["porcentajeDescuento"] > 0)
        {
            $data["ish"] = $this->Util()->RoundNumber($data["ish"] - ($data["ish"] * ($data["porcentajeDescuento"] / 100)));
        }
        else
        {
            $data["ieps"] = $this->Util()->RoundNumber($data["ieps"]);
        }

        if($data["porcentajeIEPS"] == 0 && $data["ieps"] > 0)
        {
            $data["porcentajeIEPS"] = 1;
        }

        //ish de descuento
        if($data["ish"] > 0)
        {
            $data["porcentajeISH"] = TASA_ISH;
        }
        //$data["ish"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeISH"] / 100));
        $afterImpuestos = $afterDescuento + $data["iva"] + $data["ieps"] + $data["ish"];
        if($_SESSION["empresaId"] == "416")
        {
            $data["retIva"] = $this->Util()->RoundNumber(($afterDescuento - $totalImpuesto) * ($data["porcentajeRetIva"] / 100));
            //$data["retIva"] = $this->Util()->RoundNumber(($paraRetencionIva) * ($data["porcentajeRetIva"] / 100));
        }
        else
        {
            //$data["retIva"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeRetIva"] / 100));
            $data["retIva"] = $this->Util()->RoundNumber(($paraRetencionIva) * ($data["porcentajeRetIva"] / 100));
        }

        $data["retIsr"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeRetIsr"] / 100));
        $data["total"] = $this->Util()->RoundNumber($data["subtotal"] - $data["descuento"] + $data["iva"] + $data["ieps"] + $data["ish"] - $data["retIva"] - $data["retIsr"]);

        return $data;
    }

}


?>