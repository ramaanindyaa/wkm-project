<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventBenefit extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi (mass assignable)
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'name',
    ];

    /**
     * Mendapatkan event yang terkait dengan benefit ini
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
