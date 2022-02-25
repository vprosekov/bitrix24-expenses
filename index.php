<?php
$webhookaddress = 'https://testservice.bitrix24.ru/rest/1/vaqlkz463f8ql04z/';

require_once "include/dbconnect.php"; //подключение бд
require_once "models/outcomes.php"; //подключение вспомогательных функций
function out($var, $var_name = '')
{
    echo '<pre style="outline: 1px dashed 
                red;padding:5px;margin:10px;color:white;background:black;">';
    if (!empty($var_name)) {
        echo '<hr3>' . $var_name . '</h3>';
    }
    if (is_string($var)) {
        $var = htmlspecialchars($var);
    }
    print_r($var);
    echo '</pre>';
}

function sendQuery($method, $params)
{
    global $webhookaddress;
    $queryUrl = $webhookaddress . $method . '.json';
    $queryData = http_build_query($params);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = json_decode(curl_exec($curl), true);
    curl_close($curl);
    return $result;
}

$is_deal_opened = false;
$opened_deal_id = '';
$domain = '';

// check if request DOMAIN set
if (isset($_REQUEST['DOMAIN'])) {
    $domain = $_REQUEST['DOMAIN'];
}
out($_REQUEST);

if ($domain !== '' && isset($_REQUEST['PLACEMENT']) && $_REQUEST['PLACEMENT'] == 'CRM_DEAL_DETAIL_TAB' && isset($_REQUEST['PLACEMENT_OPTIONS'])) {
    $is_deal_opened = true;
    $opened_deal_id = json_decode($_REQUEST['PLACEMENT_OPTIONS'])->ID;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Затраты сделки</title>
        <!-- jquery script src -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="js/1.js"></script>

    </head>

    <body>
        <p hidden id="opened_deal_id"><?=$opened_deal_id?></p>
        <input type="number" name="total_outcome" id="total_outcome" min="0">
        <button id="change_total_outcomes">Обновить общие затраты</button>
        <pre id="responsepre" style="outline: 1px dashed 
                red;padding:5px;margin:10px;color:white;background:black;">
        </pre>
    </body>

    </html>
<?php
}
require_once "include/scriptclose.php"; //закрывает текущую сессию подключения с бд
