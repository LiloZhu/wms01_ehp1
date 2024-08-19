<?php

namespace components\barcode\Types;

use components\barcode\Barcode;

interface TypeInterface
{
    public function getBarcodeData(string $code): Barcode;
}
