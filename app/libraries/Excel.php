<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 *  ============================================================================== 
 *  Author	: Mian Saleem
 *  Email	: saleem@tecdiary.com 
 *  For		: PHPExcel
 *  Web		: https://github.com/PHPOffice/PHPExcels
 *  License	: LGPL (GNU LESSER GENERAL PUBLIC LICENSE)
 *		: https://github.com/PHPOffice/PHPExcel/blob/master/license.md
 *  ============================================================================== 
 */
require_once APPPATH . "/third_party/PHPExcel/PHPExcel.php";

class Excel extends PHPExcel
{
    public function __construct()
    {
        parent::__construct();
    }
}

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// class Excel
// {
//     public $spreadsheet;
//     public $writer;

//     public function __construct()
//     {
//         // Load Composer autoload
//         require FCPATH.'vendor/autoload.php';

//         $this->spreadsheet = new Spreadsheet();
//         $this->writer      = new Xlsx($this->spreadsheet);
//     }

//     public function getSpreadsheet()
//     {
//         return $this->spreadsheet;
//     }

//     public function download($filename = 'report.xlsx')
//     {
//         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//         header("Content-Disposition: attachment;filename=\"{$filename}\"");
//         header('Cache-Control: max-age=0');

//         $this->writer->save('php://output');
//         exit;
//     }
// }