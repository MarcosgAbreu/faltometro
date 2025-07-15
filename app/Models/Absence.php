<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Absence extends Model
{
    use HasFactory;

    // Permite o preenchimento em massa destes campos
    protected $fillable = [
        'subject_id',
        'absence_date',
        'quantity',
        'description',
    ];

    /**
     * A falta pertence a uma matéria.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}