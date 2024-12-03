<?php

namespace Dragon\Support;

class Csv {
    public $headers = [];
    public $rows = [];
    
    private $filename = null;
    private $csvMimes = [
        'application/vnd.ms-excel',
        'text/plain',
        'text/csv',
        'text/tsv',
    ];
    
    public function __construct(?string $filename = null) {
        $this->filename = $filename;
        
        if ($filename !== null && $this->isCsv()) {
            $this->parse();
        }
    }
    
    public function isCsv() : bool {
    	if (!in_array(mime_content_type((string)$this->filename), $this->csvMimes)) {
            return false;
        }
        
        return true;
    }
    
    public function download(string $filename) {
        ob_clean();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);
        
        $fp = fopen('php://output', 'w');
        fputcsv($fp, $this->headers);
        
        foreach ($this->rows as $row) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);
        exit;
    }
    
    private function parse() {
        $handle = fopen($this->filename, "r");
        if ($handle !== false) {
            
            while (($data = fgetcsv($handle)) !== false) {
                
                if (empty($this->headers)) {
                    $this->headers = $data;
                } else {
                    $this->rows[] = $data;
                }
                
            }
            
            fclose($handle);
            
        }
    }
}
