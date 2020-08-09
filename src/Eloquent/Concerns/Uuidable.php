<?php

namespace BinaryCats\LaravelTenant\Eloquent\Concerns;

use Illuminate\Support\Str;

trait Uuidable
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootUuidable()
    {
        static::creating(
            function ($model) {
                // Get the field name
                $uuidFieldName = $model->getUUIDFieldName();
                // Force fill value
                $model->$uuidFieldName = Str::uuid();
            }
        );
    }

    /**
     * Resolve UUID field name.
     *
     * @return string
     */
    public function getUuidFieldName(): string
    {
        return empty($this->uuidFieldName) ? 'uuid' : $this->uuidFieldName;
    }
}
