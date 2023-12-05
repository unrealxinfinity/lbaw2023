<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Member;
use App\Models\Project;
use App\Models\World;
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
            case 'world':
                $fileName = World::find($id)->picture;
                break;
            case 'project':
                $fileName = Project::find($id)->picture;
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
                    Member::find($id)->picture = null;
                    break;
                case 'world':
                    World::find($id)->picture = null;
                    break;
                case 'project':
                    Project::find($id)->picture = null;
                    break;
            }
        }
    }

    function upload(UploadRequest $request, int $id): RedirectResponse {
        $fields = $request->validated();

        $this->delete($fields['type'], $id);

        $file = $request->file('file');
        $fileName = $file->hashName();
        $file->storeAs($fields['type'], $fileName, self::$diskName);
        
        switch($request->type) {
            case 'profile':
                $member = Member::findOrFail($id);
                $member->picture = $fileName;
                $member->save();
                return redirect()->route('members.show', $member->persistentUser->user->username);
            case 'world':
                $world = World::findOrFail($id);
                $world->picture = $fileName;
                $world->save();
                return redirect()->route('worlds.show', $id);
            case 'project':
                $project = Project::findOrFail($id);
                $project->picture = $fileName;
                $project->save();
                return redirect()->route('projects.show', $id);
        }
    }

}
