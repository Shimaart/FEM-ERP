<?php

namespace App\Office\Documents;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Database\Eloquent\Builder;

class OrderContractDocument
{
    protected $parameters;
    protected $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct($parameters, Order $order)
    {
        $this->parameters = $parameters;
        $this->order = $order;
    }


    public function getDocument()
    {
        $parameters = $this->parameters;
        $order = $this->order;
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

//STYLES
        $fontStyleName = 'rStyle';
        $phpWord->addFontStyle($fontStyleName, array('name' => 'Times New Roman','size' => 12));
        $sectionStyle = array(
            'orientation' => 'portrait',
            'marginTop' => 2000,
            'marginLeft' => 900,
            'marginRight' => 900,
        );

        $sectionStyle = array(
            'orientation' => 'portrait',
            'marginTop' => 500,
            'marginLeft' => 500,
            'marginRight' => 500,
            'marginBottom' => 500,
        );

        $fontStyleName = 'rStyle';
        $phpWord->addFontStyle($fontStyleName, array('name' => 'Cambria','size' => 12));
        $sectionStyle = array(
            'orientation' => 'portrait',
            'marginTop' => 500,
            'marginLeft' => 500,
            'marginRight' => 500,
            'marginBottom' => 500,
        );

// Create a new table style
        $table_style_another = new \PhpOffice\PhpWord\Style\Table;
        $table_style_another->setBorderColor('000');
        $table_style_another->setBorderSize(6);
        $table_style_another->setUnit(\PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT);
        $table_style_another->setWidth(100 * 50);
//$table_style_another->setBgColor('424e56');
//$table_style_another->setBgColor('000');
        $table_style_another->setBgColor('000');
        $table_style_another->setCellMargin(50);
//$table_style_another->setCellMargin(200);
//cellMargin



// Create a new table style
        $table_style_another_no_bg = new \PhpOffice\PhpWord\Style\Table;
        $table_style_another_no_bg->setBorderColor('fff');
        $table_style_another_no_bg->setBorderSize(null);
        $table_style_another_no_bg->setUnit(\PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT);
        $table_style_another_no_bg->setWidth(100 * 50);
//$table_style_another_no_bg->setBgColor('424e56');
//$table_style_another_no_bg->setBgColor('000');
//$table_style_another_no_bg->setBgColor('000');
        $table_style_another_no_bg->setCellMargin(50);
//$table_style_another_no_bg->setCellMargin(200);
//cellMargin






//        $cellHRight = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END,  'spaceBefore'=>0, 'spaceAfter'=>0);
        $cellHRight = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT,  'spaceBefore'=>0, 'spaceAfter'=>0);
        $cellHCenter = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'valign' => 'center',  'spaceBefore'=>0, 'spaceAfter'=>0);
        $main_pargraph_styles = array('spaceBefore'=>0, 'spaceAfter'=>0);
//        $main_pargraph_with_indent_30_styles = array('indentation' => array('firstLine' => 300), 'spaceBefore'=>0, 'spaceAfter'=>0,'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::JUSTIFY);
        $main_pargraph_with_indent_30_styles = array('indentation' => array('firstLine' => 300),'spaceBefore'=>0, 'spaceAfter'=>0, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH);
        $main_pargraph_center_styles = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore'=>0, 'spaceAfter'=>0);
        $main_heading_font_styles = array('color' => '1D345D', 'size' => 18, 'name' => 'Cambria');
        $main_heading_font_styles_bold = array('size' => 18, 'bold' => true, 'name' => 'Cambria');
        $top_heading_font_styles = array('size' => 16, 'bold' => true, 'name' => 'Cambria');


        $footer_font_styles = array('size' => 8, 'name' => 'Cambria');


        $top_table_font_styles = array('size' => 10, 'name' => 'Cambria');

        $structure_heading_font_styles = array('size' => 12, 'bold' => true, 'name' => 'Cambria');


        $bold_styles = array('size' => 12, 'bold' => true, 'name' => 'Cambria');
        $bold_styles_small = array('size' => 8,  'name' => 'Cambria');
        $bold_styles_small_9 = array('size' => 9,  'name' => 'Cambria');
        $bold_styles_small_10 = array('size' => 10,  'name' => 'Cambria');
        $bold_styles_small_bold = array('size' => 10, 'bold' => true, 'name' => 'Cambria');
        $bold_styles_small_italic = array('size' => 8, 'italic' => true, 'name' => 'Cambria');
        $bold_styles_small_bold_italic = array('size' => 8,   'bold' => true, 'italic' => true, 'name' => 'Cambria');
        $bold_styles_small_bold_italic_10 = array('size' => 12,    'italic' => true, 'underline' => 'single', 'name' => 'Cambria');
        $table_styles_small = array('size' => 8, 'name' => 'Cambria');




        $table_style_images = new \PhpOffice\PhpWord\Style\Table;
//$table_style_images->setBorderColor('000');
//$table_style_images->setBorderSize(6);
        $table_style_images->setUnit(\PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT);
        $table_style_images->setWidth(100 * 50);
