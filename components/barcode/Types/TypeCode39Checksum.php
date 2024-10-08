<?php

namespace components\barcode\Types;

/*
 * CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
 * General-purpose code in very wide use world-wide
 */

class TypeCode39Checksum extends TypeCode39
{
    protected $extended = false;
    protected $checksum = true;
}
