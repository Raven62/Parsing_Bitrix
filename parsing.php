
результат работы...<br>
<?php

 $handle = fopen($_SERVER['DOCUMENT_ROOT']."/local/test.csv", "r");
 if ($handle) {
     $counter = 0;
     $keys = array();
     $data = array();
     while (($buffer = fgets($handle)) !== false) {
         $counter++; 
         $buffer = str_replace(array("\r\n", "\r", "\n"), '', $buffer); 
         $str =explode(";", $buffer);
         if ($counter==1){
             $keys = $str;
         }
         else{
             $el = array();
             foreach ($str as $key=>$item){
                $el[$keys[$key]] = $item;
             }
         $data[] = $el;
     }
 }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
    
     
    CModule::IncludeModule("iblock");
    
    foreach ($data as $key=>$el)
    {
        
        $y = false;
       

        $bs = new CIBlockElement;
        $arFilter = array(
            "IBLOCK_ID" => 7,
        );

        $res = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID','NAME','XML_ID'));

        while ($element = $res->GetNext()) {
            
            
            if($el['name'] == $element['NAME']) 
            {
            
               // echo 'Элемент CSV - '.$el['name'].' '.'Элемент блока - '.$element['NAME'].'<br>';
             $y = true;
              break;

            }
            
            
        }


        $PROP = array();
        $PROP["prop1"] = $el["prop1"]; 
        $PROP["prop2"] = $el["prop2"];

        $arFields = Array(
        "IBLOCK_ID" => 7,
        "NAME" => $el["name"],
        "XML_ID" => $el["id"],
        "PREVIEW_TEXT" => $el["preview_text"],
        "DETAIL_TEXT" => $el["detail_text"],
        "PROPERTY_VALUES"=> $PROP,
        );

        if ($y == false)
        {
           if($PRODUCT_ID = $bs->Add($arFields))
           {
           echo $key.'.New ID: '.$PRODUCT_ID.'(XML_ID = cmt_'.$el['id'].')<br>';
           }
           else
           {
            echo $key.'.Error: '.$bs->LAST_ERROR.'<br>';
           }

        }
         

      
        
        
        

     
    }
}

