<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\TranslationLoader\LanguageLine;
use App\Models\Service;
use DomainException;

class Units extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['translation_group', 'translation_key'];

    protected $appends = ['name'];

    public function delete(): void
    {
        if ($this->services()->exists()) {
            throw new DomainException(
                'Unit is assigned to services.'
            );
        }
        
        parent::delete();
    }

    public function getNameAttribute(): string
    {
        return __(
            "{$this->translation_group}.{$this->translation_key}.name"
        );
    }

    /**
     * Get translation for a specific language
     */
    public function getTranslation(string $key, string $locale = 'en'): ?string
    {
        $line = LanguageLine::where([
            'group' => $this->translation_group,
            'key' => "{$this->translation_key}.{$key}",
        ])->first();

        if (!$line) {
            return null;
        }

        return $line->text[$locale] ?? null;
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'unit_id');
    }
}
