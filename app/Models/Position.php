<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'supervisor_id',
        'position_name'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function supervisor() {
        return $this->belongsTo(Position::class, 'supervisor_id');
    }

    public function subordinates() {
        return $this->hasMany(Position::class, 'supervisor_id');
    }
}
