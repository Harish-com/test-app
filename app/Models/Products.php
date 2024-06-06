<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use Carbon\Carbon;

class Products extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'name',
            'categories_id',
            'description',
            'price',
            'qty',
            'status',
    ];

    public function getProductStatusAttribute() {
        $status = 'Active';
        if ($this->status == 0) {
            $status = 'Block';
        }
        return $status;
    }

}
