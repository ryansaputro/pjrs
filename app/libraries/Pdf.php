<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 *  ============================================================================== 
 *  Author	: Mian Saleem
 *  Email	: saleem@tecdiary.com 
 *  For		: PHPExcel
 *  Web		: https://mpdf1.com
 *  License	: GPL
 *		: http://www.opensource.org/licenses/gpl-license.php
 *  ============================================================================== 
 */
require_once APPPATH . "/third_party/mpdf-8.1.0/vendor/autoload.php";

class Pdf extends mPDF
{
    public function __construct()
    {
        parent::__construct();
    }
}
// load autoload dari mPDF

