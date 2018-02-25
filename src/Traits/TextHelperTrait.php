<?php
/**
 * Created by PhpStorm.
 * User: alexeysamara
 * Date: 24.02.2018
 * Time: 01:10
 */

namespace App\Traits;

/**
 * Trait TextHelperTrait
 * @package App\Traits
 */
trait TextHelperTrait
{
    /**
     * @param float      $start
     * @param float|null $end
     * @param bool       $postfix
     *
     * @return float|string - return rounded value
     */
    public function getFormattedTime(float $start, float $end = null, $postfix = false)
    {
        $end = is_null($end) ? microtime(true) : $end;
        $time = round($end - $start, 2);

        return ($postfix) ? strval($time) . 'sec' : (float) $time;
    }

    /**
     * @param string $value
     * @return string
     */
    public function cleanValue(string $value): string
    {
        /**
         * http://php.net/manual/en/function.html-entity-decode.php#refsect1-function.html-entity-decode-notes
         * http://stackoverflow.com/a/6275467
         */
        $value = html_entity_decode($value, ENT_QUOTES, 'utf-8');
        $value = str_replace("\xC2\xA0", ' ', $value);

        $value = preg_replace('/\s+/', ' ', $value);
        $value = trim($value);

        return $value;
    }
}
