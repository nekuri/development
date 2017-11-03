<?php

namespace App\Model\Validation;

use Cake\Validation\Validation;
use Cake\Utility\Hash;

class CustomValidation extends Validation
{
    public static function checkImageFileExtension($value, $context)
    {
        $allow_extensions = ['image/jpeg', 'image/jpg', 'image/png' ];
        $mime_type = Hash::get($value, 'type');

        if (!in_array($mime_type, $allow_extensions)) {
            return false;
        }

        return true;
    }
}