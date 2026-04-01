<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {
    public function generate($html, $filename='', $paper = 'A4', $orientation = 'portrait') {
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Penting agar gambar/logo tampil
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        $dompdf->stream($filename . ".pdf", array("Attachment" => 0)); // 0 = preview, 1 = download
    }
}