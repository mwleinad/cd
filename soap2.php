<?php
/*
 *	$Id: wsdlclient1.php,v 1.3 2007/11/06 14:48:48 snichol Exp $
 *
 *	WSDL client sample.
 *
 *	Service: WSDL
 *	Payload: document/literal
 *	Transport: http
 *	Authentication: none
 */
date_default_timezone_set('America/Los_Angeles');
require_once('libs/nusoap.php'); 
$wsdl="http://www.snowboard-info.com/EndorsementSearch.wsdl";
$client=new soapclient($wsdl, 'wsdl');
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$param=array(
'country1'=>'usa',
'country2'=>'canada'
); 
echo $client->call('getRate', $param);
?>