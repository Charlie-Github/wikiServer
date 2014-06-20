<?php
// The data to send to the API
$postData = array(
    'action' => 'login',
    'email' => 'edibleinnovationsllc@gmail.com',
    'pwd' => 'edibl'
);


$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => "Content-Type: application/json\r\n",
        'content' => json_encode($postData)
    )
);





// Create the context for the request
$context = stream_context_create($pots);




// Send the request
$response = file_get_contents('http://default-environment-9hfbefpjmu.elasticbeanstalk.com/user', FALSE, $context);


var_dump($response);

// Decode the response
$responseData = json_decode($response, TRUE);



?>