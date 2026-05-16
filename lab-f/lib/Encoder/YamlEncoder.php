<?php
namespace App\Encoder;
class YamlEncoder
{
public function encode(array $data) : string{
    return yaml_emit($data);
}
public function decode(string $data) : array{
    return yaml_parse($data) ?: [];
}
}