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
        'thumbnail',
        'venue_thumbnail',
        'bg_map',
        'price',
        'time_at',
        'end_date',
        'is_open',
        'has_started',
        'is_active',
    ];

    /**
     * Tipe data yang di-cast
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'date',
        'is_open' => 'boolean',
        'has_started' => 'boolean',
        'is_active' => 'boolean',
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
     * Mendapatkan semua registration transactions untuk event ini
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrationTransactions(): HasMany
    {
        return $this->hasMany(EventRegistrationTransaction::class);
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
     * Get total participants from both old and new system
     */
    public function getTotalParticipantsAttribute(): int
    {
        $oldParticipants = $this->participants()->count();
        $newTransactions = $this->registrationTransactions()
            ->where('payment_status', 'approved')
            ->count();
        
        return $oldParticipants + $newTransactions;
    }

    /**
     * Get total revenue from both systems
     */
    public function getTotalRevenueAttribute(): float
    {
        $newRevenue = $this->registrationTransactions()
            ->where('payment_status', 'approved')
            ->sum('total_amount');
        
        // Asumsi revenue dari sistem lama berdasarkan jumlah participant x price
        $oldRevenue = $this->participants()
            ->where('payment_status', 'approved')
            ->count() * $this->price;
        
        return $oldRevenue + $newRevenue;
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