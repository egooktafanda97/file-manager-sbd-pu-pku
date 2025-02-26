<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileViewr extends Model
{
    public $table = 'file_viewrs';

    protected $fillable = [
        'uuid',
        'user_id',
        'file_id',
    ];


    public function file()
    {
        return $this->belongsTo(FileManager::class, 'file_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
