<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'description',
        'photo'
    ];

    public function getCategoriesStatusAttribute() {
        $status = 'Active';
        if ($this->status == 0) {
            $status = 'Block';
        }
        return $status;
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

}
