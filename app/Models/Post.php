<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    // Mass assignment: hanya kolom ini yang boleh diisi lewat create()/update()
    protected $fillable = ['title', 'content', 'image'];

    /**
     * Scope pencarian: Post::search('kata')->get()
     * Mencari di judul dan isi. Memakai parameter binding, jadi aman dari SQL injection.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, function (Builder $q) use ($term) {
            $q->where(function (Builder $inner) use ($term) {
                $inner->where('title', 'like', "%{$term}%")
                      ->orWhere('content', 'like', "%{$term}%");
            });
        });
    }

    /** Accessor: $post->image_url, URL publik gambar atau null */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image ? asset('storage/' . $this->image) : null);
    }
}
