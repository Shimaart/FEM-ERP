<?php

namespace App\Office\Documents;

use App\Models\Order;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PaymentWaybillDocument
{
    protected $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function getDocument()
    {
        $order = $this->order;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

//STYLES
        $fontStyleName = 'rStyle';
        $phpWord->addFontStyle($fontStyleName, array('name' => 'Times New Roman','size' => 12));
        $sectionStyle = array(
            'orientation' => 'portrait',
            'marginTop' => 2000,
        );

        $top_table_font_styles = array('size' => 10, 'name' => 'Times New Roman');
        $fontStyleName = 'rStyle';
        $phpWord->addFontStyle($fontStyleName, array('name' => 'Times New Roman','size' => 12));

        $cellHRight = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT,  'spaceBefore'=>0, 'spaceAfter'=>0);
        $bold_styles = array('size' => 12, 'bold' => true, 'name' => 'Times New Roman');

        $main_pargraph_styles = array('spaceBefore'=>0, 'spaceAfter'=>0);
//        $main_pargraph_with_indent_30_styles = array('indentation' => array('firstLine' => 300), 'spaceBefore'=>0, 'spaceAfter'=>0,'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::JUSTIFY);
        $main_pargraph_with_indent_30_styles = array('indentation' => array('firstLine' => 300),'spaceBefore'=>0, 'spaceAfter'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
        $main_pargraph_with_indent_60_styles = array('indentation' => array('firstLine' => 600),'spaceBefore'=>0, 'spaceAfter'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
        $main_pargraph_right_styles = array('spaceBefore'=>0, 'spaceAfter'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
        $main_pargraph_center_styles = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore'=>0, 'spaceAfter'=>0);
//STYLES

//

//HEADER
        $section = $phpWord->addSection($sectionStyle);
        $subsequent = $section->addHeader();
        $table = $subsequent->addTable();
        $table->addRow();
        $table->addCell(14000)->addImage(public_path('static/logo-header.png'), array('width' => 300));
//HEADER


        return $phpWord;
    }
}