//$table_style_images->setBgColor('424e56');
//$table_style_images->setBgColor('000');


// Create a new table style
        $table_style_footer = new \PhpOffice\PhpWord\Style\Table;
        $table_style_footer->setUnit(\PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT);
        $table_style_footer->setWidth(100 * 50);

        $cellHRight_footer = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT, 'valign' => 'center',  'spaceBefore'=>0, 'spaceAfter'=>0);
        $cellHLeft_footer = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'valign' => 'center',  'spaceBefore'=>0, 'spaceAfter'=>0);
        $cellHCenter = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'valign' => 'center',  'spaceBefore'=>0, 'spaceAfter'=>0);
        $footer_table_font_styles = array('size' => 14, 'name' => 'Cambria');


        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999', 'width'=>100*50);
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);

//$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');

//STYLES

//

//HEADER
        $section = $phpWord->addSection($sectionStyle);
        $subsequent = $section->addHeader();
        $table = $subsequent->addTable();
        $table->addRow();
        $table->addCell(14000)->addImage(public_path('img/vast-header.png'), array('width' => 500));
//HEADER



        $table_chat = $section->addTable($table_style_another_no_bg);
        $table_chat->addRow();
        $cell = $table_chat->addCell(2000);
        $cell->addText('Постачальник', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(12000);
        $cell->addText('не є платником податку на прибуток на загальних умовах р/р', $bold_styles_small_10, $cellHLeft_footer);

        $customerName = $this->order->customer ? $this->order->customer->name : '-';
        $table_chat->addRow();
        $cell = $table_chat->addCell(2000);
        $cell->addText('Одержувач', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(12000);
        $cell->addText($customerName, $bold_styles_small_10, $cellHLeft_footer);

        $orderInfo = '№' . $this->order->id . ' + номер тел + адреса доставки';
        $table_chat->addRow();
        $cell = $table_chat->addCell(2000);
        $cell->addText('Договір', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(12000);
        $cell->addText($orderInfo, $bold_styles_small_10, $cellHLeft_footer);

        $section->addTextBreak();

        $ttnInfo = 'НАКЛАДНA № INV-0001';
        $section->addText($ttnInfo, $bold_styles_small_bold, $main_pargraph_center_styles);



        $table_chat = $section->addTable($table_style_another);
        $table_chat->addRow();
        $cell = $table_chat->addCell(1000);
        $cell->addText('№', $bold_styles_small_bold, $cellHCenter);
        $cell = $table_chat->addCell(5000);
        $cell->addText('Назва', $bold_styles_small_bold, $cellHCenter);
        $cell = $table_chat->addCell(2000);
        $cell->addText('Од.', $bold_styles_small_bold, $cellHCenter);
        $cell = $table_chat->addCell(2000);
        $cell->addText('Кіл-ть', $bold_styles_small_bold, $cellHCenter);
        $cell = $table_chat->addCell(2000);
        $cell->addText('Ціна', $bold_styles_small_bold, $cellHCenter);
        $cell = $table_chat->addCell(2000);
        $cell->addText('Сума', $bold_styles_small_bold, $cellHCenter);

        $i = 0;
        $orderItems = $order->orderItems()->whereHas('item',function (Builder $query) use ($parameters){
            $query->whereIn('category_id', $parameters['selectedCategories']);
        })
        ->get();
        foreach ($orderItems as $orderItem) {
            $i++;
            $table_chat->addRow();
            $cell = $table_chat->addCell(1000);
            $cell->addText($i, $bold_styles_small_10, $cellHCenter);
            $cell = $table_chat->addCell(5000);
            $cell->addText($orderItem->item->name, $bold_styles_small_10, $cellHCenter);

            $unitName = $orderItem->item->unit ? $orderItem->item->unit->symbol : '-';
            $cell = $table_chat->addCell(2000);
            $cell->addText($unitName, $bold_styles_small_10, $cellHCenter);
            $cell = $table_chat->addCell(2000);
            $cell->addText($orderItem->quantity, $bold_styles_small_10, $cellHCenter);
            $cell = $table_chat->addCell(2000);
            $cell->addText($orderItem->price, $bold_styles_small_10, $cellHCenter);

            $totalInfo = $orderItem->quantity * $orderItem->price;
            $cell = $table_chat->addCell(2000);
            $cell->addText($totalInfo, $bold_styles_small_10, $cellHCenter);
        }




        $section->addTextBreak();
        $table_chat = $section->addTable($table_style_another_no_bg);
        $table_chat->addRow();
        $cell = $table_chat->addCell(10000);
        $cell->addText('Разом:', $bold_styles_small_bold, $cellHRight);
        $cell = $table_chat->addCell(4000);
        $cell->addText($this->order->total_amount, $bold_styles_small_bold, $cellHRight);

        $table_chat = $section->addTable($table_style_another_no_bg);
        $table_chat->addRow();
        $cell = $table_chat->addCell(10000);
        $cell->addText('Разом без ПДВ:', $bold_styles_small_bold, $cellHRight);
        $cell = $table_chat->addCell(4000);
        $cell->addText('-', $bold_styles_small_bold, $cellHRight);

        $table_chat->addRow();
        $cell = $table_chat->addCell(10000);
        $cell->addText('ПДВ:', $bold_styles_small_bold, $cellHRight);
        $cell = $table_chat->addCell(4000);
        $cell->addText('-', $bold_styles_small_bold, $cellHRight);

        $table_chat->addRow();
        $cell = $table_chat->addCell(10000);
        $cell->addText('Всього з ПДВ:', $bold_styles_small_bold, $cellHRight);
        $cell = $table_chat->addCell(4000);
        $cell->addText('-', $bold_styles_small_bold, $cellHRight);








        $section->addTextBreak();
        $billTotalInfo = 'Всього найменувань '.$i.', на суму ' . $this->order->total_amount .' грн.';
        $section->addText($billTotalInfo, $bold_styles_small_bold, $main_pargraph_styles);

        $totalPriceStringText = self::num2str($this->order->total_amount);
        $first = mb_substr($totalPriceStringText,0,1, 'UTF-8');//первая буква
        $last = mb_substr($totalPriceStringText,1);//все кроме первой буквы
        $first = mb_strtoupper($first, 'UTF-8');
        $last = mb_strtolower($last, 'UTF-8');
        $totalPriceString = $first . $last;
        $section->addText($totalPriceString, $bold_styles_small_bold, $main_pargraph_styles);
        $section->addText('ПДВ: 0,00 грн', $bold_styles_small_10, $main_pargraph_styles);

        $section->addTextBreak();

        $table_chat = $section->addTable($table_style_another_no_bg);
        $table_chat->addRow();
        $cell = $table_chat->addCell(7500);
        $cell->addText('', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(2500);
        $cell->addText('Комірник', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(4000);
        $cell->addText('________________________________________', $bold_styles_small_10, $cellHLeft_footer);

        $table_chat->addRow();
        $cell = $table_chat->addCell(7500);
        $cell->addText('', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(2500);
        $cell->addText('Від постачальника', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(4000);
        $cell->addText('________________________________________', $bold_styles_small_10, $cellHLeft_footer);

        $table_chat->addRow();
        $cell = $table_chat->addCell(7500);
        $cell->addText('', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(2500);
        $cell->addText('Водій', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(4000);
        $cell->addText('________________________________________', $bold_styles_small_10, $cellHLeft_footer);

        $table_chat->addRow();
        $cell = $table_chat->addCell(7500);
        $cell->addText('', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(2500);
        $cell->addText('Отримав (ла)*', $bold_styles_small_bold, $cellHLeft_footer);
        $cell = $table_chat->addCell(4000);
        $cell->addText('________________________________________', $bold_styles_small_10, $cellHLeft_footer);


        $section->addTextBreak();

        $table_chat = $section->addTable($table_style_another_no_bg);
        $table_chat->addRow();
        $cell = $table_chat->addCell(5000);
        $cell->addText('', $bold_styles_small_bold, $cellHRight);
        $cell = $table_chat->addCell(9000);
        $cell->addText('* Піддони підлягають поверненню на протязі 14 днів від дати накладної (в належному стані). Клієнт не має претензій до кількості та якості відвантаженої продукції.', $bold_styles_small_bold, $cellHLeft_footer);





        return $phpWord;
    }



    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses morph(...)
     */
    protected static function num2str($num) {
        $nul='ноль';
        $ten=array(
//            array('','один','два','три','чотири','п\'ять','шість','сім', 'вісім','дев\'ять'),
            array('','одна','дві','три','чотири','п\'ять','шість','сім', 'вісім','дев\'ять'),
            array('','одна','дві','три','чотири','п\'ять','шість','сім', 'вісім','дев\'ять'),
        );
        $a20=array('десять','одинадцять','дванадцять','тринадцять','чотирнадцять' ,'п\'ятнадцять','шістнадцять','сімнадцять','вісімнадцять','дев\'ятнадцять');
        $tens=array(2=>'двадцять','тридцять','сорок','п\'ятдесят','шістдесят','сімдесят' ,'вісімдесят','дев\'яносто');
        $hundred=array('','сто','двісті','триста','чотириста','п\'ятсот','шістсот', 'сімсот','вісімсот','дев\'ятсот');

        $unit=array( // Units
            array('копійка' ,'копійки' ,'копійок',	 1),
            array('гривня', 'гривні', 'гривень',0),
            array('тисяча', 'тисячі', 'тисяч',1),
            array('мільйон', 'мільйона', 'мільйонів',0),
            array('мільярд', 'мільярда', 'мільярдів',0),
//            array('триллион', 'триллиона', 'триллионов'),
//            array('квадриллион', 'квадриллиона', 'квадриллионов'),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= self::morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = self::morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.self::morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    protected static  function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }
}
