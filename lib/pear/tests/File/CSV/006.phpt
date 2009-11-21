--TEST--
File_CSV Test Case 006: One field quote autodiscovery
--FILE--
<?php
// $Id: 006.phpt,v 1.1 2005/05/21 06:26:48 dufuz Exp $
/**
 * Test for:
 * - File_CSV::discoverFormat()
 */

require_once 'File/CSV.php';

$file = '006.csv';
$conf = File_CSV::discoverFormat($file);

print "Format:\n";
print_r($conf);
print "\n";
?>
--EXPECT--
Format:
Array
(
    [fields] => 1
    [sep] => ,
    [quote] => "
)
