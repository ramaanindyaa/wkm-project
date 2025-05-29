<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_transaction_id',
        'nama',
        'email',
        'kontak',
        'is_ketua',
    ];

    protected $casts = [
        'is_ketua' => 'boolean',
    ];

    /**
     * Relationship dengan EventRegistrationTransaction
     */
    public function registrationTransaction(): BelongsTo
    {
        return $this->belongsTo(EventRegistrationTransaction::class, 'registration_transaction_id');
    }

    /**
     * Accessor untuk mendapatkan role anggota tim
     */
    public function getRoleAttribute(): string
    {
        return $this->is_ketua ? 'Team Leader' : 'Team Member';
    }

    /**
     * Scope untuk filter ketua tim
     */
    public function scopeLeaders($query)
    {
        return $query->where('is_ketua', true);
    }

    /**
     * Scope untuk filter anggota biasa (bukan ketua)
     */
    public function scopeMembers($query)
    {
        return $query->where('is_ketua', false);
    }

    /**
     * Method untuk mengecek apakah anggota adalah ketua
     */
    public function isLeader(): bool
    {
        return $this->is_ketua;
    }

    /**
     * Method untuk set sebagai ketua
     */
    public function setAsLeader(): void
    {
        // Unset ketua lainnya dalam tim yang sama
        self::where('registration_transaction_id', $this->registration_transaction_id)
            ->where('id', '!=', $this->id)
            ->update(['is_ketua' => false]);
        
        // Set anggota ini sebagai ketua
        $this->update(['is_ketua' => true]);
    }

    /**
     * Method untuk unset sebagai ketua
     */
    public function unsetAsLeader(): void
    {
        $this->update(['is_ketua' => false]);
    }
}
