<?php

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonFileProvider
     */
    public function testJsonFile($file)
    {
        $filePath = __DIR__ . '/../data/' . $file;

        $this->assertFileExists($filePath);

        $data = json_decode(file_get_contents($filePath), true);

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
        $this->assertGreaterThan(0, count($data));

        // Check data integrity.
        $keys = [];
        foreach ($data as $entry) {
            $this->assertArrayHasKey('key', $entry);
            $this->assertArrayHasKey('name', $entry);
            $this->assertNotContains($entry['key'], $keys, 'Key must be unique within the file.');
            $keys[] = $entry['key'];
        }
    }

    public function jsonFileProvider()
    {
        return [
            ['user-groups.json'],
            ['conferences.json'],
        ];
    }
}
