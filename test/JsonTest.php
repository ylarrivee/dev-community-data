<?php

class JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonFileProvider
     */
    public function testJsonFiles($file)
    {
        $filePath = __DIR__ . '/../data/' . $file;

        $this->assertFileExists($filePath);

        $data = json_decode(file_get_contents($filePath), true);

        $this->assertEquals(JSON_ERROR_NONE, json_last_error(), 'File "'.$file.'" must be a valid JSON');
        $this->assertGreaterThan(0, count($data));
    }


    public function testTagsJson()
    {
        $data = $this->loadJsonFile('tags.json');
    }

    /**
     * @depends testJsonFiles
     */
    public function testConferencesJson()
    {
        $data = $this->loadJsonFile('conferences.json');
        $validTags = $this->flattenHierarchy($this->loadJsonFile('tags.json'));

        // Check data integrity.
        $keys = [];
        foreach ($data as $i => $entry) {
            $this->assertArrayHasKey('key', $entry, 'Entry #'.$i);
            $this->assertArrayHasKey('name', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('first_event', $entry, 'Entry '.$entry['key']);
            $this->assertNotContains($entry['key'], $keys, 'Key must be unique within the file.');
            $this->assertValidTags($entry['tags'], $validTags);
            $keys[] = $entry['key'];
        }
    }

    /**
     * @depends testJsonFiles
     */
    public function testUserGroupsJson()
    {
        $data = $this->loadJsonFile('user-groups.json');
        $validTags = $this->flattenHierarchy($this->loadJsonFile('tags.json'));

        // Check data integrity.
        $keys = [];
        foreach ($data as $i => $entry) {
            $this->assertArrayHasKey('key', $entry, 'Entry #'.$i);
            $this->assertArrayHasKey('name', $entry, 'Entry '.$entry['key']);
            $this->assertArrayHasKey('first_event', $entry, 'Entry '.$entry['key']);
            $this->assertNotContains($entry['key'], $keys, 'Key must be unique within the file.');
            $this->assertValidTags($entry['tags'], $validTags);
            $keys[] = $entry['key'];
        }
    }

    private function loadJsonFile($file)
    {
        $filePath = __DIR__ . '/../data/' . $file;
        $data = json_decode(file_get_contents($filePath), true);
        return $data;
    }

    public function flattenHierarchy($hierarchy)
    {
        $flatArray = [];
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($hierarchy), RecursiveIteratorIterator::SELF_FIRST) as $key => $value) {
            $flatArray[] = $key;
        }
        $flatArray = array_unique($flatArray);
        return $flatArray;
    }

    public function assertValidTags($actualTags, $validTags)
    {
        foreach ($actualTags as $tag) {
            $this->assertContains($tag, $validTags);
        }
    }

    public function jsonFileProvider()
    {
        return [
            ['user-groups.json'],
            ['conferences.json'],
            ['tags.json'],
        ];

    }

}
