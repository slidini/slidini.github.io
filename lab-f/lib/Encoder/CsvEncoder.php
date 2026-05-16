<?php
namespace App\Encoder;
class CsvEncoder
{
public function encode(array $data) : string{
    if(array_is_list($data)){
        return implode(",", $data);
    }
    return implode(",", array_keys($data));
}
public function decode(string $data) : array{
    return str_getcsv($data, ",", "\"", "\\");
}
}