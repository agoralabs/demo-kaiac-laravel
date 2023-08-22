<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'name', 
        'priority', 
        'status', 
        'description', 
        'scheduled_at'
    ];

    /**
     * Get the user associated with the task.
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
