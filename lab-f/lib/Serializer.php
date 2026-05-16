<?php
namespace App;
use App\Encoder\CsvEncoder;
use App\Encoder\JsonEncoder;
use App\Encoder\YamlEncoder;
class Serializer
{
    public function serialize(array $data, string $format){
        switch ($format) {
            case 'JSON':
                $encoder = new JsonEncoder();
                return $encoder->encode($data);
            case 'TSV':
                return implode("\t", $data);
            case 'SSV':
                return implode(" ", $data);
            case 'CSV':
                $encoder = new CsvEncoder();
                return $encoder->encode($data);
            case 'YAML':
                $encoder = new YamlEncoder();
                return $encoder->encode($data);
            default:
                return [$data];
        }
    }

    public function deserialize(string $data, string $format){
        $trimmedData = trim($data);
        switch ($format) {
            case 'JSON':
                $decoder = new JsonEncoder();
                return $decoder->decode($data);
            case 'TSV':
                return explode("\t", $trimmedData);
            case 'SSV':
                return explode(" ", $trimmedData);
            case 'CSV':
                $decoder = new CsvEncoder();
                return $decoder->decode($data);
            case 'YAML':
                $decoder = new YamlEncoder();
                return $decoder->decode($data);
            default:
                return [$data];
        }
    }
}