<?php
if(isset($_FILES['pdf'])) {
    $tmpName = $_FILES['pdf']['tmp_name'];

    // OCR.spaceのAPI URL
    $url = 'https://api.ocr.space/parse/image';

    // APIキー（OCR.spaceで取得）
    $apiKey = 'your_api_key_here'; 

    // cURLセッションの初期化
    $ch = curl_init($url);

    // curlのオプション設定
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('apikey: ' . $apiKey));

    // PDFファイルを読み込み、POSTデータとして設定
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('file' => new CURLFile($tmpName)));
    
    // OCR.space APIへリクエストを送信し、結果を取得
    $result = curl_exec($ch);

    // curlセッションを閉じる
    curl_close($ch);

    if($result === false) {
        die('Error occurred: ' . curl_error($ch));
    }

    // 結果を解析
    $ocrResult = json_decode($result, true);

    // テキストを表示
    echo '<h1>OCR Result:</h1>';
    echo '<p>' . $ocrResult['ParsedResults'][0]['ParsedText'] . '</p>';
}
?>
