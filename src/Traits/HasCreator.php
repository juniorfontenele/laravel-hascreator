<?php

namespace JuniorFontenele\LaravelHascreator\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCreator
{
    protected static function bootHasCreator(): void
    {
        static::creating(function (Model $model) {
            if (config('hascreator.auto_set')) {
                $model->{config('hascreator.column_name')} = auth()->id();
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(config('hascreator.model'), config('hascreator.column_name'));
    }
}
