<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi (mass assignable)
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'kategori_pendaftaran',
        'jenis_pendaftaran',
        'payment_status',
        'google_drive_makalah',
        'google_drive_lampiran',
        'google_drive_video_sebelum',
        'google_drive_video_sesudah',
    ];

    /**
     * Tipe data yang di-cast
     * 
     * @var array<string, string>
     */
    protected $casts = [
        // Casting enum fields untuk validasi internal
        'kategori_pendaftaran' => 'string',
        'jenis_pendaftaran' => 'string',
        'payment_status' => 'string',
    ];

    /**
     * Mendapatkan event yang terkait dengan participant ini
     * Relasi many-to-one: banyak participant dimiliki oleh satu event
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Mendapatkan semua anggota tim untuk participant (jika pendaftaran tim)
     * Relasi one-to-many: satu participant jenis tim memiliki banyak team member
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * Method helper untuk mengecek apakah participant berjenis pendaftaran tim
     * 
     * @return bool
     */
    public function isTeam(): bool
    {
        return $this->jenis_pendaftaran === 'tim';
    }
}