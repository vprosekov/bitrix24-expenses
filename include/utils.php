<?php

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
// function sendQuery($method, $params)
// {
//     $queryUrl = 'https://' . $_REQUEST['DOMAIN'] . '/rest/' . $method . '.json';
//     $queryData = http_build_query(array_merge($params, array("auth" => $_REQUEST['AUTH_ID'])));

//     $curl = curl_init();
//     curl_setopt_array($curl, array(
//         CURLOPT_SSL_VERIFYPEER => 0,
//         CURLOPT_POST => 1,
//         CURLOPT_HEADER => 0,
//         CURLOPT_RETURNTRANSFER => 1,
//         CURLOPT_URL => $queryUrl,
//         CURLOPT_POSTFIELDS => $queryData,
//     ));

//     $result = json_decode(curl_exec($curl), true);
//     curl_close($curl);
//     return $result;
// }
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
// if isset request
if (isset($_REQUEST['request'])) {
    if ($_REQUEST['request'] === "update_total_outcome") {
        if (isset($_REQUEST['deal_id']) && isset($_REQUEST['total_outcome'])) {
            $deal_id = $_REQUEST['deal_id'];
            $total_outcome = $_REQUEST['total_outcome'];

            $response = sendQuery('crm.deal.update', ['id' => $deal_id, 'fields' => ['UF_CRM_1645710698211' => "{$total_outcome}|RUB"]]);
            // out($response);
            if (!isset($response['result'])) {
                echo '{"result":false}';
                exit();
            }
            // out $response as json object
            echo(json_encode($response));
        }
    } else {
        echo '{"result":false}';
        exit();
    }
} else {
    echo '{"result":false}';
    exit();
}
