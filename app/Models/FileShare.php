<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FileShare extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'file_shares';

    protected $fillable = [
        'uuid',
        'user_id',
        'user_remove_id',
        'user_share_id',
        'file_manager_id',
        'type'
    ];

    protected $casts = [
        'type' => 'string',
    ];

    /**
     * Boot function to auto-generate UUID on creation.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke model User (User yang menambahkan share).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model User (User yang menghapus share).
     */
    public function userRemove()
    {
        return $this->belongsTo(User::class, 'user_remove_id');
    }

    /**
     * Relasi ke model User (User yang menerima share).
     */
    public function userShare()
    {
        return $this->belongsTo(User::class, 'user_share_id');
    }

    /**
     * Relasi ke model FileManager.
     */
    public function file()
    {
        return $this->belongsTo(FileManager::class, 'file_manager_id');
    }

    /**
     * Cek apakah share ini adalah tipe 'view'.
     */
    public function isViewOnly()
    {
        return $this->type === 'view';
    }

    /**
     * Cek apakah share ini adalah tipe 'edit'.
     */
    public function isEditable()
    {
        return $this->type === 'edit';
    }
}
