<?php

namespace App\Models;

use App\Actions\GenerateCode;
use App\Traits\HasAudit;
use Illuminate\Database\Eloquent\Concerns\HasVersion7Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasAudit, HasVersion7Uuids, SoftDeletes;

    public static function booted()
    {
        static::creating(function ($model) {
            $model->code = GenerateCode::execute('PO-');
        });
    }

    public function lines()
    {
        return $this->hasMany(PurchaseOrderLine::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
