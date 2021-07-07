
результат работы...<br>
<?
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
    
    foreach ($data as $key=>$el){
        $bs = new CIBlockElement;
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
        $res = CIBlockElement::GetByID($el["id"]);

        if($PRODUCT_ID = $bs->Add($arFields))
        {
            echo 'New ID: '.$PRODUCT_ID.'<br>';
        }
        else
        {
            echo '.Error: '.$bs->LAST_ERROR.'<br>';
        }
    }
    }
 
?>