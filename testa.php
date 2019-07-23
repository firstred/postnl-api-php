<?php

use Firstred\PostNL\Entity\Contact;

require __DIR__.'/vendor/autoload.php';

$contact = new Contact();
$contact->setTelNr('0643908172');

var_dump($contact);
exit;
