<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventRegistrationTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_trx_id',
        'is_paid',
        'name',
        'email',
        'phone',
        'company',
        'event_id',
        'kategori_pendaftaran',
        'jenis_pendaftaran',
        'payment_status',
        'total_amount',
        'customer_bank_name',
        'customer_bank_account',
        'customer_bank_number',
        'payment_proof',
        'google_drive_makalah',
        'google_drive_lampiran',
        'google_drive_video_sebelum',
        'google_drive_video_sesudah',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Boot method untuk auto-generate registration_trx_id
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->registration_trx_id)) {
                $model->registration_trx_id = $model->generateRegistrationTrxId();
            }
        });
    }

    /**
     * Generate unique registration transaction ID
     */
    public function generateRegistrationTrxId(): string
    {
        do {
            $trxId = 'EVT' . date('Ymd') . Str::upper(Str::random(6));
        } while (self::where('registration_trx_id', $trxId)->exists());

        return $trxId;
    }

    /**
     * Relationship dengan Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relationship dengan TeamMembers
     */
    public function teamMembers()
    {
        return $this->hasMany(EventTeamMember::class, 'registration_transaction_id');
    }

    /**
     * Get team leader
     */
    public function getTeamLeader()
    {
        return $this->teamMembers()->where('is_ketua', true)->first();
    }

    /**
     * Get team members (excluding leader)
     */
    public function getTeamMembersOnly()
    {
        return $this->teamMembers()->where('is_ketua', false)->get();
    }

    /**
     * Check if registration is team type
     */
    public function isTeamRegistration(): bool
    {
        return $this->jenis_pendaftaran === 'tim';
    }

    /**
     * Check if registration is individual type
     */
    public function isIndividualRegistration(): bool
    {
        return $this->jenis_pendaftaran === 'individu';
    }

    /**
     * Check if registration is competition category
     */
    public function isCompetition(): bool
    {
        return $this->kategori_pendaftaran === 'kompetisi';
    }

    /**
     * Accessor untuk format kategori pendaftaran
     */
    public function getKategoriPendaftaranLabelAttribute(): string
    {
        return match($this->kategori_pendaftaran) {
            'observer' => 'Observer',
            'kompetisi' => 'Competition',
            'undangan' => 'Invitation',
            default => ucfirst($this->kategori_pendaftaran)
        };
    }

    /**
     * Accessor untuk format jenis pendaftaran
     */
    public function getJenisPendaftaranLabelAttribute(): string
    {
        return match($this->jenis_pendaftaran) {
            'individu' => 'Individual',
            'tim' => 'Team',
            default => ucfirst($this->jenis_pendaftaran)
        };
    }

    /**
     * Accessor untuk format payment status
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'Pending Verification',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default => ucfirst($this->payment_status)
        };
    }

    /**
     * Scope untuk filter berdasarkan payment status
     */
    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('payment_status', 'approved');
    }

    /**
     * Check if documents are complete for competition category
     */
    public function getDocumentsCompleteAttribute(): bool
    {
        if ($this->kategori_pendaftaran === 'kompetisi' && $this->payment_status === 'approved') {
            return !empty($this->google_drive_makalah) && 
                   !empty($this->google_drive_lampiran) && 
                   !empty($this->google_drive_video_sebelum) && 
                   !empty($this->google_drive_video_sesudah);
        }
        
        return true; // Not applicable for non-competition categories
    }

    /**
     * Calculate team size
     */
    public function getTeamSizeAttribute(): int
    {
        return $this->isTeamRegistration() ? $this->teamMembers()->count() : 1;
    }

    /**
     * Get total registration amount with calculation
     */
    public function calculateTotalAmount(): float
    {
        $basePrice = $this->event->price ?? 0;
        $teamSize = $this->team_size;
        $subtotal = $basePrice * $teamSize;
        $tax = $subtotal * 0.11; // PPN 11%
        
        return $subtotal + $tax;
    }

    /**
     * Update total amount based on team size
     */
    public function updateTotalAmount(): void
    {
        $this->update([
            'total_amount' => $this->calculateTotalAmount()
        ]);
    }
}
