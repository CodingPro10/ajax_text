<?php

switch($_SERVER['REQUEST_METHOD']){
    case 'GET': {
        echo json_encode([rand(0,9),rand(0,9),rand(0,9)]);
    } break;
    case 'PUT': {
        echo json_encode([rand(10,99),rand(10,99),rand(10,99)]);
    } break;
    case 'DELETE': {
        echo json_encode([rand(100,999),rand(100,999),rand(100,999)]);
    } break;
}
