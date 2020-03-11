<?php  
// tests/Service/ChecklistServerTest.php
namespace Simplex\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\ChecklistService;

class ChecklistServiceTest extends TestCase
{
    public function testWordLength()
    {
        $checklistService = new ChecklistService('banana', 50);

        $content = "show message";

        $analizedContent = $checklistService->doAnalyze($content);

        $this->assertFalse($analizedContent);
    }

    public function testAnalyseSingleWord()
    {
        $checklistService = new ChecklistService('banana, APPLE', 10);

        $content = "fruits are really good for your health. You should eat at least 1 banana per day and 1 green apple.";

        $analizedContent = $checklistService->doAnalyze($content);        

        $expectedResult = [
          "content" => $content,
          "keywords used" => 2,
          "average keywords density" => 0.10
        ];
        
        $this->assertTrue(is_array($analizedContent));

        $this->assertArrayHasKey('content', $analizedContent);
        $this->assertEquals($analizedContent['content'], $expectedResult['content']);

        $this->assertArrayHasKey('keywords used', $analizedContent);
        $this->assertEquals($analizedContent['keywords used'], $expectedResult['keywords used']);

        $this->assertArrayHasKey('average keywords density', $analizedContent);
        $this->assertEquals($analizedContent['average keywords density'], $expectedResult['average keywords density']);

        $unExpectedResult = [
          "content" => $content,
          "keywords used" => 2,
          "average keywords density" => '1.1'
        ];
        $this->assertNotEquals($analizedContent['average keywords density'], $unExpectedResult['average keywords density']);
    }

    public function testAnalyseToken()
    {
        $checklistService = new ChecklistService('banana per day, APPLE', 10);

        $content = "fruits are really good for your health. You should eat at least 1 Banana per day and 1 green Apple.";

        $analizedContent = $checklistService->doAnalyze($content);        

        $expectedResult = [
          "content" => $content,
          "keywords used" => 2,
          "average keywords density" => 0.10
        ];
        
        $this->assertTrue(is_array($analizedContent));

        $this->assertArrayHasKey('content', $analizedContent);
        $this->assertEquals($analizedContent['content'], $expectedResult['content']);

        $this->assertArrayHasKey('keywords used', $analizedContent);
        $this->assertEquals($analizedContent['keywords used'], $expectedResult['keywords used']);

        $this->assertArrayHasKey('average keywords density', $analizedContent);
        $this->assertEquals($analizedContent['average keywords density'], $expectedResult['average keywords density']);

        //Check number format
        $unExpectedResult = [
          "content" => $content,
          "keywords used" => 2,
          "average keywords density" => '1.1'
        ];
        $this->assertNotEquals($analizedContent['average keywords density'], $unExpectedResult['average keywords density']);
    }
}