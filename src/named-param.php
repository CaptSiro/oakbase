<?php

namespace OakBase;

function named_param(string $name, mixed $value): NamedPrimitiveParam {
    return new NamedPrimitiveParam($name, $value);
}