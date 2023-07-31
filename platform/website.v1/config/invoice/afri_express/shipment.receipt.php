<?php

/**
 * @package Shipment Receipt
 * @author Luc Chishugi [cishugiluc98@gmail.com] Software Engineer
 */
class myPDF extends FPDF
{
  function header() {
    // $this->Image( VIEW_LOGO_APAC2, 85,6,40);
  }
 
  function footer() {
    $this->SetY(-15);
    // $this->SetFont('cambria','B',11);
    $this->SetFont('arial','B', 8);
    $this->Cell(0,15,'Copyright 2023. Afri_Express - All rights reserved',0,0,'C');
    $this->Cell(0,15,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    $this->Ln();
  }
  
  function viewTable() {
    $HASH = new \Hash();


    if(!Input::checkInput('shiptoken', 'get', 1))
      Redirect::to(404);

    $_AUTH_TOKEN_ =   Input::get('shiptoken', 'get');
    $_SHIP_ID_ = Hash::decryptToken($_AUTH_TOKEN_);

    // if(!is_integer(($_SHIP_ID_)))
    //     Redirect::to(DNADMIN . '?lflf -- ' . $_SHIP_ID_ );

    $_SHIP_ENCRYPTED_ = $HASH->encryptAES($_SHIP_ID_);

    $_SHIP_DATA_ = HttpRequest::callAPI("POST", _APIURL_SHIPDOCS_, _AUTHORIZATION_, $_SHIP_ENCRYPTED_, "{}");
    $_DATA_ITEM_ = HttpRequest::callAPI("POST", _APIURL_SHIPDOCS_, _AUTHORIZATION_, $_SHIP_ENCRYPTED_, "{}");

    if(!($_SHIP_DATA_))
        Redirect::to(DNADMIN);

        
    if(!($_DATA_ITEM_))
        Redirect::to(DNADMIN);

    $_SHIP_DATA_ = $_SHIP_DATA_->data;
    $_DATA_ITEM_ = $_DATA_ITEM_->data_item;
  
    // $_SHIP_STATUS_DATA_ = $_SHIP_DATA_->data->shipstatus;

    #+++++++++++++++++++++++++++++++++++++++++++++++#
    #            SHIPMENT RECEIPT                   #
    #+++++++++++++++++++++++++++++++++++++++++++++++#

    # SHIPMENT RECEIPT PAGE HEADER

    // add afri express logo document title
    $img_path = '../../build/web01/assets/wp-content/images/logo/afri1.png';
    $this->Image($img_path, 10, 3, 40, 16);
    $this->SetFont('arial','B', 25);
    $this->Cell(187,5,'Shipment Receipt',0,1, 'R');
    
    // set horizontal line
    $this->SetLineWidth(0.4);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,20,200,20);
    $this->Ln(13);

    # SHIPMENT RECEIPT PAGE BODY
    $this->SetFont('arial','B',13);
    $this->Cell(10,0,'Shipment From', 0,0, 'L');
    $this->Cell(130,0,'Shipment To',0,0, 'R');
    $this->Ln(8);

    $this->SetFont('arial','', 10);

    // Company Name(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_company_name, 0, 0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_company_name, 0, 1, 'L');
    $this->Ln(3);

    // First Name(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_firstname . ' ' . $_SHIP_DATA_->source_lastname, 0, 0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_firstname . ' ' . $_SHIP_DATA_->destination_lastname, 0, 1, 'L');
    $this->Ln(3);

    // First Addresses(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_address_1, 0, 0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_address_1, 0, 0, 'L');
    $this->Ln(4);

    // Second Addresses(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_address_2, 0, 0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_address_2, 0, 0, 'L');
    $this->Ln(4);

    // Province - City(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_city.','.' '.$_SHIP_DATA_->source_province,0,0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_city.','.' '.$_SHIP_DATA_->destination_province,0,0, 'L');
    $this->Ln(4);
    
    // Country(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_country,0,0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_country,0,0, 'L');
    $this->Ln(4);
    
    // Phone Number(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_telephone,0,0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_telephone,0,0, 'L');
    $this->Ln(4);
    
    // Address Email(For both sender and receiver)
    $this->Cell(111,0, $_SHIP_DATA_->source_email,0,0, 'L');
    $this->Cell(50,0, $_SHIP_DATA_->destination_email,0,0, 'L');
    $this->Ln(4);
    
    // set horizontal line
    $this->SetLineWidth(0.4);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,75,200,75);
    $this->Ln(6);

    $total_item_value = 0;
    $total_package_weight = 0;
    foreach($_DATA_ITEM_ as $ship_item)
    {
      $ship_item->name;
      $ship_item->dimension;
      $ship_item->description;
      $ship_item->weight;
      $ship_item->quantity . ' ' . $ship_item->unit;
      $ship_item->value . ' ' . $ship_item->currency;
      number_format($ship_item->quantity * $ship_item->value, '2'). ' '. $ship_item->currency;
      
      $total_item_value = $total_item_value + ($ship_item->value * $ship_item->quantity ); 
      $total_package_weight = number_format($total_package_weight + $ship_item->weight, '1');
    }

