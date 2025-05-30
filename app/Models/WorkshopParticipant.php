<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopParticipant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'workshop_participants';

    protected $fillable = [
        'name',
        'occupation',
        'email',
        'company', // Add this line
        'workshop_id',
        'booking_transaction_id',
    ];

    public function workshop() : BelongsTo
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    public function bookingTransaction() : BelongsTo
    {
        return $this->belongsTo(BookingTransaction::class, 'booking_transaction_id');
    }
}
