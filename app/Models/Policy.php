<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'policy_no',
        'policy_status',
        'policy_type',
        'policy_effective_date',
        'policy_expiration_date',
        'policy_holder',
        'drivers',
        'vehicles',
    ];

    protected $casts = [
        'policy_effective_date' => 'date',
        'policy_expiration_date' => 'date',
        'policy_holder' => 'array',
        'drivers' => 'array',
        'vehicles' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($policy) {
            if (!$policy->policy_no) {
                $policy->policy_no = 'POL-' . strtoupper(Str::random(10));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('policy_status', 'Active');
    }

    public function scopeExpired($query)
    {
        return $query->where('policy_expiration_date', '<', now());
    }

    public function getPolicyHolderNameAttribute()
    {
        $holder = $this->policy_holder;
        return ($holder['firstName'] ?? '') . ' ' . ($holder['lastName'] ?? '');
    }
}
