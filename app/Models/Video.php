<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Video extends Model {
    protected $fillable=['title','url','is_active'];
    protected $casts=['is_active'=>'boolean'];
    public static function extractVideoId(?string $url): ?string
    {
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) return null;
        $parts = parse_url($url);
        $host = strtolower($parts['host'] ?? '');
        $host = preg_replace('/^www\./', '', $host);
        if (!in_array($host, ['youtube.com', 'm.youtube.com', 'youtube-nocookie.com', 'youtu.be'], true)) return null;
        $path = trim($parts['path'] ?? '', '/');
        $id = null;
        if ($host === 'youtu.be') {
            $id = explode('/', $path)[0] ?? null;
        } elseif (preg_match('#^(?:embed|shorts|live)/([^/?]+)#', $path, $match)) {
            $id = $match[1];
        } elseif ($path === 'watch') {
            parse_str($parts['query'] ?? '', $query);
            $id = $query['v'] ?? null;
        }
        return is_string($id) && preg_match('/^[A-Za-z0-9_-]{11}$/', $id) ? $id : null;
    }

    public static function isShortsUrl(?string $url): bool
    {
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $parts = parse_url($url);
        $host = strtolower(preg_replace('/^www\./', '', $parts['host'] ?? ''));

        return in_array($host, ['youtube.com', 'm.youtube.com', 'youtube-nocookie.com'], true)
            && preg_match('#^/?shorts(?:/|$)#i', $parts['path'] ?? '') === 1;
    }

    public function getVideoIdAttribute(): ?string
    {
        return self::extractVideoId($this->url);
    }

    public function getIsShortsAttribute(): bool
    {
        return self::isShortsUrl($this->url);
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if (! $this->video_id) {
            return null;
        }

        // YouTube requires the same video in `playlist` for iframe looping.
        return 'https://www.youtube.com/embed/' . $this->video_id
            . '?autoplay=1&mute=1&loop=1&playlist=' . $this->video_id
            . '&playsinline=1&rel=0';
    }

    public function getWatchUrlAttribute(): ?string
    {
        return $this->video_id ? 'https://www.youtube.com/watch?v=' . $this->video_id : null;
    }

}
