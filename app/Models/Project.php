<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['id','name', 'description', 'category', 'goal_amount', 'collected_amount', 'status', 'administrator_id'];

    public function donations() {
        return $this->hasMany(Donation::class, 'project_id');
    }
}
