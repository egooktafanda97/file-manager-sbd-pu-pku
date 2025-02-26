<?php

namespace App\Http\Controllers;

use App\Models\FileFavorite;
use App\Models\FileInfo;
use App\Models\FileManager;
use App\Models\FileShare;
use App\Models\FileViewr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class FileManagerController extends Controller
{
    public function index($uuid = null)
    {
        $rootDirectory = '';
        $this->scanStorages($rootDirectory);

        if (auth()->user()->level == 'super-admin')
            $manager = $this->managerSuper($uuid);
        else
            $manager = $this->manager($uuid);
        $folderThis = FileManager::where("uuid", $uuid)->first();
        $paths = $folderThis ? $folderThis->getParentHierarchy()  : [];

        $parentUid =  !empty($manager) ? (
            !empty($folderThis->parent_id) ? FileManager::where("id", $folderThis->parent_id)->first()->uuid : null
        ) : null;

        return view('pages.file-manager', [
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

    public function getUserSharedInFile($uuid)
    {
        $fileShare = FileShare::where('file_manager_id', FileManager::where('uuid', $uuid)->first()->id)
            ->where('user_id', auth()->id())
            ->get();
        $users = User::whereIn('id', $fileShare->pluck('user_share_id'))->get();
        return response()->json($users);
    }


    public function getAllUsers()
    {
        $users = User::where("level", "!=", "super-admin")->get();
        return $users;
    }



    public function getAccessibleFolders($user)
    {
        $userPermissions = $user->getAllPermissions()->pluck('name'); // Ambil semua permission user

        // Ambil semua file dan folder yang memiliki permission yang cocok
        $accessibleItems = FileManager::whereIn('code_clasification', $userPermissions)
            ->orWhere('visibility', 'public')
            ->orWhere('user_id', $user->id)
            ->get();

        $accessibleFolders = collect();

        foreach ($accessibleItems as $item) {
            // Jika item adalah file, tambahkan seluruh parent-nya hingga root
            if ($item->type === 'file') {
                $parents = $item->getParentHierarchy();
                $accessibleFolders = $accessibleFolders->merge($parents);
            }
            // Jika item adalah folder, tambahkan folder beserta semua child-nya
            elseif ($item->type === 'folder') {
                $accessibleFolders->push($item);
                $accessibleFolders = $accessibleFolders->merge($item->children);
            }
        }

        return $accessibleFolders->unique('id'); // Hindari duplikasi
    }

    public function manager($uuid = null)
    {
        $user = auth()->user(); // Ambil user yang sedang login
        $accessibleFolders = $this->getAccessibleFolders($user);

        if (empty($uuid)) {
            return $accessibleFolders->whereNull('parent_id'); // Hanya folder root yang bisa diakses
        }

        $parentFolder = FileManager::where("uuid", $uuid)->first();

        if (!$parentFolder || !$accessibleFolders->contains('id', $parentFolder->id)) {
            return []; // Jika user tidak punya akses ke folder ini
        }

        return $accessibleFolders->where('parent_id', $parentFolder->id)
            ->map(function ($x) {
                $x->favorit = FileFavorite::where('user_id', auth()->id())->where('file_manager_id', $x->id)->exists();
                return $x;
            })
            ->sortBy(fn($item) => $item->type === 'folder' ? 0 : 1);
    }

    public function managerSuper($uuid = null)
    {
        if (empty($uuid)) {
            return FileManager::whereNull("parent_id")
                ->get()
                ->map(function ($x) {
                    $x->favorit = FileFavorite::where('user_id', auth()->id())->where('file_manager_id', $x->id)->exists();
                    return $x;
                })
                ->sortBy(function ($item) {
                    return $item->type === 'folder' ? 0 : 1;
                });
        }

        $parentFolder = FileManager::where("uuid", $uuid)->first();

        if (!$parentFolder) {
            return [];
        }
        return FileManager::where("parent_id", $parentFolder->id)
            ->when(request()->has('search'), function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%')
                    ->orWhere('code_clasification', 'like', '%' . request()->search . '%');
            })
            ->get()
            // ->map(function ($x) {
            //     $x->favorit = FileFavorite::where('user_id', auth()->id())->where('file_manager_id', $x->id)->exists();
            //     return $x;
            // })
            ->sortBy(function ($item) {
                return $item->type === 'folder' ? 0 : 1;
            });
    }


    public function scanStorages($directory, $parentId = null)
    {
        $folders = Storage::disk('public')->directories($directory);
        $files = Storage::disk('public')->files($directory);

        $folderPaths = $folders;
        $folderNames = array_map('basename', $folders);

        $tree = [];
        // 🔹 **Tambahkan Folder ke Tree**
        foreach ($folderPaths as $index => $folderPath) {
            $fileRecordCheck = FileManager::where('paths', $folderPath)->first();
            if ($fileRecordCheck) {
                continue;
            }
            $folderRecord = FileManager::updateOrCreate(
                ['paths' => $folderPath],
                [
                    'uuid' => Str::uuid(),
                    'name' => $folderNames[$index],
                    'type' => 'folder',
                    'visibility' => 'private',
                    'status' => 'active',
                    'user_id' => 1,
                    'parent_id' => $parentId,
                ]
            );

            $tree[] = [
                'name' => $folderNames[$index],
                'type' => 'folder',
                'parent_folder' =>  $folderRecord->id,
                'children' => $this->scanStorages($folderPath,  $folderRecord->id ?? null)
            ];
        }

        // 🔹 **Tambahkan File ke Database dan Tree**
        foreach ($files as $filePath) {
            // Dapatkan nama file dari path
            $fileName = basename($filePath);
            $fileRecordCheck = FileManager::where('paths', $filePath)->first();
            if ($fileRecordCheck) {
                continue;
            }
            // Simpan file ke dalam database
            $fileRecord = FileManager::updateOrCreate(
                ['paths' => $filePath], // Pastikan path lengkap disimpan
                [
                    'uuid' => Str::uuid(),
                    'name' => $fileName,
                    'type' => 'file',
                    'visibility' => 'private',
                    'status' => 'active',
                    'user_id' => 1,
                    'parent_id' => $parentId, // Sesuai folder tempatnya berada
                    'size' => Storage::disk('public')->size($filePath), // Dapatkan ukuran file
                    'mime_type' => null, // Dapatkan MIME type file
                ]
            );

            // Tambahkan file ke struktur tree
            $tree[] = [
                'name' => $fileName,
                'type' => 'file',
                'parent_id' => $parentId,
                'size' => $fileRecord->size,
                'mime_type' => $fileRecord->mime_type
            ];
        }

        return $tree;
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
            Permission::create(['name' => $request->folder_code]);

            return redirect()->route('file-manager.index', ['uuid' => $request->this_uuid])
                ->with('success', 'Folder created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('file-manager.index', ['uuid' => $request->this_uuid])
                ->with('error', 'Failed to create folder. Error: ' . $th->getMessage());
        }
    }

    // delete folder Or File
    public function destroy(Request $request, $uuid)
    {
        try {
            $file = FileManager::where("uuid", $uuid)->first();
            if (!$file) {
                return redirect()->route('file-manager.index')
                    ->with('error', 'File or folder not found.');
            }
            if ($file->type === 'folder') {
                Storage::disk('public')->deleteDirectory($file->paths);
            } else {
                Storage::disk('public')->delete($file->paths);
            }
            $file->delete();
            Permission::where('name', $file->code_clasification)->delete();
            return redirect()->route('file-manager.index', ['uuid' => $request->this_uuid])
                ->with('success', 'File or folder deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('file-manager.index', ['uuid' => $request->this_uuid])
                ->with('error', 'Failed to delete file or folder. Error: ' . $th->getMessage());
        }
    }

    // read by uuid 
    public function getFirst($uuid)
    {
        $file = FileManager::where("uuid", $uuid)->first();
        if (!$file) {
            return response()->json(['message' => 'File not found.'], 404);
        }
        $paths = $file ? implode('/', $file->getParentHierarchy()->pluck('name')->toArray()) : '';

        return response()->json(collect($file)->merge([
            "path" => $paths
        ]));
    }
    public function getPreview($uuid)
    {
        $file = FileManager::where("uuid", $uuid)->first();
        if (!$file) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $paths = $file ? implode('/', $file->getParentHierarchy()->pluck('name')->toArray()) : '';
        if (!FileViewr::where('file_id', $file->id)->whereDate('created_at', now()->toDateString())->exists()) {
            FileViewr::create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->user()->id,
                'file_id' => $file->id,
            ]);
        }

        return response()->json(collect($file)->merge([
            "path" => $paths
        ]));
    }

    public function getFileInfo($uuid)
    {
        $file = FileManager::where("uuid", $uuid)->first();
        if (!$file) {
            return response()->json(['message' => 'File not found.'], 404);
        }
        $info = $file->info;
        $maping =
            array_merge([
                "Code" => $file->code_clasification,
                "file name" => $file->name,
                "size" => $file->size . ' bytes',
                "visibility" => $file->visibility,
            ], $info->pluck('value', 'name')->toArray());
        return response()->json($maping);
    }

    //update
    public function update(Request $request)
    {
        $file = FileManager::where("uuid", $request->uuid)->first();

        if (!$file) {
            return redirect()->route('file-manager.index')
                ->with('error', 'File or folder not found.');
        }

        // Ambil parent path (kosong jika root)
        $paths = $file->parent_id ? implode('/', $file->getParentHierarchy()->pluck('name')->toArray()) : '';

        // Cek apakah ada file atau folder lain dengan nama yang sama dalam parent yang sama
        $exists = FileManager::where('parent_id', $file->parent_id)
            ->where('name', $request->update_name)
            ->where('id', '!=', $file->id)
            ->exists();

        if ($exists) {
            return redirect()->route('file-manager.index', ['uuid' => $request->uuid])
                ->with('error', 'A file or folder with the same name already exists in this folder.');
        }

        // Path lama & baru
        $oldPath = $paths ? $paths . '/' . $file->name : $file->name;
        $newPath = $paths ? $paths . '/' . $request->update_name : $request->update_name;

        // Cek apakah ini folder atau file
        if ($file->type === 'folder') {
            $oldFullPath = storage_path("app/public/{$oldPath}");
            $newFullPath = storage_path("app/public/{$newPath}");

            if (File::exists($oldFullPath)) {
                if (!File::move($oldFullPath, $newFullPath)) {
                    return redirect()->route('file-manager.index', ['uuid' => $request->uuid])
                        ->with('error', 'Failed to rename the folder in storage.');
                }
            } else {
                return redirect()->route('file-manager.index', ['uuid' => $request->uuid])
                    ->with('error', 'Folder does not exist.');
            }
        } else {
            // Jika ini file
            $oldFullPath = storage_path("app/public/{$oldPath}");
            $ext = pathinfo($file->name, PATHINFO_EXTENSION);

            if ($ext) {
                $newPath = $paths ? "{$paths}/{$request->update_name}.{$ext}" : "{$request->update_name}.{$ext}";
            } else {
                $newPath = $paths ? "{$paths}/{$request->update_name}" : "{$request->update_name}";
            }

            $newFullPath = storage_path("app/public/{$newPath}");

            if (File::exists($oldFullPath)) {
                if (!File::move($oldFullPath, $newFullPath)) {
                    return redirect()->route('file-manager.index', ['uuid' => $request->uuid])
                        ->with('error', 'Failed to rename the file in storage.');
                }
            } else {
                return redirect()->route('file-manager.index', ['uuid' => $request->uuid])
                    ->with('error', 'File does not exist.');
            }
        }

        // Jika rename berhasil, update database
        $file->update([
            'name' => $request->update_name,
            'code_clasification' => $request->update_code,
            'paths' => $newPath, // Simpan path baru di database
        ]);

        return redirect()->route('file-manager.index', ['uuid' => $request->uuid])
            ->with('success', 'File or folder updated successfully.');
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

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs($folderThis->paths, $fileName, 'public');

            $fileCreated = FileManager::create([
                'code_clasification' => $request->code_clasification,
                'uuid' => Str::uuid(),
                'name' => $fileName,
                'type' => 'file',
                'visibility' => 'private',
                'status' => 'active',
                'user_id' => auth()->id() ?? 1,
                'paths' => $filePath,
                'parent_id' => $folderThis->id,
                'size' => $file->getSize(),
                // 'mime_type' => $file->getMimeType() ?? null,
                "ext" => $file->getClientOriginalExtension()
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
            Permission::create(['name' => $request->code_clasification]);
            DB::commit();
            return redirect()->route('file-manager.index', ['uuid' => $request->this_uuid])
                ->with('success', 'File uploaded successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return redirect()->route('file-manager.index', ['uuid' => $request->this_uuid])
                ->with('error', 'Failed to upload file. Error: ' . $th->getMessage());
        }
    }

    public function downloadFile($uuid)
    {

        $file = FileManager::where("uuid", $uuid)->first();
        if (!$file) {
            return redirect()->route('file-manager.index')
                ->with('error', 'File not found.');
        }
        $paths = $file ? implode('/', $file->getParentHierarchy()->pluck('name')->toArray()) : '';

        $path = storage_path("app/public/{$paths}");

        if (!File::exists($path)) {
            dd($path);
            return redirect()->back()
                ->with('error', 'File not found.');
        }

        return response()->download($path);
    }

    public function bulkDelete(Request $request)
    {
        $uuidData = $request->all();
        DB::beginTransaction();
        try {
            foreach ($uuidData as $xy) {
                $file = FileManager::where("uuid", $xy)->first();
                if (!$file) {
                    throw new \Exception('File or folder not found.');
                }
                if ($file->type === 'folder') {
                    Storage::disk('public')->deleteDirectory($file->paths);
                } else {
                    Storage::disk('public')->delete($file->paths);
                }
                $file->delete();
                Permission::where('name', $file->code_clasification)->delete();
            }
            DB::commit();
            return response()
                ->json(['message' => 'File or folder deleted successfully.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()
                ->json(['message' => 'Failed to delete file or folder. Error: ' . $th->getMessage()]);
        }
    }

    public function scanAndStoreTree($directory, $parentId = null)
    {
        // Ambil daftar folder dan file dari database berdasarkan parent_id
        $existingFolders = FileManager::where('parent_id', $parentId)->where('type', 'folder')->pluck('paths', 'id')->toArray();
        $existingFiles = FileManager::where('parent_id', $parentId)->where('type', 'file')->pluck('paths', 'id')->toArray();

        // Ambil daftar folder dan file dari Laravel Storage
        $folders = Storage::disk('public')->directories($directory);
        $files = Storage::disk('public')->files($directory);

        $foundFolders = [];
        $foundFiles = [];

        foreach ($folders as $folder) {
            $folderRecord = FileManager::updateOrCreate(
                ['paths' => $folder],
                [
                    'name' => basename($folder),
                    'type' => 'folder',
                    'visibility' => 'private',
                    'status' => 'active',
                    'user_id' => 1,
                    'parent_id' => $parentId, // ID Folder Induk
                ]
            );
            $foundFolders[$folderRecord->id] = $folder;
            $this->scanAndStoreTree($folder, $folderRecord->id);
        }

        // 🔹 **Simpan File**
        foreach ($files as $file) {
            $fileRecord = FileManager::updateOrCreate(
                ['paths' => $file],
                [
                    'name' => basename($file),
                    'type' => 'file',
                    'visibility' => 'private',
                    'status' => 'active',
                    'user_id' => 1,
                    'parent_id' => $parentId,
                    'size' => Storage::disk('public')->size($file),
                    'mime_type' => '',
                ]
            );

            $foundFiles[$fileRecord->id] = $file;
        }

        // 🔥 **Hapus Folder yang Sudah Tidak Ada di Storage (Bersama Semua File dan Subfoldernya)**
        $foldersToDelete = array_diff_key($existingFolders, $foundFolders);

        if (!empty($foldersToDelete)) {
            $folderIds = array_values($foldersToDelete); // Ambil ID folder yang akan dihapus

            // Hapus semua file dan subfolder dari folder yang akan dihapus
            foreach ($folderIds as $folderId) {
                $this->deleteFolderAndContents($folderId);
            }
        }

        // 🔥 **Hapus File yang Sudah Tidak Ada di Storage**
        $filesToDelete = array_diff_key($existingFiles, $foundFiles);
        if (!empty($filesToDelete)) {
            $fileIds = array_values($filesToDelete);
            FileManager::whereIn('id', $fileIds)->delete();
        }

        FileManager::where("parent_id", $parentId)->where("type", "folder")->whereNotIn('id', array_keys($foundFolders))->delete();
        FileManager::where("parent_id", $parentId)->where("type", "file")->whereNotIn('id', array_keys($foundFiles))->delete();
    }

    public function deleteFolderAndContents($folderId)
    {
        // Ambil semua subfolder dan file dalam folder ini
        $subFolders = FileManager::where('parent_id', $folderId)->get();

        foreach ($subFolders as $subFolder) {
            // Jika ini folder, hapus semua isinya secara rekursif
            if ($subFolder->type === 'folder') {
                $this->deleteFolderAndContents($subFolder->id);
            }
            // Hapus file atau folder dari database
            $subFolder->delete();
        }

        // Hapus folder induk setelah isinya dihapus
        FileManager::where('id', $folderId)->delete();
    }


    public function showRootFolder()
    {
        $rootFolder = FileManager::whereNull('parent_id')->first();
        return response()->json($rootFolder);
    }

    // search
    public function searchFiles(Request $request)
    {
        $user = auth()->user();
        $userPermissions = $user->getAllPermissions()->pluck('name');
        $search = $request->get('search');

        $files = FileManager::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('code_clasification', 'like', '%' . $search . '%');
        })
            ->where(function ($Q) use ($userPermissions, $user) {
                return $Q->whereIn('code_clasification', $userPermissions)
                    ->orWhere('visibility', 'public')
                    ->orWhere('user_id', $user->id);
            })
            ->where('type', 'file')
            ->take(5)
            ->get();
        $files->map(function ($it) use ($search) {
            $paths = $it ? implode('/', $it->getParentHierarchy()->pluck('name')->toArray()) : '';
            $it->path = $paths;
            $it->parent_uuid = $it->parent_id ? FileManager::where("id", $it->parent_id)->first()->uuid : "";
            $it->merge_name = $it->code_clasification . ' - ' . $it->name;
            $it->search = $search;
            return $it;
        });
        return response()->json($files);
    }

    // favorit
    public function toggleFavorite($uuid)
    {
        // Cari file berdasarkan UUID
        $file = FileManager::where('uuid', $uuid)->first();

        if (!$file) {
            return redirect()->back()
                ->with('error', 'File not found.');
        }

        // Cari favorit yang sudah ada
        $favorit = FileFavorite::where('user_id', auth()->id())
            ->where('file_manager_id', $file->id)
            ->first();


        if ($favorit) {
            // Jika sudah ada, maka hapus (unset)
            $favorit->delete();
            // redirect back
            return redirect()
                ->back();
        }

        // Jika belum ada, tambahkan ke favorit (set)
        $f =  FileFavorite::create([
            'uuid' => Str::uuid(),
            'user_id' => auth()->id(),
            'file_manager_id' => $file->id,
            'type' => 'favorite',
        ]);

        // redirect back
        return redirect()
            ->back();
    }

    // show file favorit
    public function showFavorite($uuid = null)
    {
        $rootDirectory = '';

        $favoritGet = FileFavorite::where('user_id', auth()->id())->get();
        $manager = FileManager::whereIn("id", $favoritGet->pluck('file_manager_id'))
            ->when(request()->has('search'), function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%')
                    ->orWhere('code_clasification', 'like', '%' . request()->search . '%');
            })
            ->get()
            ->map(function ($x) {
                $x->favorit = FileFavorite::where('user_id', auth()->id())->where('file_manager_id', $x->id)->exists();
                return $x;
            })
            ->sortBy(function ($item) {
                return $item->type === 'folder' ? 0 : 1;
            });
        $folderThis = FileManager::where("uuid", $uuid)->first();
        $paths = $folderThis ? $folderThis->getParentHierarchy()  : [];

        $parentUid =  !empty($manager) ? (
            !empty($folderThis->parent_id) ? FileManager::where("id", $folderThis->parent_id)->first()->uuid : null
        ) : null;

        return view('pages.file-manager', [
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


    // share get
    public function fileShared($uuid = null)
    {
        $rootDirectory = '';
        $fileShareInUser = FileShare::where('user_share_id', auth()->id())
            ->orderBy('created_at', 'desc') // Menampilkan data terbaru terlebih dahulu
            ->get();

        $manager = FileManager::whereIn("id", $fileShareInUser->pluck('file_manager_id'))
            ->when(request()->has('search'), function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%')
                    ->orWhere('code_clasification', 'like', '%' . request()->search . '%');
            })
            ->get()
            ->map(function ($x) {
                $x->favorit = FileFavorite::where('user_id', auth()->id())->where('file_manager_id', $x->id)->exists();
                return $x;
            })
            ->sortBy(function ($item) {
                return $item->type === 'folder' ? 0 : 1;
            });

        $folderThis = FileManager::where("uuid", $uuid)->first();
        $paths = $folderThis ? $folderThis->getParentHierarchy()  : [];

        $parentUid =  !empty($manager) ? (
            !empty($folderThis->parent_id) ? FileManager::where("id", $folderThis->parent_id)->first()->uuid : null
        ) : null;

        return view('pages.file-manager', [
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


    // public function scanStorage()
    // {
    //     $directory = 'ABC-001'; // Direktori dalam Laravel Storage
    //     $files = Storage::files($directory);
    //     $folders = Storage::disk('public')->directories($directory);
    //     foreach ($folders as $folder) {
    //         FileManager::updateOrCreate(
    //             ['paths' => $folder],
    //             [
    //                 'name' => basename($folder),
    //                 'type' => 'folder',
    //                 'visibility' => 'private',
    //                 'status' => 'active',
    //                 'user_id' => 1
    //             ]
    //         );
    //     }

    //     foreach ($files as $file) {
    //         $mimeType = Storage::mimeType($file);
    //         $size = Storage::size($file);
    //         FileManager::updateOrCreate(
    //             ['paths' => $file],
    //             [
    //                 'name' => basename($file),
    //                 'type' => 'file',
    //                 'ext' => pathinfo($file, PATHINFO_EXTENSION),
    //                 'mime' => $mimeType,
    //                 'size' => $size,
    //                 'url' => Storage::url($file),
    //                 'visibility' => 'private',
    //                 'status' => 'active',
    //                 'user_id' => 1,
    //             ]
    //         );
    //     }

    //     return response()->json(['message' => 'Storage scanned and database updated.']);
    // }

    // Mendapatkan daftar file dan folder dari database
    // public function getFiles()
    // {
    //     $files = FileManager::where('parent_id', null)->with('children')->get();
    //     return response()->json($files);
    // }
}
