<?php
$json = '{"książki": [{"tytuł": "T1","liczba_stron": 10,"dostępna": false}, {"tytuł": "T2","liczba_stron": 50,"dostępna": true} ]}';
$var = json_decode($json);
var_dump($json);
var_dump($var);

var_dump($var->książki[0]->liczba_stron);

$dane = ['książki' => [['title' => 'T1', 'liczba_stron' => 12], ['title' => 'T2', 'liczba_stron' => 12]]];
var_dump($dane);
var_dump(json_encode($dane));
