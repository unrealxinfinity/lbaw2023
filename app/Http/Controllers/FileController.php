<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class FileController extends Controller
{
    static $default = 'default.jpg';
    static $diskName = 'pictures';

    public static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg', 'gif']
    ];

    private static function isValidType(String $type): bool {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset(String $type): string {
        return asset($type . '/' . self::$default);
    }

    private static function getFileName (String $type, int $id): string {

        $fileName = null;
        switch($type) {
            case 'profile':
                $fileName = Member::find($id)->picture;
                break;
            case 'post':
                // other models
                break;
        }

        return $fileName;
    }

    static function get(String $type, int $userId): string {

        // Validation: upload type
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }

        // Validation: file exists
        $fileName = self::getFileName($type, $userId);
        if ($fileName) {
            return asset($type . '/' . $fileName);
        }

        // Not found: returns default asset
        return self::defaultAsset($type);
    }

}