    // Shipment Details & International Information
    $this->Ln(10);
    $this->SetTextColor(0,0,0);
    $this->SetFont('arial','B', 13);
    $this->Cell(60,0,'Shipment Details',0,0, 'L');
    $this->Cell(106,0,'International Information',0,0, 'R');
    $this->Ln(10);
    //Shipment Details Values
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,'Shipment Date:',0,0, 'L');
    $this->Cell(60,0,''. $_SHIP_DATA_->creation_datetime,0,0, 'L');

    // International Information Values
    $this->Cell(30,0,'Shipment Value:',0,0, 'L');
    $this->Cell(60,0, $total_item_value . ' ' . $ship_item->currency ,0,1, 'L');
    $this->Ln(4);

    //Shipment Details Values
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,'Shipment Number:',0,0, 'L');
    $this->Cell(60,0,''. $_SHIP_DATA_->code,0,0, 'L');

    //Shipment Details Values
    $this->SetFont('arial','', 10);
    $this->Cell(30,0,'Service Type:',0,0, 'L');
    $this->Cell(60,0,'EXPRESS WORLDWIDE',0,0, 'L');

    //Shipment Details Values
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,'Packaging Type:',0,0, 'L');
    $this->Cell(60,0,''. $_SHIP_DATA_->ship_purpose,0,0, 'L');

    // International Information Values
    $this->Cell(40,0,'Estimated Del date:',0,0, 'L');
    $this->Cell(40,0,'Depends on the destination',0,1, 'L');
    $this->Ln(4);
    
    //Shipment Details Values
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,'Number of items:',0,0, 'L');
    $this->Cell(60,0,count($_DATA_ITEM_) . ' ' . 'Items',0,0, 'L');

    // International Information Values
    $this->Cell(30,0,'Promo Code:',0,0, 'L');
    $this->Cell(60,0,'',0,1, 'L');
    $this->Ln(4);

    //Shipment Details Values
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,'Total Weight:',0,0, 'L');
    $this->Cell(60,0, $total_package_weight . ' ' . 'Kg',0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Chargeable Weight:',0,0, 'L');
    $this->Cell(60,0, $total_package_weight . ' ' . 'Kg',0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Delivery Instrunction:',0,0, 'L');
    $this->Cell(60,0,$_SHIP_DATA_->destination_pickup_type,0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Delivery Location:',0,0, 'L');
    $this->Cell(60,0, $_SHIP_DATA_->destination_pickup_location,0,0, 'L');
    $this->Ln(10);

    // Billing Information
    $this->SetTextColor(0,0,0);
    $this->SetFont('arial','B', 13);
    $this->Cell(60,0,'Billing Information',0,0, 'L');
    $this->Ln(10);

    //Billing Information Values
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,'Charge Breakdown:',0,0, 'L');
    $this->Cell(60,0,$_SHIP_DATA_->ship_cost,0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Payment Type:',0,0, 'L');
    $this->Cell(60,0,'Cash Payment',0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Billing Account:',0,0, 'L');
    $this->Cell(60,0,'Cash Shipment',0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Duties&taxes acct::',0,0, 'L');
    $this->Cell(60,0,'Receiver Will Pay',0,0, 'L');

    $this->Cell(30,0,'Special Services:',0,0, 'L');
    $this->MultiCell(67,4,'Fuel Surcharge/Residential Address/Duties & Taxes Unpaid/Restricted Destination/Emergency Situation',0,'L');
    $this->Ln(20);

    $this->SetFont('arial','', 12);
    $this->Cell(50,0,'Charge is estimated until Afri_Express reweigh',0,1, 'L');
    $this->Ln(13);

    // Reference Information
    $this->SetTextColor(0,0,0);
    $this->SetFont('arial','B', 13);
    $this->Cell(60,0,'Reference Information',0,0, 'L');
    $this->Ln(10);

    //Reference Information Values
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,'Reference:'. ' ' .$_SHIP_DATA_->code,0,0, 'L');
    $this->Cell(60,0,'',0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Pickup reference number:',0,0, 'L');
    $this->Cell(60,0,'',0,0, 'L');
    $this->Ln(20);

    // Description of Contents
    $this->SetTextColor(0,0,0);
    $this->SetFont('arial','B', 13);
    $this->Cell(60,0,'Description of Contents',0,0, 'L');
    $this->Ln(10);

    //Description of Contents Value
    $this->SetFont('arial','', 10);
    $this->Cell(50,0,''. $_SHIP_DATA_->ship_description,0,1, 'L');
    $this->Ln(50);

    
































    


   #+++++++++++++++++++++++++++++++++++++++++++++++#
   #           PROFORMA INVOICE                    #
   #+++++++++++++++++++++++++++++++++++++++++++++++#

    # PROFORMA INVOICE PAGE HEADER
    $this->SetFont('arial','B', 25);
    $this->Cell(10,0,'Proforma Invoice',0,1, 'L');
    $this->Ln(13);

    $this->SetFont('arial','B', 9);
    $this->Cell(25,0,'Shipment No:',0,0, 'L');
    $this->SetFont('arial','', 9);
    $this->Cell(50,0, $_SHIP_DATA_->code,0,0, 'L');

    $this->SetFont('arial','B', 9);
    $this->Cell(25,0,'Invoice Date:',0,0, 'L');
    $this->SetFont('arial','', 9);
    $this->Cell(35,0,''. $_SHIP_DATA_->creation_datetime,0,0, 'L');

    $this->SetFont('arial','B', 9);
    $this->Cell(20,0,'Invoice No:',0,0, 'L');
    $this->SetFont('arial','', 9);
    $this->Cell(40,0, $_SHIP_DATA_->code,0,0, 'L');
    $this->Ln(10);

    # PROFORMA INVOICE PAGE BODY
    $this->SetFont('arial','B',13);
    $this->Cell(10,0,'Ship From',0,0, 'L');
    $this->Cell(120,0,'Ship To',0,0, 'R');
    $this->Ln(10);

    $this->SetFont('arial','', 10);

    // Company Name(For both sender and receiver)
    $this->Cell(111,2,''. $_SHIP_DATA_->source_company_name,0,0, 'L');
    $this->Cell(50,2,''. $_SHIP_DATA_->destination_company_name,0,0, 'L');
    $this->Ln(4);

    // First Name(For both sender and receiver)
    $this->Cell(111,2,''. $_SHIP_DATA_->source_firstname . ' ' . $_SHIP_DATA_->source_lastname,0,0, 'L');
    $this->Cell(50,2,''. $_SHIP_DATA_->destination_firstname . ' ' . $_SHIP_DATA_->destination_lastname,0,0, 'L');
    $this->Ln(4);

    // First Addresses(For both sender and receiver)
    $this->Cell(111,0,'' . $_SHIP_DATA_->source_address_1,0,0, 'L');
    $this->Cell(50,0,''. $_SHIP_DATA_->destination_address_1,0,0, 'L');
    $this->Ln(4);

    // Second Addresses(For both sender and receiver)
    $this->Cell(111,0,''. $_SHIP_DATA_->source_address_2,0,0, 'L');
    $this->Cell(50,0,''. $_SHIP_DATA_->destination_address_2,0,0, 'L');
    $this->Ln(4);

    // Province - City(For both sender and receiver)
    $this->Cell(111,0,''. $_SHIP_DATA_->source_city.',' . ' '. $_SHIP_DATA_->source_province,0,0, 'L');
    $this->Cell(50,0,''. $_SHIP_DATA_->destination_city.',' . ''. $_SHIP_DATA_->source_province,0,0, 'L');
    $this->Ln(4);
    
    // Country(For both sender and receiver)
    $this->Cell(111,0,''. $_SHIP_DATA_->source_country,0,0, 'L');
    $this->Cell(50,0,''. $_SHIP_DATA_->destination_country,0,0, 'L');
    $this->Ln(4);
    
    // Phone Number(For both sender and receiver)
    $this->Cell(111,0,''. $_SHIP_DATA_->source_telephone,0,0, 'L');
    $this->Cell(50,0,''. $_SHIP_DATA_->destination_telephone,0,0, 'L');
    $this->Ln(4);
    
    // Address Email(For both sender and receiver)
    $this->Cell(111,0,''. $_SHIP_DATA_->source_email,0,0, 'L');
    $this->Cell(50,0,''. $_SHIP_DATA_->destination_email,0,0, 'L');
    $this->Ln(8);

    $this->Cell(50,0,'Remarks:',0,0, 'L');
    $this->Cell(60,0,'',0,0, 'L');
    $this->Ln(13);

    // Table of shipped items
    $this->Ln(5);
    $this->SetTextColor(0,0,0);
    //Table Header
    $this->SetFont('arial','B', 7);
    $this->Cell(8,8, 'Item',1,0, 'L');
    $this->Cell(30,8, 'Name',1,0, 'L');

    $this->Cell(15,8, 'Dimension',1,0, 'L');

    $this->Cell(75,8,'Description',1,0, 'L');
    $this->Cell(20,8,'Item Weight',1,0, 'L');
    $this->Cell(13,8,'QTY',1,0, 'L');
    $this->Cell(15,8,'Unit Value',1,0, 'L');
    $this->Cell(20,8,'Sub Total Value',1,1, 'L');

    // Table Data
    $count = 0;
    $total_item_value = 0;
    $total_package_weight = 0;
    foreach($_DATA_ITEM_ as $ship_item)
    {
      $count++;
      $this->SetFont('arial','', 7);
      $this->Cell(8,8, $count ,1,0, 'L');
      $this->Cell(30,8, $ship_item->name, 1,0, 'L');
      $this->Cell(15,8, $ship_item->dimension, 1,0, 'L');
      $this->Cell(75,8, $ship_item->description ,1,0, 'L');
      $this->Cell(20,8, $ship_item->weight . ' ' . 'Kg' ,1,0, 'L');
      $this->Cell(13,8, $ship_item->quantity . ' ' . $ship_item->unit ,1,0, 'L');
      $this->Cell(15,8, $ship_item->value . ' ' . $ship_item->currency ,1,0, 'L');
      $this->Cell(20,8, number_format($ship_item->quantity * $ship_item->value, '2'). ' '. $ship_item->currency ,1,1, 'L');
      
      $total_item_value = $total_item_value + ($ship_item->value * $ship_item->quantity ); 
      $total_package_weight = number_format($total_package_weight + $ship_item->weight, '1');
    }

    $this->Ln(4);
  
    $this->SetFont('arial','', 9);
    $this->Cell(50,0,'Total Goods Value:',0,0, 'L');
    $this->Cell(60,0, $total_item_value. ' ' . $ship_item->currency ,0,0, 'L');
    $this->Ln(4);

    $this->Cell(50,0,'Total items:',0,0, 'L');
    $this->Cell(60,0, count($_DATA_ITEM_) . ' ' .'Item(s)' ,0,0, 'L');
    $this->Ln(4);
    
    $this->Cell(50,0,'Source Pick Up Instruction:',0,0, 'L');
    $this->Cell(60,0, $_SHIP_DATA_->source_pickup_type,0,0, 'L');
    $this->Ln(4);

    $this->Cell(50,0,'Source Pick Up Location:',0,0, 'L');
    $this->Cell(60,0, $_SHIP_DATA_->source_pickup_location,0,0, 'L');
    $this->Ln(4);

    $this->Cell(50,0,'Destination Pick Up Instruction:',0,0, 'L');
    $this->Cell(60,0, $_SHIP_DATA_->destination_pickup_type,0,0, 'L');
    $this->Ln(4);

    $this->Cell(50,0,'Destiination Pick Up Location:',0,0, 'L');
    $this->Cell(60,0, $_SHIP_DATA_->destination_pickup_location,0,0, 'L');
    $this->Ln(4);

    $this->Cell(50,0,'Reason for Export:',0,0, 'L');
    $this->Cell(60,0, $_SHIP_DATA_->ship_purpose,0,0, 'L');
    $this->Ln(4);
    $this->Cell(50,0,'Total Weight:',0,0, 'L');
    $this->Cell(60,0,$total_package_weight. ' ' .'Kg',0,0, 'L');
    
    $this->Ln(50);

    // Certify
    $this->Cell(50,0,'I/We hereby certify that the information contained in the invoice is true and correct and that the contents of this shipment are as stated above.',0,0, 'L');
    $this->Ln(15);

    // Name
    $this->SetFont('arial','B', 9);
    $this->Cell(20,0,'Name:',0,0, 'L');
    // Name Value
    $this->SetFont('arial','', 9);
    $this->Cell(80,0,''. $_SHIP_DATA_->source_firstname. '' . $_SHIP_DATA_->source_lastname,0,0, 'L');
    // Signature
    $this->SetFont('arial','B', 9);
    $this->Cell(40,0,'Signature:',0,0, 'L');
    // Company Stamp
    $this->SetFont('arial','B', 9);
    $this->Cell(40,0,'Company Stamp',0,1, 'L');
    $this->Ln(4);
    // Position
    $this->Cell(50,0,'Position:',0,0, 'L');
    $this->Ln(6);
    // Date of Signature
    $this->Cell(50,0,'Date of Signature: _______________________',0,0, 'L');
    $this->Ln(60);

    




































    
    #+++++++++++++++++++++++++++++++++++++++++++++++#
    #            WAYBILL DOC                        #
    #+++++++++++++++++++++++++++++++++++++++++++++++#

    # WAYBILL DOC PAGE HEADER

    // add afri express logo document title
    $this->SetFont('arial','B', 15);
    $this->Cell(60,5,'*WAYBILL DOC*',0,1, 'L');
    $this->SetFont('arial','B', 7);
    $this->Cell(43,5,'Not to be attached to package - Hand to Courier',0,1, 'L');
    $this->SetFont('arial','', 7);
    $this->Cell(43,5,'2023-02-25, Afri_Express Global',0,1, 'L');
    $img_path = '../../build/web01/assets/wp-content/images/logo/afri1.png';
    $this->Image($img_path, 135, 3, 40, 16);
    
    
    // set horizontal line
    $this->SetLineWidth(0.2);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,25,180,25);
    $this->Ln(3);

    # WAYBILL DOC PAGE BODY
    $this->SetFont('arial','B',10);
    $this->Cell(18,0,'Shipper:',0,0, 'L');
    $this->SetFont('arial','',10);
    $this->Cell(130,0,''. $_SHIP_DATA_->source_company_name,0,0, 'L');
    $this->Cell(50,0,'Origin:',0,0, 'L');
    $this->Ln(4);

    // First Name(For both sender and receiver)
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(130,0, $_SHIP_DATA_->source_firstname. ''. $_SHIP_DATA_->source_lastname,0,0, 'L');
    $this->SetFont('arial','B',13);
    $this->Cell(121,0, $_SHIP_DATA_->source_city,0,0, 'L');
    $this->Ln(4);

    // First Addresse(For sender )
    $this->SetFont('arial','',10);
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(55,0, $_SHIP_DATA_->source_address_1,0,0, 'L');
    $this->Ln(4);

    // Province - City(For both sender and receiver)
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(45,0,$_SHIP_DATA_->source_city.',' . ' ' . $_SHIP_DATA_->source_country ,0,1, 'L');
    $this->Ln(4);
    
    // Address Email(For both sender and receiver)
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(48,0, $_SHIP_DATA_->source_email, 0,0, 'L');
    $this->Ln(4);

    // Telephone(For both sender and receiver)
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(48,0, $_SHIP_DATA_->source_telephone, 0,0, 'L');

    // set horizontal line
    $this->SetLineWidth(0.2);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,55,180,55);
    $this->Ln(10);

    $this->SetFont('arial','B',10);
    $this->Cell(18,0,'Receiver:',0,0, 'L');
    $this->SetFont('arial','',10);
    $this->Cell(130,0,''. $_SHIP_DATA_->destination_company_name,0,0, 'L');
    $this->Cell(50,0,'Ship Weight:',0,0, 'L');
    $this->Ln(4);

    // First Name(For both sender and receiver)
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(130,0, $_SHIP_DATA_->destination_firstname. ''. $_SHIP_DATA_->destination_lastname,0,0, 'L');
    $this->SetFont('arial','B',13);
    $this->Cell(121,0, $total_package_weight. ' ' .'Kg', 0,0, 'L');
    $this->Ln(4);

    // First Addresse(For sender )
    $this->SetFont('arial','',10);
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(55,0, $_SHIP_DATA_->destination_address_1,0,0, 'L');
    $this->Ln(4);
    
    // Address Email(For both sender and receiver)
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(48,0, $_SHIP_DATA_->destination_email, 0,0, 'L');
    $this->Ln(4);

    // Telephone(For both sender and receiver)
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(48,0, $_SHIP_DATA_->destination_telephone, 0,0, 'L');
    $this->Ln(15);

    // Province - City(For both sender and receiver)
    $this->SetFont('arial','B',20);
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(90,0,$_SHIP_DATA_->destination_city ,0,0, 'L');
    $this->Ln(6);
    $this->SetFont('arial','B',15);
    $this->Cell(18,0,'',0,0, 'L');
    $this->Cell(90,0,$_SHIP_DATA_->destination_country,0,0, 'L');
    $this->Ln(6);

    // set horizontal line
    $this->SetLineWidth(0.2);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,101,180,101);
    $this->Ln(3);

    // Shipment Details
    $this->SetFont('arial','B',10);
    $this->Cell(50,0,'Shipment Details',0,1, 'L');
    $this->Ln(5);

    // First Name(For both sender and receiver)
    $this->SetFont('arial','',10);
    $this->Cell(33,0,'Ref: '. $_SHIP_DATA_->code,0,1, 'L');
    $this->Ln(10);

    // set horizontal line
    $this->SetLineWidth(0.2);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,123,180,123);
    $this->Ln(2);
    //Shipment Details Values
    $this->SetFont('arial','', 10);
    $this->Cell(80,0,'Name (in Capital Letters)',0,0, 'L');
    $this->Cell(55,0,'Signature',0,0, 'L');

    // International Information Values
    $this->Cell(40,0,'Date (DD.MM.YYYY)',0,0, 'L');
    $this->Ln(10);

    // set horizontal line
    $this->SetLineWidth(0.2);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,150,180,150);
    $this->Ln(40);

    $img_path = SHIPQRFILE.$_SHIP_DATA_->code.'.png';
    $this->Image($img_path, 55, 170, 100, 100);
    $this->Ln(150);


















    
    #+++++++++++++++++++++++++++++++++++++++++++++++#
    #            TERMS AND CONDITIONS               #
    #+++++++++++++++++++++++++++++++++++++++++++++++#

    # WAYBILL DOC PAGE HEADER

    // add afri express logo document title
    $this->SetFont('arial','B', 15);
    $this->Cell(60,5,'TERMS AND CONDITIONS',0,1, 'L');
    $img_path = '../../build/web01/assets/wp-content/images/logo/afri1.png';
    $this->Image($img_path, 135, 3, 40, 16);
    
    // set horizontal line
    $this->SetLineWidth(0.3);
    $this->SetDrawColor(9, 9, 9);
    $this->Line(10,20,180,20);
    $this->Ln(13);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'General Terms',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'By accessing and ordering services with afriexpressglobal, you confirm that you are in agreement with and bound by the terms of service contained in the Terms & Conditions outlined below. These terms apply to the entire website and any email or other type of communication between you and afriexpressglobal.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Under no circumstances shall afriexpressglobal team be liable for any direct, indirect, special, incidental or consequential damages, including, but not limited to, loss of data or profit, arising out of the use, or the inability to use, the materials on this site, even if afriexpressglobal team or an authorized representative has been advised of the possibility of such damages. If your use of materials from this site results in the need for servicing, repair or correction of equipment or data, you assume any costs thereof.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'afriexpressglobal will not be responsible for any outcome that may occur during the course of usage of our resources. We reserve the rights to change prices and revise the resources usage policy in any moment.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'License',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'afriexpressglobal grants you a revocable, non-exclusive, non-transferable, limited license to download, install and use the website strictly in accordance with the terms of this Agreement.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'These Terms & Conditions are a contract between you and afriexpressglobal (referred to in these Terms & Conditions as "afriexpressglobal", "we cnsplatforme"), the provider of the afriexpressglobal website and the services accessible from the afriexpressglobal website (which are collectively referred to in these Terms & Conditions as the "afriexpressglobal Service").',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'You are agreeing to be bound by these Terms & Conditions. If you do not agree to these Terms & Conditions, please do not use the afriexpressglobal Service. In these Terms & Conditions, "you" refers both to you as an individual and to the entity you represent. If you violate any of these Terms & Conditions, we reserve the right to cancel your account or block access to your account without notice.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Meanings',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'For this Terms & Conditions:',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'- Cookie: small amount of data generated by a website and saved by your web browser. It is used to identify your browser, provide analytics, remember information about you such as your language preference or login information.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Company: when this policy mentions "Company," "we," "us," or "our," it refers to Afri_Express Global Inc., (UN Drive & Clay street) that is responsible for your information under this Terms & Conditions.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Country: where afriexpressglobal or the owners/founders of afriexpressglobal are based, in this case is Liberia or else where in the world where afriexpressglobal are operated.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Device: any internet connected device such as a phone, tablet, computer or any other device that can be used to visit afriexpressglobal and use the services.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Service: refers to the service provided by afriexpressglobal as described in the relative terms (if available) and on this platform.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Third-party service: refers to advertisers, contest sponsors, promotional and marketing partners, and others who provide our content or whose products or services we think may interest you.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Website: afriexpressglobal\'s site, which can be accessed via this URL: https//:afriexpressglobal.cnsplatforme.com',0,'L');    
    $this->Ln(3);
    $this->MultiCell(200,4,'- You: a person or entity that is registered with afriexpressglobal to use the Services.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Restrictions',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'You agree not to, and you will not permit others to:',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- License, sell, rent, lease, assign, distribute, transmit, host, outsource, disclose or otherwise commercially exploit the website or make the platform available to any third party.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'-License, sell, rent, lease, assign, distribute, transmit, host, outsource, disclose or otherwise commercially exploit the website or make the platform available to any third party.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Modify, make derivative works of, disassemble, decrypt, reverse compile or reverse engineer any part of the website.',0,'L');
    $this->Ln(3);
    $this->MultiCell(200,4,'- Remove, alter or obscure any proprietary notice (including any notice of copyright or trademark) of afriexpressglobal or its affiliates, partners, suppliers or the licensors of the website.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Return and Refund Policy',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'Thanks for shipping with afriexpressglobal. We appreciate the fact that you like to use our services we provide. We also want to make sure you have a rewarding experience while you\'re exploring, evaluating, and making using of our services.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'As with any shipping experience, there are terms and conditions that apply to transactions at afriexpressglobal, the customs laws in most countries and the illegal transportation of prohibited goods or any illegal substances or merchandise. We\'ll be as brief as our attorneys will allow. The main thing to remember is that by requesting our services for your convenient shipping experience at afriexpressglobal, you agree to the terms along with afriexpressglobal thus adhering to National customs law and the international law governing the transport of illegal merchandise, arms and ammunition or other illegal substances."\'s" Privacy Policy.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'If, for any reason, You are not completely satisfied with any of our services that we provide, don\'t hesitate to contact us and we will discuss any of the issues you are going through with our services provided.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Your Suggestions',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'Any feedback, comments, ideas, improvements or suggestions (collectively, "Suggestions") provided by you to afriexpressglobal with respect to the website shall remain the sole and exclusive property of afriexpressglobal.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'afriexpressglobal shall be free to use, copy, modify, publish, or redistribute the Suggestions for any purpose and in any way without any credit or any compensation to you.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Your Consent',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'We\'ve updated our Terms & Conditions to provide you with complete transparency into what is being set when you visit our site and how it\'s being used. By using our website, registering an account, or making use of our services, you hereby consent to our Terms & Conditions.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Links to Other Websites',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'This Terms & Conditions applies only to the Services. The Services may contain links to other websites not operated or controlled by afriexpressglobal. We are not responsible for the content, accuracy or opinions expressed in such websites, and such websites are not investigated, monitored or checked for accuracy or completeness by us. Please remember that when you use a link to go from the Services to another website, our Terms & Conditions are no longer in effect. Your browsing and interaction on any other website, including those that have a link on our platform, is subject to that website\'s own rules and policies. Such third parties may use their own cookies or other methods to collect information about you.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Cookies',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'afriexpressglobal uses "Cookies" to identify the areas of our website that you have visited. A Cookie is a small piece of data stored on your computer or mobile device by your web browser. We use Cookies to enhance the performance and functionality of our website but are non-essential to their use. However, without these cookies, certain functionality like videos may become unavailable or you would be required to enter your login details every time you visit the website as we would not be able to remember that you had logged in previously. Most web browsers can be set to disable the use of Cookies. However, if you disable Cookies, you may not be able to access functionality on our website correctly or at all. We never place Personally Identifiable Information in Cookies.', 8);
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Changes To Our Terms & Conditions',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'You acknowledge and agree that afriexpressglobal may stop (permanently or temporarily) providing the Service (or any features within the Service) to you or to users generally at afriexpressglobal sole discretion, without prior notice to you. You may stop using the Service at any time. You do not need to specifically inform afriexpressglobal when you stop using the Service. You acknowledge and agree that if',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'If we decide to change our Terms & Conditions, we will post those changes on this page, and/or update the Terms & Conditions modification date below.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Modifications to Our website',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'afriexpressglobal reserves the right to modify, suspend or discontinue, temporarily or permanently, the website or any service to which it connects, with or without notice and without liability to you.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Updates to Our website',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'afriexpressglobal may from time to time provide enhancements or improvements to the features/ functionality of the website, which may include patches, bug fixes, updates, upgrades and other modifications ("Updates").',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Updates may modify or delete certain features and/or functionalities of the website. You agree that afriexpressglobal has no obligation to (i) provide any Updates, or (ii) continue to provide or enable any particular features and/or functionalities of the website to you.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'You further agree that all Updates will be (i) deemed to constitute an integral part of the website, and (ii) subject to the terms and conditions of this Agreement.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Third-Party Services',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'We may display, include or make available third-party content (including data, information, applications and other products services) or provide links to third-party websites or services ("Third- Party Services").',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'You acknowledge and agree that afriexpressglobal shall not be responsible for any Third-Party Services, including their accuracy, completeness, timeliness, validity, copyright compliance, legality, decency, quality or any other aspect thereof. afriexpressglobal does not assume and shall not have any liability or responsibility to you or any other person or entity for any Third-Party Services.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Third-Party Services and links thereto are provided solely as a convenience to you and you access and use them entirely at your own risk and subject to such third parties\' terms and conditions.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Term and Termination',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'This Agreement shall remain in effect until terminated by you or afriexpressglobal. afriexpressglobal may, in its sole discretion, at any time and for any or no reason, suspend or terminate this Agreement with or without prior notice.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'This Agreement will terminate immediately, without prior notice from afriexpressglobal, in the event that you fail to comply with any provision of this Agreement. You may also terminate this Agreement by deleting the website and all copies thereof from your computer.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Upon termination of this Agreement, you shall cease all use of the website and delete all copies of the website from your computer. Termination of this Agreement will not limit any of afriexpressglobal\'s rights or remedies at law or in equity in case of breach by you (during the term of this Agreement) of any of your obligations under the present Agreement.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Copyright Infringement Notice',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'If you are a copyright owner or such owner\'s agent and believe any material on our website constitutes an infringement on your copyright, please contact us setting forth the following information: (a) a physical or electronic signature of the copyright owner or a person authorized to act on his behalf; (b) identification of the material that is claimed to be infringing; (c) your contact information, including your address, telephone number, and an email; (d) a statement by you that you have a good faith belief that use of the material is not authorized by the copyright owners; and (e) the a statement that the information in the notification is accurate, and, under penalty of perjury you are authorized to act on behalf of the owner.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Indemnification',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'You agree to indemnify and hold afriexpressglobal and its parents, subsidiaries, affiliates, officers, employees, agents, partners and licensors (if any) harmless from any claim or demand, including reasonable attorneys\' fees, due to or arising out of your: (a) use of the website; (b) violation of this Agreement or any law or regulation; or (c) violation of any right of a third party.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'No Warranties',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'The website is provided to you "AS IS" and "AS AVAILABLE" and with all faults and defects without warranty of any kind. To the maximum extent permitted under applicable law, afriexpressglobal, on its own behalf and on behalf of its affiliates and its and their respective licensors and service providers, expressly disclaims all warranties, whether express, implied, statutory or otherwise, with respect to the website, including all implied warranties of merchantability, fitness for a particular purpose, title and non-infringement, and warranties that may arise out of course of dealing, course of performance, usage or trade practice. Without limitation to the foregoing, afriexpressglobal provides no warranty or undertaking, and makes no representation of any kind that the website will meet your requirements, achieve any intended results, be compatible or work with any other software, , systems or services, operate without interruption, meet any performance or reliability standards or be error free or that any errors or defects can or will be corrected.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Without limiting the foregoing, neither afriexpressglobal nor any afriexpressglobal\'s provider makes any representation or warranty of any kind, express or implied: (i) as to the operation or availability of the website, or the information, content, and materials or products included thereon; (ii) that the website will be uninterrupted or error-free; (iii) as to the accuracy, reliability, or currency of any information or content provided through the website; or (iv) that the website, its servers, the content, or e-mails sent from or on behalf of afriexpressglobal are free of viruses, scripts, trojan horses, worms, malware, timebombs or other harmful components.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Some jurisdictions do not allow the exclusion of or limitations on implied warranties or the limitations on the applicable statutory rights of a consumer, so some or all of the above exclusions and limitations may not apply to you.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Limitation of Liability',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'Notwithstanding any damages that you might incur, the entire liability of afriexpressglobal and any of its suppliers under any provision of this Agreement and your exclusive remedy for all of the foregoing shall be limited to the amount actually paid by you for the website.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'To the maximum extent permitted by applicable law, in no event shall afriexpressglobal or its suppliers be liable for any special, incidental, indirect, or consequential damages whatsoever (including, but not limited to, damages for loss of profits, for loss of data or other information, for business interruption, for personal injury, for loss of privacy arising out of or in any way related to the use of or inability to use the website, third-party software and/or third-party hardware used with the website, or otherwise in connection with any provision of this Agreement), even if afriexpressglobal or any supplier has been advised of the possibility of such damages and even if the remedy fails of its essential purpose.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Some states/jurisdictions do not allow the exclusion or limitation of incidental or consequential damages, so the above limitation or exclusion may not apply to you.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Severability',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'If any provision of this Agreement is held to be unenforceable or invalid, such provision will be changed and interpreted to accomplish the objectives of such provision to the greatest extent possible under applicable law and the remaining provisions will continue in full force and effect.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'This Agreement, together with the Privacy Policy and any other legal notices published by afriexpressglobal on the Services, shall constitute the entire agreement between you and afriexpressglobal concerning the Services. If any provision of this Agreement is deemed invalid by a court of competent jurisdiction, the invalidity of such provision shall not affect the validity of the remaining provisions of this Agreement, which shall remain in full force and effect. No waiver of any term of this Agreement shall be deemed a further or continuing waiver of such term or any other term, and afriexpressglobal."\'s" failure to assert any right or provision under this Agreement shall not constitute a waiver of such right or provision. YOU AND afriexpressglobal AGREE THAT ANY CAUSE OF ACTION ARISING OUT OF OR RELATED TO THE SERVICES MUST COMMENCE WITHIN ONE (1) YEAR AFTER THE CAUSE OF ACTION ACCRUES. OTHERWISE, SUCH CAUSE OF ACTION IS PERMANENTLY BARRED.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Waiver',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'Except as provided herein, the failure to exercise a right or to require performance of an obligation under this Agreement shall not effect a party\'s ability to exercise such right or require such performance at any time thereafter nor shall be the waiver of a breach constitute waiver of any subsequent breach.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'No failure to exercise, and no delay in exercising, on the part of either party, any right or any power under this Agreement shall operate as a waiver of that right or power. Nor shall any single or partial exercise of any right or power under this Agreement preclude further exercise of that or any other right granted herein. In the event of a conflict between this Agreement and any applicable purchase or other terms, the terms of this Agreement shall govern.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Amendments to this Agreement',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'afriexpressglobal reserves the right, at its sole discretion, to modify or replace this Agreement at any time. If a revision is material we will provide at least 30 days\' notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion. By continuing to access or use our website after any revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you are no longer authorized to use afriexpressglobal.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Entire Agreement',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'The Agreement constitutes the entire agreement between you and afriexpressglobal regarding your use of the website and supersedes all prior and contemporaneous written or oral agreements between you and afriexpressglobal. You may be subject to additional terms and conditions that apply when you use or purchase other afriexpressglobal\'s services, which afriexpressglobal will provide to you at the time of such use or purchase.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Updates to Our Terms',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'We may change our Service and policies, and we may need to make changes to these Terms so that they accurately reflect our Service and policies. Unless otherwise required by law, we will notify you (for example, through our Service) before we make changes to these Terms and give you an opportunity to review them before they go into effect. Then, if you continue to use the Service, you will be bound by the updated Terms. If you do not want to agree to these or any updated Terms, you can delete your account.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Intellectual Property',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'The website and its entire contents, features and functionality (including but not limited to all information, software, text, displays, images, video and audio, and the design, selection and arrangement thereof), are owned by afriexpressglobal, its licensors or other providers of such material and are protected by Liberia and international copyright, trademark, patent, trade secret and other intellectual property or proprietary rights laws. The material may not be copied, modified, reproduced, downloaded or distributed in any way, in whole or in part, without the express prior written permission of afriexpressglobal, unless and except as is expressly provided in these Terms & Conditions. Any unauthorized use of the material is prohibited.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Agreement to Arbitrate',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'This section applies to any dispute EXCEPT IT DOESN\'T INCLUDE A DISPUTE RELATING TO CLAIMS FOR INJUNCTIVE OR EQUITABLE RELIEF REGARDING THE ENFORCEMENT OR VALIDITY OF YOUR OR afriexpressglobal."\'s" INTELLECTUAL PROPERTY RIGHTS. The term “dispute” means any dispute, action, or other controversy between you and afriexpressglobal concerning the Services or this agreement, whether in contract, warranty, tort, statute, regulation, ordinance, or any other legal or equitable basis. "Dispute" will be given the broadest possible meaning allowable under law.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Notice of Dispute',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'In the event of a dispute, you or afriexpressglobal must give the other a Notice of Dispute, which is a written statement that sets forth the name, address, and contact information of the party giving it, the facts giving rise to the dispute, and the relief requested. You must send any Notice of Dispute via email to: afriexpressglobal@aol.com. afriexpressglobal will send any Notice of Dispute to you by mail to your address if we have it, or otherwise to your email address. You and afriexpressglobal will attempt to resolve any dispute through informal negotiation within sixty (60) days from the date the Notice of Dispute is sent. After sixty (60) days, you or afriexpressglobal may commence arbitration.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Binding Arbitration',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'If you and afriexpressglobal don\'t resolve any dispute by informal negotiation, any other effort to resolve the dispute will be conducted exclusively by binding arbitration as described in this section. You are giving up the right to litigate (or participate in as a party or class member) all disputes in court before a judge or jury. The dispute shall be settled by binding arbitration in accordance with the commercial arbitration rules of the American Arbitration Association. Either party may seek any interim or preliminary injunctive relief from any court of competent jurisdiction, as necessary to protect the party\'s rights or property pending the completion of arbitration. Any and all legal, accounting, and other costs, fees, and expenses incurred by the prevailing party shall be borne by the non-prevailing party.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Submissions and Privacy',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'In the event that you submit or post any ideas, creative suggestions, designs, photographs, information, advertisements, data or proposals, including ideas for new or improved products, services, features, technologies or promotions, you expressly agree that such submissions will automatically be treated as non-confidential and non-proprietary and will become the sole property of afriexpressglobal without any compensation or credit to you whatsoever. afriexpressglobal and its affiliates shall have no obligations with respect to such submissions or posts and may use the ideas contained in such submissions or posts for any purposes in any medium in perpetuity, including, but not limited to, developing, manufacturing, and marketing products and services using such ideas.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Promotions',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'afriexpressglobal may, from time to time, include contests, promotions, sweepstakes, or other activities ("Promotions") that require you to submit material or information concerning yourself. Please note that all Promotions may be governed by separate rules that may contain certain eligibility requirements, such as restrictions as to age and geographic location. You are responsible to read all Promotions rules to determine whether or not you are eligible to participate. If you enter any Promotion, you agree to abide by and to comply with all Promotions Rules.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'Additional terms and conditions may apply to purchases of goods or services on or through the Services, which terms and conditions are made a part of this Agreement by this reference.',0,'L');
    $this->Ln(10);
    
    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Typographical Errors',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'In the event a product and/or service is listed at an incorrect price or with incorrect information due to typographical error, we shall have the right to refuse or cancel any orders placed for the product and/or service listed at the incorrect price. We shall have the right to refuse or cancel any such order whether or not the order has been confirmed and your credit card charged. If your credit card has already been charged for the purchase and your order is canceled, we shall immediately issue a credit to your credit card account or other payment account in the amount of the charge.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Miscellaneous',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'If for any reason a court of competent jurisdiction finds any provision or portion of these Terms & Conditions to be unenforceable, the remainder of these Terms & Conditions will continue in full force and effect. Any waiver of any provision of these Terms & Conditions will be effective only if in writing and signed by an authorized representative of afriexpressglobal. afriexpressglobal will be entitled to injunctive or other equitable relief (without the obligations of posting any bond or surety) in the event of any breach or anticipatory breach by you. afriexpressglobal operates and controls the afriexpressglobal Service from its offices in Liberia. The Service is not intended for distribution to or use by any person or entity in any jurisdiction or country where such distribution or use would be contrary to law or regulation. Accordingly, those persons who choose to access the afriexpressglobal Service from other locations do so on their own initiative and are solely responsible for compliance with local laws, if and to the extent local laws are applicable. These Terms & Conditions (which include and incorporate the afriexpressglobal Privacy Policy) contains the entire understanding, and supersedes all prior understandings, between you and afriexpressglobal concerning its subject matter, and cannot be changed or modified by you. The section headings used in this Agreement are for convenience only and will not be given any legal import.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Disclaimer',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'afriexpressglobal is not responsible for any content, code or any other imprecision.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'afriexpressglobal does not provide warranties or guarantees.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'In no event shall afriexpressglobal be liable for any special, direct, indirect, consequential, or incidental damages or any damages whatsoever, whether in an action of contract, negligence or other tort, arising out of or in connection with the use of the Service or the contents of the Service. afriexpressglobal reserves the right to make additions, deletions, or modifications to the contents on the Service at any time without prior notice.',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'The afriexpressglobal Service and its contents are provided "as is" and "as available" without any warranty or representations of any kind, whether express or implied. afriexpressglobal is a distributor and not a publisher of the content supplied by third parties; as such, afriexpressglobal exercises no editorial control over such content and makes no warranty or representation as to the accuracy, reliability or currency of any information, content, service or merchandise provided through or accessible via the afriexpressglobal Service. Without limiting the foregoing, afriexpressglobal specifically disclaims all warranties and representations in any content transmitted on or in connection with the afriexpressglobal Service or on sites that may appear as links on the afriexpressglobal Service, or in the products provided as a part of, or otherwise in connection with, the afriexpressglobal Service, including without limitation any warranties of merchantability, fitness for a particular purpose or non-infringement of third party rights. No oral advice or written information given by afriexpressglobal or any of its affiliates, employees, officers, directors, agents, or the like will create a warranty. Price and availability information is subject to change without notice. Without limiting the foregoing, afriexpressglobal does not warrant that the afriexpressglobal Service will be uninterrupted, uncorrupted, timely, or error-free.',0,'L');
    $this->Ln(10);

    $this->SetFont('arial','B', 13);
    $this->Cell(30,0,'Contact Us',0,0,'L');
    $this->Ln(5);
    $this->SetFont('Arial','', 8);
    $this->MultiCell(200,4,'Don\'t hesitate to contact us if you have any questions.',0,'L');
    $this->Ln(10);
    $this->MultiCell(200,4,'- Via Email: afriexpressglobal@aol.com',0,'L');
    $this->Ln(5);
    $this->MultiCell(200,4,'- Via Phone Number: +231775546511',0,'L');
    $this->Ln(5);
   
  }

}
  
$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->viewTable();
$pdf->Output();

 ?>
