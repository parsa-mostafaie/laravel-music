<?php

namespace App\Interfaces;

/**
 * @property $image
 */
interface HasImage
{
    public function getImageUrlAttribute(): string|null;

    public function getAlternativeImage(): string|null;

    public function removePreviousImage(): bool;

    public function removeImage(): bool;
}
