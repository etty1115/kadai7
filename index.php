
    <?php

// OCR.space APIを呼び出すための関数
function ocr_space($filePath, $overlay = false, $language = 'jpn') {
    $url = 'https://api.ocr.space/parse/image';
    $apiKey = 'xxxxxxxxxxxxxxxx'; // OCR.spaceから取得したAPIキーを入力してください。

    $data = [
        'language' => $language,
        'isOverlayRequired' => $overlay,
        'file' => new CurlFile($filePath),
        'apikey' => $apiKey
    ];

    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_SSL_VERIFYPEER => false
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    if(curl_errno($ch)){
        throw new Exception(curl_error($ch));
    }
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode != 200) {
        throw new Exception('Error in the OCR API. Status:' . $statusCode);
    }

    return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tmpPath = $_FILES['pdf_file']['tmp_name'];

    try {
        // OCR.space API呼び出し
        $ocrResult = ocr_space($tmpPath);

        // OCR結果を表示
        echo nl2br($ocrResult);

    } catch (Exception $e) {
        echo 'Error: ',  $e->getMessage(), "\n";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="pdf_file" accept=".pdf" required>
        <input type="submit" value="Upload PDF">
    </form>
</body>
</html>
