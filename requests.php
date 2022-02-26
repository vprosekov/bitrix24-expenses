<?php
require_once "include/utils.php"; //подключение бд
$webhookaddress = '';
// if isset request
if (isset($_REQUEST['request'])) {
    if ($_REQUEST['request'] === "update_total_outcome") {
        if (isset($_REQUEST['deal_id']) && isset($_REQUEST['total_outcome'])) {
            $deal_id = $_REQUEST['deal_id'];
            $total_outcome = $_REQUEST['total_outcome'];

            $tresponse = updateTotalOutcome($webhookaddress, $deal_id, $total_outcome);
            if ($tresponse !== false) {
                echo json_encode($tresponse);
            } else {
                echo '{"result":false}';
                exit();
            }
        }
    } else {
        echo '{"result":false}';
        exit();
    }
} else {
    echo '{"result":false}';
    exit();
}
