<?php
// src/Service/ChecklistService.php
namespace App\Service;

/**
 * Service for analyzing keywords of a content.
 */
class ChecklistService
{
    // Keywords string - ex: 'banana, apple'.
    private $keywords_str;

    // Minum number of words that the content should have.
    private $min_number_of_words;

    /**
     * Constructor.
     *
     * @param | $keywords_str | {String} | Keywords will be splited by comma. 
     * @param | $min_number_of_words | {Number} | Minimum number of words.
     */
    public function __construct($keywords_str, $min_number_of_words)
   {
       $this->keywords_str = strtolower($keywords_str);
       $this->min_number_of_words = $min_number_of_words;
   }

   /**
    * Analyze content.
    *
    * @param | $content | {String} | The content to analyze.
    * @return | it returns false if the api does not contain `content` or the content have less than the ${min_number_of_words}
    *         | or it returns the result of analysis as a JSON format - it will have content, count of keywords used and density
    */
    public function doAnalyze($content)
    {
        $number_of_words = sizeof(explode(" ", $content));

        if ($number_of_words < $this->min_number_of_words || $number_of_words < 1) {
            return false;
        }

        $keywords = array_filter(explode(",", $this->keywords_str));
        foreach ($keywords as $key=>$keyword) {
            $keywords[$key] = trim($keyword);
        }

        $lower_content = strtolower($content);
        $keywords_used = 0;
        foreach ($keywords as $keyword) {
            if (strpos($lower_content, $keyword) !== false) {
                $keywords_used++;
            }
        }
        $density = $keywords_used / $number_of_words;

        return [
            "content" => $content,
            "keywords used" => $keywords_used,
            "average keywords density" => number_format((float)$density, 2, '.', '')
        ];
    }

    /**
     * Returns the keyword_str.
     * 
     * @return | the keyword_str.
     */
    public function getKeywordStr() {
        return $this->keyword_str;
    }

    /**
     * Returns the minimum number of words.
     * @return | The minimum number of words.
     */
    public function getMinNumberOfWords()
    {
        return $this->min_number_of_words;
    }

    
}