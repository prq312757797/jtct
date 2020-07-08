<?php

include_once "wxBizDataCrypt.php";









$pc = new WXBizDataCrypt();
$errCode = $pc->decryptData( $data );

if ($errCode == 0) {
    print($data . "\n");
} else {
    print($errCode . "\n");
}
