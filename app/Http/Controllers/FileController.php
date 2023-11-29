<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadProfileRequest;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static $default = 'default.jpg';
    static $diskName = 'pictures';

    public static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg', 'gif'],
        'world' => ['png', 'jpg', 'jpeg', 'gif'],
        'project' => ['png', 'jpg', 'jpeg', 'gif']
    ];

    private static function isValidType(String $type): bool {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset(String $type): string {
        return asset($type . '/' . self::$default);
    }

    private static function getFileName (String $type, int $id): ?string {

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

    private static function delete(String $type, int $id) {
        $existingFileName = self::getFileName($type, $id);
        if ($existingFileName) {
            Storage::disk(self::$diskName)->delete($type . '/' . $existingFileName);

            switch($type) {
                case 'profile':
                    Member::find($id)->profile_image = null;
                    break;
                case 'post':
                    // other models
                    break;
            }
        }
    }

    function upload(UploadProfileRequest $request, int $id): RedirectResponse {
        $fields = $request->validated();

        $this->delete($fields['type'], $id);

        $file = $request->file('file');
        $fileName = $file->hashName();

        switch($request->type) {
            case 'profile':
                $member = Member::findOrFail($id);
                $member->picture = $fileName;
                $member->save();
        }

        $file->storeAs($fields['type'], $fileName, self::$diskName);
        return redirect()->back()->withSuccess('File uploaded!');
    }

}
