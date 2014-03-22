<?php
/**
 * Created by PhpStorm.
 * User: syang
 * Date: 14-3-18
 * Time: 下午9:59
 */

namespace app\helpers;

class StringHelper extends \yii\helpers\StringHelper
{

    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int     $limit
     * @param  string  $end
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit) return $value;

        return rtrim(mb_substr($value, 0, $limit, 'UTF-8')).$end;
    }

    /**
     * 闭合 HTML 标签 （此函数仍存在缺陷，无法处理不完整的标签，暂无更优方案，慎用）
     * @param  string $html HTML 字符串
     * @return string
     */
    public static function closeTags($html)
    {
        // 不需要补全的标签
        $arr_single_tags = array('meta', 'img', 'br', 'link', 'area');
        // 匹配开始标签
        preg_match_all('#<([a-z1-6]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        // 匹配关闭标签
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        // 计算关闭开启标签数量，如果相同就返回html数据
        if (count($closedtags) === count($openedtags)) return $html;
        // 反向排序数组，将最后一个开启的标签放在最前面
        $openedtags = array_reverse($openedtags);
        // 遍历开启标签数组
        foreach ($openedtags as $key => $value) {
            // 跳过无需闭合的标签
            if (in_array($value, $arr_single_tags)) continue;
            // 开始补全
            if (in_array($value, $closedtags)) {
                unset($closedtags[array_search($value, $closedtags)]);
            } else {
                $html .= '</'.$value.'>';
            }
        }
        return $html;
    }

    public static function friendlyDate($theDate)
    {
        // 获取待处理的日期对象
        if (! $theDate instanceof \Carbon\Carbon)
            $theDate = \Carbon\Carbon::createFromTimestamp(strtotime($theDate));
        // 取得英文日期描述
        $friendlyDateString = $theDate->diffForHumans(\Carbon\Carbon::now());
        // 本地化
        $friendlyDateArray  = explode(' ', $friendlyDateString);

        $friendlyDateString = $friendlyDateArray[0]. \Yii::t('app', $friendlyDateArray[1]) . \Yii::t('app', $friendlyDateArray[2]);
        // 数据返回
        return $friendlyDateString;
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int     $length
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function random($length = 16)
    {
        if (function_exists('openssl_random_pseudo_bytes'))
        {
            $bytes = openssl_random_pseudo_bytes($length * 2);

            if ($bytes === false)
            {
                throw new \RuntimeException('Unable to generate random string.');
            }

            return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
        }

        return static::quickRandom($length);
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int     $length
     * @return string
     */
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}