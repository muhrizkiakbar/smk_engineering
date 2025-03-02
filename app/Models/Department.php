<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $table = 'departments';
    protected $attributes = [
        'visibility_telemetry' => 'public',
        'state' => 'active',
    ];
    protected $guarded = [];
    //
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
