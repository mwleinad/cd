<?php
use Dompdf\Dompdf;

class PdfService extends Producto{
    private $domPdf;
    private $smarty;

    public function __construct()
    {
        //$this->domPdf = new Dompdf();
        $this->smarty = new Smarty;
        $this->cfdiUtil = new CfdiUtil();
        $this->comprobantePago = new ComprobantePago();
        $this->qrService = new QrService();
    }

    public function generate($empresaId, $fileName, $type = 'download') {

        $xmlReaderService = new XmlReaderService;

        $rfcActivo = $this->getRfcActive();

        $xmlPath = DOC_ROOT.'/empresas/'.$empresaId.'/certificados/'.$rfcActivo.'/facturas/xml/'.$fileName.".xml";
        $xmlData = $xmlReaderService->execute($xmlPath);

        $this->smarty->assign('xmlData', $xmlData);

        $dompdf = new Dompdf();

        $qrFile = $this->qrService->generate($xmlData);
        $this->smarty->assign('qrFile', $qrFile);

        //Uncomment if you want to see a html version
        //$this->smarty->display(DOC_ROOT.'/templates/pdf/basico.tpl');exit;

        $html = $this->smarty->fetch(DOC_ROOT.'/templates/pdf/basico.tpl');

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        if($type == 'download') {
            $dompdf->stream($fileName.'pdf');
        } else if($type == 'view') {
            $dompdf->stream($fileName.'pdf', array("Attachment" => false));
        } else {
            return $dompdf->output();
        }

        exit(0);
    }
}
?>
