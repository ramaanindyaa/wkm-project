<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi (mass assignable)
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'tanggal',
        'lokasi',
        'deskripsi',
        'is_active', // Ganti status_aktif menjadi is_active
        'thumbnail',
        'venue_thumbnail',
        'bg_map',
        'price',
        'is_open',
        'has_started',
        'time_at',
        'end_date',
    ];

    /**
     * Tipe data yang di-cast
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean', // Ganti status_aktif menjadi is_active
        'is_open' => 'boolean',
        'has_started' => 'boolean',
        'price' => 'decimal:2',
        'time_at' => 'datetime:H:i',
        'end_date' => 'date',
    ];

    /**
     * Mendapatkan semua peserta (participant) untuk event ini
     * Relasi one-to-many: satu event memiliki banyak participant
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Mendapatkan semua benefits untuk event ini
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function benefits(): HasMany
    {
        return $this->hasMany(EventBenefit::class);
    }

    /**
     * Untuk kompatibilitas dengan kode lama
     * 
     * @return bool
     */
    public function getStatusAktifAttribute()
    {
        return $this->is_active;
    }
}