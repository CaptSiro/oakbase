<?php

namespace OakBase;

require_once __DIR__ . "/parameter/NamedPrimitiveParam.php";

function param(mixed $value): PrimitiveParam {
    return new PrimitiveParam($value);
}