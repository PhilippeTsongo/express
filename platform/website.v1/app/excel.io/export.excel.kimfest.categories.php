<?php
$con = mysqli_connect('localhost','root','','valwallet_db');
require '../core/init.php';
include("../config/PHPExcel/IOFactory.php");

$html = '<table border="1">';
$objPHPExcel = PHPExcel_IOFactory::load('vw.kimfest.categories.xlsx');

$_event_ID_ = 91;
$organization_ID = 18;

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
{
    $highestRow = $worksheet->getHighestRow();
    for ($row = 2; $row <= $highestRow; $row++) {
        $html .= '<tr>';

        $_POST['event-event_id'] = 91;
        $_POST['event-name'] = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
        $_POST['event-short_name'] = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
       
        if( $_POST['event-name'] != '' && $_POST['event-short_name'] ){
            # CHECK IF THE CONTESTANT EXISTS
            // if (!ExternalEventVotesConroller::checkIfExistsExternalEventProject($organization_ID, $event_['id'], $contestant_['id'])):

                # SAVE CONTESTANT 
                $result = EventController::addEventCategory();
                if ($result->ERRORS == false):
                       

                endif;
                         
                echo '<pre>';
                print_r($result);
                echo '</pre>';

            // endif;

        }
     
    }
}
$html .= '</table>';
echo $html;

?>