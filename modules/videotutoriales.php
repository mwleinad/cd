<?php
$lista_videos = array( 	array('nombrevid'=>'Comprobantes Fiscales Digitales', 'fuentevid'=>'../videos/VidCompFiscDig.flv'),
						array('nombrevid'=>'Emision y recepcion de CFD', 'fuentevid'=>'../videos/VidEmicRecpCFD.flv'),
                        array('nombrevid'=>'Solicitud de Folios de CFD', 'fuentevid'=>'../videos/VidSolFoliosCFD.flv'),
                        array('nombrevid'=>'Firma Electronica Avanzada', 'fuentevid'=>'../videos/VidFirmElecAvz.flv'),
                        array('nombrevid'=>'Tramite de Firma Electronica', 'fuentevid'=>'../videos/VidTramiteFIEL.flv'),
                        array('nombrevid'=>'Renovacion de Firma Electronica', 'fuentevid'=>'../videos/VidRenovaFIEL.flv')
                      );
$smarty->assign('videos', $lista_videos);
?>