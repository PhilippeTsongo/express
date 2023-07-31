<?php
$con = mysqli_connect('localhost','root','','cns_platform_db');
require '../../core/init.php';
include("../../config/PHPExcel/IOFactory.php");

$html = '<table border="1">';
$objPHPExcel = PHPExcel_IOFactory::load('products.xlsx');

$_event_ID_ = 91;
$organization_ID = 18;

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
{
    $highestRow = $worksheet->getHighestRow();
    for ($row = 2; $row <= $highestRow; $row++) {
        $html .= '<tr>';

        $_POST['name'] = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
        $_POST['description'] = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
        $_POST['unit'] = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
        $_POST['shelf'] = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
       
        if( $_POST['name'] != '' && $_POST['description'] ){
            # CHECK IF THE CONTESTANT EXISTS
            // if (!ExternalEventVotesConroller::checkIfExistsExternalEventProject($organization_ID, $event_['id'], $contestant_['id'])):

                # SAVE CONTESTANT 
                $result = ProductController::add_pro();
                // if ($result->ERRORS == false):
                      
                // endif;
                         
                echo '<pre>';
                print_r($_POST);
                echo '</pre>';

            // endif;

        }
     
    }
}
$html .= '</table>';
echo $html;

?>