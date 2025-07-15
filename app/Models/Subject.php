<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use HasFactory;

    // Adicione as colunas que podem ser preenchidas em massa
    protected $fillable = [
        'name',
        'workload',
        'absences_limit',
        'user_id'
    ];


    /**
     * Define a relação de que uma Matéria PERTENCE A um Usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}