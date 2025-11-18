<?php

namespace App\Traits;

use App\Actions\Uppercase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait HasAudit
{
    public static function bootHasAudit()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id() ?? User::admin()->id;
            $model->updated_by = Auth::id() ?? User::admin()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? User::admin()->id;
        });

        static::deleting(function ($model) {
            if (Auth::check() && ! $model->isForceDeleting()) {
                $model->deleted_by = Auth::id();
                $model->saveQuietly();
            }
        });

        static::saving(function ($model) {
            $data = $model->getAttributes();
            $data = Uppercase::execute($data);
            $model->fill($data);
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
