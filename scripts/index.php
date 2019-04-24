<?php 
require __DIR__ . '/../vendor/autoload.php';

use League\Csv\Reader;
use League\Csv\Statement;

$pathData = pathinfo($argv[1]);


if(file_exists($argv[1])){
    if($pathData["extension"] !== "csv") {
        echo "ERROR : csvファイルを選択してください。";
        exit;
    }

    $csv = Reader::createFromPath($argv[1], 'r');
    $csv->setHeaderOffset(0);
    
    $records = $csv->getRecords();
    $list = array();
    foreach ($records as $key=>$record) {
        $record['category'] = array(
            $record['category']
        );
        $list["list"][] = $record;
    }
    $list = array($list);

    $json = json_encode($list, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    // var_dump($json);
    
    $jsonFilePath = __DIR__. "/../json/". $pathData["filename"]. ".json";
    touch($jsonFilePath);
    $jsonFile = fopen($jsonFilePath, "w");
    @fwrite($jsonFile, $json);
    fclose($jsonFile);

    echo "SUCCESS : jsonファイルへの変換に成功しました!";
}else{
    echo "ERROR : ファイルへのパスが間違っているか、ファイルが存在していません。";
}