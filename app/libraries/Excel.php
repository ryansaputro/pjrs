<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
    protected $spreadsheet;
    protected $writer;

    public function __construct()
    {
        require FCPATH.'vendor/autoload.php';
        $this->spreadsheet = new Spreadsheet();
        $this->writer = new Xlsx($this->spreadsheet);
    }

    // ✅ Backward compatibility
    public function setActiveSheetIndex($index)
    {
        return $this->spreadsheet->setActiveSheetIndex($index);
    }

    public function getActiveSheet()
    {
        return $this->spreadsheet->getActiveSheet();
    }

    public function getDefaultStyle()
    {
        return $this->spreadsheet->getDefaultStyle();
    }

    public function getSpreadsheet()
    {
        return $this->spreadsheet;
    }

    public function download($filename = 'report.xlsx')
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $this->writer->save('php://output');
        exit;
    }
}
