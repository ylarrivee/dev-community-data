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
        $files = $this->listJsonFiles('conferences');
        
        // Check data integrity.
        foreach ($files as $i => $fileName) {
            $entry = $this->loadJsonFile($fileName);
            $validTags = $this->flattenHierarchy($this->loadJsonFile('tags.json'));
            preg_match_all('/([^\/]+).json/', $fileName, $matches);
            $key = $matches[1][0];

            $this->assertArrayHasKey('name', $entry, 'Entry '.$key);
            $this->assertArrayHasKey('first_event', $entry, 'Entry '.$key);
            $this->assertValidTags($entry['tags'], $validTags, $key);
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
            $this->assertValidTags($entry['tags'], $validTags, $entry['key']);
            $keys[] = $entry['key'];
        }
    }

    private function listJsonFiles($folder)
    {
        $folderPath = __DIR__ . '/../data/';
        chdir($folderPath);
        $files = glob($folder.'/*.json');
        return $files;
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

    public function assertValidTags($actualTags, $validTags, $eventKey)
    {
        foreach ($actualTags as $tag) {
            $this->assertContains($tag, $validTags, 'Invalid tag "'.$tag.'" in event "'.$eventKey.'". Either remove the tag from the event or add it to tags.json');
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
