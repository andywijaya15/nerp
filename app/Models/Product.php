<?php

namespace App\Models;

use App\Traits\HasAudit;
use Illuminate\Database\Eloquent\Concerns\HasVersion7Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasAudit, HasVersion7Uuids, SoftDeletes;

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
