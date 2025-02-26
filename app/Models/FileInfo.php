<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'user_remove_id',
        'user_edit_id',
        'file_manager_id',
        'name',
        'type',
        'value'
    ];

    /**
     * Relationship: FileInfo belongs to a User (Creator)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: FileInfo belongs to a User (Editor)
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'user_edit_id');
    }

    /**
     * Relationship: FileInfo belongs to a User (Remover)
     */
    public function remover()
    {
        return $this->belongsTo(User::class, 'user_remove_id');
    }

    /**
     * Relationship: FileInfo belongs to FileManager
     */
    public function fileManager()
    {
        return $this->belongsTo(FileManager::class, 'file_manager_id');
    }

    public static function rules(): array
    {
        return [
            'uuid' => 'required|uuid|unique:file_infos,uuid',
            'user_id' => 'required|exists:users,id',
            'file_manager_id' => 'required|exists:file_managers,id',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'value' => 'nullable|string'
        ];
    }
}
