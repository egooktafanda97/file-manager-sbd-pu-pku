<?php

namespace App\Http\Controllers;

use App\Models\FileFavorite;
use App\Models\FileManager;
use App\Models\FileShare;
use App\Models\FileViewr;
use Illuminate\Cache\Events\RetrievingKey;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $getFileCurrent = FileViewr::where('user_id', auth()->id())
            ->where('created_at', '>=', now()->toDateString())
            ->with('file')
            ->orderBy('created_at', 'desc')
            ->get();
        $user = auth()->user(); // Ambil user yang sedang login
        $accessible = $this->getAccessibleFolders($user);

        $cointing = [
            "drive" => $accessible->count() ?? 0,
            "favorit" => $this->getFavorit()?->count() ?? 0,
            "share" => $this->getShare()?->count() ?? 0
        ];
        return view('pages.dashboard', [
            'current_file' => $getFileCurrent,
            "widget" => $cointing
        ]);
    }

    public function getAccessibleFolders($user)
    {
        $userPermissions = $user->getAllPermissions()->pluck('name');

        $accessibleItems = FileManager::where(function ($Q) use ($userPermissions, $user) {
            return $Q->whereIn('code_clasification', $userPermissions)
                ->orWhere('visibility', 'public')
                ->orWhere('user_id', $user->id);
        })
            ->where("type", "file")
            ->get();

        return  $accessibleItems;
    }

    public function getFavorit()
    {
        $favoritGet = FileFavorite::where('user_id', auth()->id())->get();
        $fv = FileManager::whereIn("id", $favoritGet->pluck('file_manager_id'))
            ->when(request()->has('search'), function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%')
                    ->orWhere('code_clasification', 'like', '%' . request()->search . '%');
            })
            ->get();
        return $fv;
    }

    public function getShare()
    {
        $fileShareInUser = FileShare::where('user_share_id', auth()->id())
            ->orderBy('created_at', 'desc') // Menampilkan data terbaru terlebih dahulu
            ->get();

        $manager = FileManager::whereIn("id", $fileShareInUser->pluck('file_manager_id'))
            ->when(request()->has('search'), function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%')
                    ->orWhere('code_clasification', 'like', '%' . request()->search . '%');
            })
            ->get();
        return $manager;
    }
}
