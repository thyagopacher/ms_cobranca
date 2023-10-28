<?php

use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{

    public function testFileExists(){
        $exists = Storage::disk('local')->exists('file.jpg');
        $this->assertEquals(
            false, $exists
        );
    }

    /**
     * testConversionStringToArray
     *
     * @return void
     */
    public function testConversionStringToArray()
    {
        
        $filePath = 'arquivo_cobranca.csv';
        $exists = Storage::disk('local')->exists($filePath);

        if(!$exists){
            throw new Exception('Arquivo do teste não existe, por favor selecionar outro');
        }
        // Use the Storage facade to read the CSV file.
        $contents = Storage::disk('local')->get($filePath);
        $lines = explode("\n", $contents);

        $this->assertEquals(
            true, is_array($lines)
        );
    }
}
