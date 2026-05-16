<?php
namespace App\Encoder;
class JsonEncoder
{
public function encode(array $data) : string{
    return json_encode($data, JSON_PRETTY_PRINT);
}
public function decode(string $data) : array{
    return json_decode($data, true) ?? [];
}
}