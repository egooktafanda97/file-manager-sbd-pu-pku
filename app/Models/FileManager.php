<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class FileManager extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'code_clasification',
        'user_id',
        'user_edit_id',
        'user_remove_id',
        'name',
        'icon',
        'ext',
        'mime',
        'paths',
        'url',
        'parent_id',
        'size',
        'type',
        'visibility',
        'status',
        'visit',
        'download',
        'share',
        'like'
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($file) {
    //         $file->uuid = (string) Str::uuid(); // Generate UUID otomatis
    //     });
    // }

    public function parent()
    {
        return $this->belongsTo(FileManager::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function children()
    {
        return $this->hasMany(FileManager::class, 'parent_id', 'id')->with('children');
    }

    public function getParentHierarchy()
    {
        $parents = collect();
        $parent = $this; // Mulai dari folder ini sendiri

        while ($parent) {
            $parents->prepend($parent);
            $parent = $parent->parent; // Ambil parent berikutnya
        }

        return $parents;
    }

    // info 
    public function info()
    {
        return $this->hasMany(FileInfo::class, 'file_manager_id');
    }

    // favorite
    public function favorite()
    {
        return $this->hasMany(FileFavorite::class, 'file_manager_id');
    }
}
