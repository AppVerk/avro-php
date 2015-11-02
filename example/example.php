#!/usr/bin/env php
<?php



require_once('../lib/avro.php');
// Write and read a data file
$writers_schema_json = <<<_JSON
{"name":"member",
 "type":"record",
 "fields":[{"name":"member_id", "type":"int"},
           {"name":"member_name", "type":"string"}]}
_JSON;
$jose = array('member_id' => 1392, 'member_name' => 'Jose');
$maria = array('member_id' => 1642, 'member_name' => 'Maria');
$data = array($jose, $maria);




$metadata = array();
$metadata['messageId'] = '20';
$metadata['messageName'] = 'messagename';


$avroDataIO = new AvroDataIO();
$schema = AvroSchema::parse($writers_schema_json);
$io = new AvroStringIO();
$datum_writer = new AvroIODatumWriter($schema);
 
$writer = new AvroDataIOWriter($io,$datum_writer,$schema,$metadata);

foreach ($data as $datum)
	$writer->append($datum);
$writer->close();
	 
$buffer = $io->string();

var_dump($buffer);
	
	