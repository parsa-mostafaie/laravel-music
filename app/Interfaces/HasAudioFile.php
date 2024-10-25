<?php
namespace App\Interfaces;

interface HasAudioFile
{
  public function removePreviousFile(): bool;

  public function removeFile(): bool;

  public function getFileMimeAttribute(): bool|string|null;

  public function getTimeStringAttribute(): string;

  public function getFileUrlAttribute(): string|null;
}