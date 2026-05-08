<?php
header('Content-Type: application/json');
include '../config/db.php'; 

function slugify($text){
    $text= iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text=strtolower(trim($text));
    $text=preg_replace('/[^a-z0-9]+/', '-',$text); // remplace les espaces et caracteres preciaux par -
    return trim($text,'-');
}

$services= $pdo->query("SELECT id, title FROM services ORDER BY id ASC ")->fetchAll(PDO::FETCH_ASSOC);
foreach ($services as &$s) {
    $s['slug']=slugify($s['title']);
}
echo json_encode($services);
?>
