<?php

namespace App\Models;

use App\Traits\HasAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasVersion7Uuids;

class Area extends Model
{
    use HasAudit, HasVersion7Uuids, SoftDeletes;

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
