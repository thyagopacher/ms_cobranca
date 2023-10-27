<?php

use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{
    /**
     * testConversionStringToArray
     *
     * @return void
     */
    public function testConversionStringToArray()
    {
        $filePath = '653a6d8846fa7.csv';

        // Use the Storage facade to read the CSV file.
        $contents = Storage::disk('local')->get($filePath);
        $lines = explode("\n", $contents);

        $this->assertEquals(
            true, is_array($lines)
        );
    }
}
