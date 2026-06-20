<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstructorProfile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Primary key bukan auto-increment.
     */
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = [
        'user_id',
        'bio',
        'expertise',
        'phone',
    ];

    /**
     * Relasi balik ke User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}