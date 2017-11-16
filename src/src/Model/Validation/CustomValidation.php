<?php

namespace App\Model\Validation;

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validation;

class CustomValidation extends Validation
{
    /**
     * 画像の拡張子をチェックする
     *
     * @param array $value 画像データ
     * @return bool
     */
    public static function checkImageFileExtension($value)
    {
        $allow_extensions = ['image/jpeg', 'image/jpg', 'image/png' ];
        $mime_type = Hash::get($value, 'type');

        if (!in_array($mime_type, $allow_extensions)) {
            return false;
        }

        return true;
    }

    /**
     * すでに使われているメールアドレスかどうか
     *
     * @param string $email メールアドレス
     * @return bool
     */
    public static function isEmailUnique($email)
    {
        $Members = TableRegistry::get('Members');

        if ($Members->findByEmail($email)->first()) {
            return false;
        }

        return true;
    }
}
