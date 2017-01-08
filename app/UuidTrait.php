<?php

namespace App;

use Webpatser\Uuid\Uuid;

/**
 * The UuidTrait will transform the PK of a model to a proper UUID.
 */
trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $uuid = Uuid::generate(4);
            $model->{$model->getKeyName()} = $uuid->string;
        });
    }
}
