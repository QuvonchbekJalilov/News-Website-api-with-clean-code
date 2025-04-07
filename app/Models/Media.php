<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_path',
        'file_type',
        'alt_text',
        'caption',
        'uploaded_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
