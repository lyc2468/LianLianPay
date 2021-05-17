<?php

namespace Skies\LianLianPay\Objects;


abstract class ObjectBase
{
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function toArray(): array
    {
        $attrs = (array) $this;
        $array = [];
        foreach ($attrs as $key => $attr) {
            if (!empty($attr)) {
                $arrayKey = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $key));
                if (is_array($attr)) {
                    $arrayValue = [];
                    foreach ($attr as $value) {
                        if ($value instanceof ObjectBase) {
                            $arrayValue[] = $value->toArray();
                        }
                    }
                } elseif ($attr instanceof ObjectBase) {
                    $arrayValue = $attr->toArray();
                } else {
                    $arrayValue = $attr;
                }
                $array[$arrayKey] = $arrayValue;
            }
        }
        return $array;
    }
}
