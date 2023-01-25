<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    public $fillable = ['name','email','coordinate_y','coordinate_x','image'];

    /**
     * @return HasMany
     * @description get all posts for the company
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
