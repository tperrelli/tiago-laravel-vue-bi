<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stocks extends Model
{
    use HasFactory, SoftDeletes;

    public function scopeBySmallName(Builder $scope, string $smallName)
    {
        return $scope->where('small_name', $smallName);
    }
}
