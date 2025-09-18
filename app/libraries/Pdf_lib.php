<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_lib {
   protected $mpdf;

    public function __construct($params = [])
    {
        // load composer autoload
        require_once FCPATH . '/vendor/autoload.php';

        $this->mpdf = new \Mpdf\Mpdf($params);
    }

    public function load()
    {
        return $this->mpdf;
    }
}

