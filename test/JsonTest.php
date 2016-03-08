<?php

class JsonTest extends PHPUnit_Framework_TestCase
{
    public function testJson()
    {
        $filePath = dirname(__FILE__) . '/../user-groups.json';

        $this->assertFileExists($filePath);

        $data = json_decode(file_get_contents($filePath), true);

        $this->assertGreaterThan(0, count($data));
    }
}
