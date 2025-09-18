<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Mpdf;

class Pdf
{
    public $mpdf;

    public function __construct($params = [])
    {
        require_once FCPATH.'vendor/autoload.php';
        $this->mpdf = new Mpdf($params);
    }

    public function load($html, $filename = 'document.pdf', $output = 'I')
    {
        $this->mpdf->WriteHTML($html);
        return $this->mpdf->Output($filename, $output);
    }
}
