<?php
// $Id$

require_once dirname(__FILE__) . '/Wrapper_AMFSerializer.php';


$oAMFSerializer = new Wrapper_AMFSerializer();

// The empty string has a special encoding (Adobe calls it "UTF-8-empty").
// This method is not supposed to output the value type.

// "UTF-8-empty" (0x01)

$oAMFSerializer->writeAmf3String('', FALSE);

if ($oAMFSerializer->outBuffer !== "\1") {
    echo 'Failed at line ' . __LINE__ . '!' . "\n";
}

$oAMFSerializer = new Wrapper_AMFSerializer();

// The string is seen for the first time. So no reference can be used.
// This method is not supposed to output the value type.

// "U29S-value" (15 << 1 | 1 = 0x1f)
// "This is a test!"

$oAMFSerializer->writeAmf3String('This is a test!', FALSE);

if ($oAMFSerializer->outBuffer !== pack('C', 31) . 'This is a test!') {
    echo 'Failed at line ' . __LINE__ . '!' . "\n";
}

$oAMFSerializer = new Wrapper_AMFSerializer();

// The string is added twice. It first is added as value,
// the second time it should be added as reference.
// This method is not supposed to output the value type.

// "U29S-value" (15 << 1 | 1 = 0x1f)
// "This is a test!"
// "U29S-ref" for lookup table index 0) (0 << 1 = 0x00)

$oAMFSerializer->writeAmf3String('This is a test!', FALSE);
$oAMFSerializer->writeAmf3String('This is a test!', FALSE);

if ($oAMFSerializer->outBuffer !== pack('C', 31) . 'This is a test!' . pack('C', 0)) {
    echo 'Failed at line ' . __LINE__ . '!' . "\n";
}
?>