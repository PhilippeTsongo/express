<?php
class AddressController
{

	
	
    public static function getProvinces()
        {  
             $provinceTable=new \User();
                $provinceTable->selectQuery("SELECT  id as province_id, name as province_name,kinyarwanda_name as intara   FROM val_province  order by id asc");
                if( $provinceTable->count()) 
                    return  $provinceTable->data();
                else 
                    return false ;
        }


    public static function getDistrictByProvince($provinceId)
    {  
      
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  ussd_id as service_id, name as district_name   FROM val_district  where  province_id={$provinceId}  order by  ussd_id asc");
            if( $districtTable->count()) 
                return  $districtTable->data();
            else 
                return false ;
    }


    public static function getDistrictID($ussd_id,$provinceId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT id   FROM val_district  where  province_id={$provinceId} and ussd_id={$ussd_id} ");
            if( $districtTable->count()) 
                return  $districtTable->first()->id;
            else 
                return false ;
    }



    public static function getDistrictCountByProvince($provinceId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  count(ussd_id) as total FROM val_district  where  province_id={$provinceId} ");
            if( $districtTable->count()) 
                return  $districtTable->first()->total;
            else 
                return 0 ;
    }



    public static function getSectorsByDistrictId($districtId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  ussd_id as service_id, name as sector_name  FROM val_sector  where  district_id={$districtId}  order by  ussd_id asc");
            if( $districtTable->count()) 
                return  $districtTable->data();
            else 
                return false ;
    }




    public static function getSectorsId($ussd_id,$districtId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  id  FROM val_sector  where  district_id={$districtId}   and ussd_id={$ussd_id}");
            if( $districtTable->count()) 
                return  $districtTable->first()->id;
            else 
                return 0 ;
    }


    public static function getSectorsCountByDistrictId($districtId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT count(ussd_id) as total  FROM val_sector  where  district_id={$districtId} ");
            if( $districtTable->count()) 
                return  $districtTable->first()->total;
            else 
                return 0 ;
    }

    
    public static function getCellsBySectorId($sectorId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  ussd_id as service_id, name as cell_name  FROM val_cell  where  sector_id={$sectorId}  order by  ussd_id asc");
            if( $districtTable->count()) 
                return  $districtTable->data();
            else 
                return false ;
    }



    public static function getCellsId($ussd_id, $sectorId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  id  FROM val_cell  where  sector_id={$sectorId}  and ussd_id={$ussd_id} ");
            if( $districtTable->count()) 
                return  $districtTable->first()->id;
            else 
                return false ;
    }


    public static function getCellsCountBySectorId($sectorId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  count(ussd_id)  as total FROM val_cell  where  sector_id={$sectorId} ");
            if( $districtTable->count()) 
                return  $districtTable->first()->total;
            else 
                return false ;
    }



    


    public static function getVillagedByCellId($cellId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  ussd_id as service_id, name as village_name  FROM val_village  where  cell_id={$cellId}  order by  ussd_id asc");
            if( $districtTable->count()) 
                return  $districtTable->data();
            else 
                return false ;
    }


    public static function getVillagedId($ussd_id,$cellId)
    {  
      
        
    
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  id   FROM val_village  where  cell_id={$cellId} and ussd_id={$ussd_id} ");
            if( $districtTable->count()) 
                return  $districtTable->first()->id;
            else 
                return false ;
    }


    public static function getVillageCountByCellId($cellId)
    {  
      
            $districtTable=new \User();
            $districtTable->selectQuery("SELECT  count(ussd_id)  as total  FROM val_village  where  cell_id={$cellId} ");
            if( $districtTable->count()) 
                return  $districtTable->first()->total;
            else 
                return 0 ;
    }

    public static function getUserFullAddress($qr_code){
        $districtTable=new \User();
        $districtTable->selectQuery("SELECT  (SELECT val_province.name   FROM val_province  where  val_province.id = ussd_user.province_id) as province,  (SELECT  val_province.kinyarwanda_name   FROM val_province  where  val_province.id=ussd_user.province_id) as intara,    (SELECT  val_district.name   FROM val_district  where  val_district.id=ussd_user.district_id) as district,  (SELECT  val_sector.name   FROM val_sector  where  val_sector.id=ussd_user.sector_id) as sector,   (SELECT  val_cell.name   FROM val_cell  where  val_cell.id=ussd_user.cell_id) as cell from  ussd_user where qr_ID='{$qr_code}' ");
        if( $districtTable->count()) 
            return  $districtTable->first();
        else 
            return false ;

    }


    public static function getProvinceIdByProvinceName($provinceName){
        $provinceTable = new \User();
        $provinceTable->selectQuery("SELECT * FROM val_province WHERE name =? LIMIT 1", Array($provinceName));
        if($provinceTable->count())
            return $provinceTable->first()->id;
        else
            return 0;
    }
       
    public static function getDistrictIdByDistrictName($districtName, $provinceID){
        $districtTable = new \User();
        $districtTable->selectQuery("SELECT * FROM val_district WHERE name =? AND province_id =? LIMIT 1", Array($districtName, $provinceID));
        if($districtTable->count())
            return $districtTable->first()->id;
        else
            return 0;
    }

    public static function getSectorIdBySectorName($sectorName, $districtID){
        $sectorTable = new \User();
        $sectorTable->selectQuery("SELECT * FROM val_sector WHERE name =? AND district_id =? LIMIT 1", Array($sectorName, $districtID));
        if($sectorTable->count())
            return $sectorTable->first()->id;
        else
            return 0;
    }

    public static function getCellIdByCellName($cellName, $sectorID){
        $cellTable = new \User();
        $cellTable->selectQuery("SELECT * FROM val_cell WHERE name =? AND sector_id =? LIMIT 1", Array($cellName, $sectorID));
        if($cellTable->count())
            return $cellTable->first()->id;
        else
            return 0;
    }

    public static function getVillageIdByVillageName($villageName, $cellID){
        $villageTable = new \User();
        $villageTable->selectQuery("SELECT * FROM val_village WHERE name =? AND cell_id =? LIMIT 1", Array($villageName, $cellID));
        if($villageTable->count())
            return $villageTable->first()->id;
        else
            return 0;
    }
                   



	
	
	

}