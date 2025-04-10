<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FileInfo;
use App\Models\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class Importm1Controller extends Controller
{
    public function index()
    {
        $getJsonData = json_decode(file_get_contents(url('data/stage1.json')), true);
        foreach ($getJsonData as $key => $value) {
            $checkFolder = FileManager::where('code_clasification', $value['Kode'])->first();
            if ($checkFolder) {
                continue;
            }
            if ($value['Tipe'] == 'Folder') {
                $cekParent = FileManager::where('code_clasification', $value['Parent_Kode'])->first();
                if ($cekParent) {
                    $value['Parent'] = $cekParent->uuid;
                }
                $this->newFolder(new Request([
                    'folder_name' => $value['Nama'],
                    'folder_code' => $value['Kode'],
                    'this_uuid' => $value['Parent'] ?? null
                ]));
            } else {
                $cekParent = FileManager::where('code_clasification', $value['Parent_Kode'])->first();
                if ($cekParent) {
                    $value['Parent'] = $cekParent->uuid;
                }
                $this->upload(new Request([
                    'code_clasification' => $value['Kode'],
                    'this_uuid' => $value['Parent'] ?? null,
                    'fileName' => $value['Nama'],
                ]));
            }
        }
        return response()->json($getJsonData);
    }

    public function newFolder(Request $request)
    {
        try {
            // Jika UUID tidak diberikan, artinya folder dibuat di root
            $folderThis = $request->this_uuid ? FileManager::where("uuid", $request->this_uuid)->first() : null;

            // Ambil path berdasarkan parent folder, jika ada
            $paths = $folderThis ? implode('/', $folderThis->getParentHierarchy()->pluck('name')->toArray()) : '';

            // Tentukan path folder yang akan dibuat
            $newFolderPath = $folderThis ? $paths . '/' . $request->folder_name : $request->folder_name;

            // Cek apakah folder sudah ada
            if (Storage::disk('public')->exists($newFolderPath)) {
                return redirect()->route('file-manager.index', ['uuid' => $request->this_uuid])
                    ->with('error', 'Folder already exists.');
            }

            // Buat folder baru di storage
            Storage::disk('public')->makeDirectory($newFolderPath);

            // Simpan data folder baru ke database
            FileManager::create([
                'code_clasification' => $request->folder_code,
                'uuid' => Str::uuid(),
                'name' => $request->folder_name,
                'type' => 'folder',
                'visibility' => 'private',
                'status' => 'active',
                'user_id' => auth()->id() ?? 1, // Gunakan user yang login atau default ke 1
                'paths' => $newFolderPath,
                'parent_id' => $folderThis ? $folderThis->id : null, // NULL jika folder di root
            ]);

            // Buat permission baru untuk folder yang dibuat
            try {
                Permission::create(['name' => $request->folder_code]);
            } catch (\Throwable $th) {
            }

            return "success";
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function upload(Request $request)
    {
        DB::beginTransaction();
        try {
            $folderThis = FileManager::where("uuid", $request->this_uuid)->first();
            if (!$folderThis) {
                return redirect()->route('file-manager.index')
                    ->with('error', 'Parent folder not found.');
            }

            $fileCreated = FileManager::create([
                'code_clasification' => $request->code_clasification,
                'uuid' => Str::uuid(),
                'name' => $request->fileName,
                'type' => 'file',
                'visibility' => 'private',
                'status' => 'active',
                'user_id' => auth()->id() ?? 1,
                'paths' => null,
                'parent_id' => $folderThis->id,
                'size' => 0,
                // 'mime_type' => $file->getMimeType() ?? null,
                "ext" => 'txt'
            ]);

            $extra_info = $request->extra_info;
            if ($extra_info && is_array($extra_info)) {
                foreach ($extra_info as $key => $value) {
                    FileInfo::create([
                        'uuid' => Str::uuid(),
                        'user_id' => auth()->id() ?? 1,
                        'file_manager_id' => $fileCreated->id,
                        'name' => $value['name'],
                        'type' => 'text',
                        'value' => $value['description'],
                    ]);
                }
            }
            try {
                Permission::create(['name' => $request->code_clasification]);
            } catch (\Throwable $th) {
                //throw $th;
            }
            DB::commit();
            return "success";
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
