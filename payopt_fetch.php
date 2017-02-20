<?php

$final_data = "command=getJsonData&access_code=AVRD64DC49BL53DRLB&currency=INR&amount=500000";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://secure.ccavenue.com/transaction/transaction.do");
curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_REFERER, "http://www.yagotimber.com/");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//$result = curl_exec($ch);
//print($result);

$result['EXE'] = curl_exec($ch);
$result['INF'] = curl_getinfo($ch);
$result['ERR'] = curl_error($ch);
curl_close($ch);
echo '<pre>'; print_r($result);
die;


?>
</body>
</html>

