<?php 
$options = [
    'cost' => 12,
];
echo password_hash("mandymorenn", PASSWORD_BCRYPT, $options);
echo "<br>";
echo date('U');
?>