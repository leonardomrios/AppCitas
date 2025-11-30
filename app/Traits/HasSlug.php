<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait and register model events.
     */
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->getSlugSource());
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSlugSourceColumn()) && empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->getSlugSource());
            }
        });
    }

    /**
     * Generate a unique slug from the given source.
     */
    protected static function generateUniqueSlug(string $source): string
    {
        $slug = Str::slug($source);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the source column for slug generation.
     */
    protected function getSlugSourceColumn(): string
    {
        return 'name';
    }

    /**
     * Get the source value for slug generation.
     */
    protected function getSlugSource(): string
    {
        $column = $this->getSlugSourceColumn();
        return $this->{$column} ?? '';
    }

    /**
     * Get the route key name for model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

