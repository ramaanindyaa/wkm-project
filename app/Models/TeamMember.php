<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi (mass assignable)
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'participant_id',
        'nama',
        'email',
        'kontak',
        'is_ketua',
    ];

    /**
     * Tipe data yang di-cast
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'is_ketua' => 'boolean', // Pastikan field is_ketua selalu boolean
    ];

    /**
     * Mendapatkan participant yang memiliki anggota tim ini
     * Relasi many-to-one: banyak anggota tim dimiliki oleh satu participant
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * Accessor untuk mendapatkan apakah anggota tim ini adalah ketua
     * 
     * @return bool
     */
    public function getIsKaptenAttribute(): bool
    {
        return $this->is_ketua;
    }
}