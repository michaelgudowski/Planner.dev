<?php

require_once'filestore.php';

class AddressDataStore extends Filestore
{
     public $filename = '';

     public $class = '';

    function __construct ($filename = "address_book.csv")
	{	//making the file have all lower case characters
		$filename = strtolower($filename);
		//over riding the above contruct
        parent::__construct($filename);

	}

 	function checkfile($isCSV)
 	{

 	}
}

