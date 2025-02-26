<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageManagerController extends Controller
{

    public function manager($uuid = null)
    {
        $readParent = FileManager::when(!empty($uuid), function ($q) use ($uuid) {
            $q->where("uuid", $uuid);
        })
            ->when(empty($uuid), function ($q) {
                $q->whereNull("parent_id");
            })
            ->first();
        $read = FileManager::where("parent_id", $readParent->id)
            ->get();
        return response()->json($read);
    }
}
