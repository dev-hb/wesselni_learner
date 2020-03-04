<?php


class File {

    protected $file;

    public function __construct($file){
        $this->file = $file;
    }

    public function read(){
        $lines = "";
        $fh = fopen($this->file, 'r');
        while ($line = fgets($fh)) {
            $lines .= $line;
        }
        fclose($fh);
        return $lines;
    }

}