<?php defined('BASEPATH') OR exit('No direct script access allowed');


function pdf_creator($html, $filename='' , $stream = true)
{
	require_once('dompdf/dompdf_config.inc.php');

	$dompdf = new DOMPDF();
	$dompdf->set_paper("A5", 'landscape');
	$dompdf->load_html($html);
	$dompdf->render();
	if($stream)
	{
		$dompdf->stream($filename.'.pdf');
	} else {
		return $dompdf->output();
	}
	
}
