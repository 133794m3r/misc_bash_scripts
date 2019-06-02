#!/bin/php
$goal string='{"showpassword":"no","bgcolor":"#fffffe"}'
$cipher_string=base64_decode('ClVLIh4ASCsCBE8lAxMacFMZV2hdVVotEhhUJQNVAmhSEV4sFxFdaAw=')
function xor_decrypt($enciphered,$deciphered) {
    $text = $enciphered;
    $outText = '';
    $key = $deciphered;
    // Iterate through each character
    for($i=0;$i<strlen($text);$i++) {
    $outText .= $text[$i] ^ $key[$i % strlen($key)];
    }

    return $outText;
}
echo xor_decrypt(cipher_string,$goal_string).PHP_EOL;
