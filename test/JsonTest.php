<?php

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonFileProvider
     */
    public function testJsonFile($file)
    {
        $filePath = dirname(__FILE__) . '/../data/' . $file;

        $this->assertFileExists($filePath);

        $data = json_decode(file_get_contents($filePath), true);

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
        $this->assertGreaterThan(0, count($data));
    }

    public function jsonFileProvider()
    {
        return [
            ['user-groups.json'],
            ['conferences.json'],
        ];
    }
}
