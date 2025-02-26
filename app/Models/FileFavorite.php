<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FileFavorite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'file_favorites';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_id',
        'file_manager_id',
        'type'
    ];

    protected $casts = [
        'type' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate UUID saat membuat data baru
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke FileManager
    public function fileManager()
    {
        return $this->belongsTo(FileManager::class, 'file_manager_id');
    }
}
