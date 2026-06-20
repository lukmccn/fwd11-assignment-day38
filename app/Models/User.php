<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // Kolom yang boleh diisi massal.
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Kolom yang disembunyikan saat serialisasi.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting otomatis untuk atribut.
    protected $casts = [ 'password' => 'hashed' ];

    // Satu instruktur memiliki satu profil (jika dia instruktur)
    public function instructorProfile(): HasOne
    {
        return $this->hasOne(InstructorProfile::class, 'user_id');
    }

    // Kursus yang diampu oleh instruktur
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    // Enrollments sebagai student
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'user_id');
    }
}