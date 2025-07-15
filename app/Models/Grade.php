<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'name',
        'weight',
        'value',
    ];
    
    /**
     * O tipo de dados das colunas.
     */
    protected $casts = [
        'weight' => 'decimal:2',
        'value' => 'decimal:2',
    ];

    /**
     * Uma avaliação pertence a uma matéria.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}