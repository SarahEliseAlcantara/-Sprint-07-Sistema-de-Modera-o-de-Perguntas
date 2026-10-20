<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pergunta extends Model
{
    use HasFactory;

    protected $fillable = ['texto', 'evento_id', 'status'];

    /**
     * Relacionamento dos usuários que votaram nesta pergunta.
     */
    public function votos(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moderacoes(): HasMany
    {
        return $this->hasMany(Moderacao::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
