<?php

namespace App\Http\Controllers;

use App\Models\FileManager;
use App\Models\FileShare;
use Illuminate\Http\Request;

class FileShareController extends Controller
{
    public function index($uuid = null)
    {
        $rootDirectory = '';
        $manager = $this->manager($uuid);
        $folderThis = FileManager::where("uuid", $uuid)->first();
        $paths = $folderThis ? $folderThis->getParentHierarchy()  : [];

        $parentUid =  !empty($manager) ? (
            !empty($folderThis->parent_id) ? FileManager::where("id", $folderThis->parent_id)->first()->uuid : null
        ) : null;

        return view('pages.share', [
            "manager" => $manager,
            "parent_uuid" =>  $parentUid,
            "this_uuid" => $uuid,
            "users" => $this->getAllUsers() ?? [],
            "paths" => count($paths) > 0 ? $paths->map(function ($path) {
                return [
                    "id" => $path->id,
                    "uuid" => $path->uuid,
                    "name" => $path->name
                ];
            }) : []
        ]);
    }

    public function fileShared($uuid = null) {}

    // share user sharing file
    public function share(Request $request)
    {
        $request->validate([
            'file_id' => 'required|exists:file_managers,id',
            'user_id' => 'required|exists:users,id',
        ]);
        $cek = FileShare::where('user_id', auth()->id())
            ->where('user_share_id', $request->user_id)
            ->where('file_manager_id', $request->file_id)
            ->first();
        if ($cek) {
            return response()->json([
                'message' => 'File already shared'
            ], 400);
        }
        FileShare::create([
            'user_id' => auth()->id(),
            'user_share_id' => $request->user_id,
            'file_manager_id' => $request->file_id,
            'type' => 'view'
        ]);
        return response()->json([
            'message' => 'File shared successfully'
        ]);
    }

    // remove share
    public function removeShare($id, $file_id)
    {

        $fileShare = FileShare::where('user_share_id', $id)
            ->where('file_manager_id', $file_id)
            ->where("user_id", auth()->id())
            ->first();
        if (!$fileShare) {
            return response()->json([
                'message' => 'File share not found'
            ], 404);
        }
        $fileShare->delete();
        return response()->json([
            'message' => 'File share removed'
        ]);
    }
}
