<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

/**
 * Utils Model
 *
 * 共通処理をまとめるモデル
 * 
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UtilsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    /**
     * ランダム文字列生成 (英数字)
     *
     * @param integer $length: 生成する文字数
     * @return string ランダム文字列
     */
    public function makeRandStr($length = 8) {
        static $chars;
        if (!$chars) {
            $chars = array_flip(array_merge(
                range('a', 'z'), range('A', 'Z'), range('0', '9')
            ));
        }
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= array_rand($chars);
        }

        return $str;
    }
}
