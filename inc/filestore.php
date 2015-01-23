<?php

 class Filestore
 {
     public $filename = '';
     public $class = '';
     protected $isCSV = false;
     protected $isTXT = false;

     function __construct($filename)
     {
         // Sets $this->filename
          $this->filename = $filename;

          if(!file_exists($filename))
          {
            touch ($filename);
          }
          if(substr($filename,-3) == 'csv')
          {
            $this->isCSV = true;
          }
          else if(substr($filename,-3) == 'txt')
          {
            $this->isTXT = true;
          }
      }     


     /**
      * Returns array of lines in $this->filename
      */

     /**
      * Writes each element in $array to a new line in $this->filename
      */
     /**
      * Reads contents of csv $this->filename, returns an array
      */
     public function read()
     {
        if($this->isCSV)
        {
            return $this->readCSV();
        }
        else{
           return $this->readTXT();
        }
     }  

     public function write($array)
     {
      
        if($this->isCSV)
        {
            $this->writeCSV($array);
        }
        else{
            $this->writeTXT($array);
        }
     } 

     private function readCSV()
     {
      $handle = fopen($this->filename, 'r');

          $addressBook = [];

          while (!feof($handle))
          {
              $row = fgetcsv($handle);

              if (!empty($row)) 
              {
               $addressBook[] = $row;
              }
          }
          fclose($handle);        
        // else
        // {
        //     $addressBook = [];
        // }
        return $addressBook;
        }
     /**
      * Writes contents of $array to csv $this->filename
      */
     private function writeCSV($array)
     {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $row) {
            fputcsv($handle, $row);
        }
          fclose($handle);
    }
    private function readTXT()
    {
        $handle = fopen($this->filename, 'r');
       
       if (filesize($this->filename) > 0) {
            $contents = trim(fread($handle, filesize($this->filename)));
            $this->todoarray = explode("\n", $contents);
        } else {
            $this->todoarray = [];
        }
            fclose($handle);

            return $this->todoarray;
    }
     private function writeTXT($array)
     {              
            $handle = fopen($this->filename, 'w');

            foreach ($array as $row) {
                fwrite($handle, PHP_EOL . $row);
            }

            fclose($handle);

    }
}