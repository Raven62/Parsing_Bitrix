
результат работы...<br>
<?
 $handle = fopen($_SERVER['DOCUMENT_ROOT']."/local/test.csv", "r"); // Подключение в переменную файла csv
 if ($handle) { // Если ли в файле значения
     $counter = 0; // счетчик
     $keys = array(); //массив 

     $data = array(); //массив 
     while (($buffer = fgets($handle)) !== false) { // пока прочитанная строка есть выполняем цикл
         $counter++; // шаг +1;
         $buffer = str_replace(array("\r\n", "\r", "\n"), '', $buffer); 
         $str =explode(";", $buffer); // делим строку разделитель ; 
         if ($counter==1){
             $keys = $str;
         }
         else{
             $el = array();
             foreach ($str as $key=>$item){ // ищем из массива 
                $el[$keys[$key]] = $item; // то чно не понимаю как это происходить. переменной el присваивем значение item с номером
             }
         $data[] = $el; // записываем элементы в массив дата
     }
 }
    if (!feof($handle)) { //если не достигнут конец файла выводим ошибку
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle); // Закрывает  файл
    
     
    CModule::IncludeModule("iblock"); // подключение информационных блоков
    
    foreach ($data as $key=>$el){
        $bs = new CIBlockElement; // создание экземпляра класса CIBlockElement
        $PROP = array(); // создание массива свойств
        $PROP["prop1"] = $el["prop1"]; 
        $PROP["prop2"] = $el["prop2"];

        $arFields = Array( // массив с заполниными данными для инфо блока
        "IBLOCK_ID" => 7,
        "NAME" => $el["name"],
        "XML_ID" => $el["id"],
        "PREVIEW_TEXT" => $el["preview_text"],
        "DETAIL_TEXT" => $el["detail_text"],
        "PROPERTY_VALUES"=> $PROP,
        );
        

        if($PRODUCT_ID = $bs->Add($arFields)) // добовление файла в инфоблок
        {
            echo 'New ID: '.$PRODUCT_ID.'<br>'; //вывод id
        }
        else
        {
            echo '.Error: '.$bs->LAST_ERROR.'<br>'; // вывод ошибки
        }
    }
    }
 
?>