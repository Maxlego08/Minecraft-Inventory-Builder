<?php

namespace App\Utils\Discord;

use App\Utils\Discord\Embeds\EmbedAuthor;
use App\Utils\Discord\Embeds\EmbedField;
use App\Utils\Discord\Embeds\EmbedFooter;
use App\Utils\Discord\Embeds\EmbedThumbnail;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use InvalidArgumentException;
use function PHPUnit\Framework\isEmpty;

class Embed implements Arrayable
{
    /**
     * Title of the embed.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Description of embed.
     *
     * @var string|null
     */
    protected $description;

    /**
     * Url of embed.
     *
     * @var string|null
     */
    protected $url;

    /**
     * Timestamp of embed content.
     *
     * @var \Carbon\CarbonInterface|null
     */
    protected $timestamp;

    /**
     * Color code of the embed.
     *
     * @var int|null
     */
    protected $color;

    /**
     * Footer information.
     *
     * @var \App\Utils\Discord\Embeds\EmbedFooter|null
     */
    protected $footer;

    /**
     * Thumbnail information.
     *
     * @var \App\Utils\Discord\Embeds\EmbedThumbnail|null
     */
    protected $thumbnail;

    /**
     * Author information.
     *
     * @var \App\Utils\Discord\Embeds\EmbedAuthor|null
     */
    protected $author;

    /**
     * Fields information.
     *
     * @var \App\Utils\Discord\Embeds\EmbedFooter[]|null
     */
    protected $fields = [];

    /**
     * Create a new message instance.
     *
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Set the title of the embed.
     *
     * @param string|null $title
     * @return $this
     */
    public function title(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the description of embed.
     *
     * @param string|null $description
     * @return $this
     */
    public function description(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the Url of embed.
     *
     * @param string|null $url
     * @return $this
     */
    public function url(?string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the timestamp of embed content.
     *
     * @param \DateTimeInterface|null $timestamp
     * @return $this
     */
    public function timestamp(?DateTimeInterface $timestamp)
    {
        $this->timestamp = Carbon::instance($timestamp);

        return $this;
    }

    /**
     * Set the color code of the embed.
     *
     * @param string|int|null $color
     * @return $this
     */
    public function color($color)
    {
        if (is_string($color) && Str::startsWith($color, '#')) {
            $this->color = (int)hexdec(Str::substr($color, 1));

            return $this;
        }

        if (!is_numeric($color)) {
            throw new InvalidArgumentException('Color format must be hex or decimal.');
        }

        $this->color = (int)$color;

        return $this;
    }

    /**
     * Set the footer of the embed.
     *
     * @param string $text
     * @param string|null $iconUrl
     * @return $this
     */
    public function footer(string $text, string $iconUrl = null)
    {
        $this->footer = new EmbedFooter($text, $iconUrl);

        return $this;
    }

    /**
     * Set the thumbnail of the embed.
     *
     * @param string|null $url
     * @return $this
     */
    public function thumbnail(?string $url)
    {
        $this->thumbnail = new EmbedThumbnail($url);

        return $this;
    }

    /**
     * Set the author of the embed.
     *
     * @param string|null $name
     * @param string $url
     * @param string $iconUrl
     * @return $this
     */
    public function author(?string $name, string $url = null, string $iconUrl = null)
    {
        $this->author = new EmbedAuthor($name, $url, $iconUrl);

        return $this;
    }

    /**
     * Add a field to the embed.
     *
     * @param string $name
     * @param string $value
     * @param bool $inline
     * @return $this
     */
    public function addField(string $name, string $value, bool $inline = false)
    {
        $this->fields[] = new EmbedField($name, $value, $inline);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $values = [
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'timestamp' => optional($this->timestamp)->toAtomString(),
            'color' => $this->color,
            'footer' => optional($this->footer)->toArray(),
            'thumbnail' => optional($this->thumbnail)->toArray(),
            'author' => optional($this->author)->toArray(),
        ];
        if (count($this->fields) > 0) {
            $values['fields'] = array_map(function (EmbedField $field) {
                return $field->toArray();
            }, $this->fields);
        }
        return array_filter($values, function ($valeur) {
            return !is_null($valeur);
        });
    }

    public function isValid(): bool
    {
        if ($this->title != null)
            return true;
        if ($this->description != null)
            return true;
        if ($this->url != null)
            return true;
        if ($this->timestamp != null)
            return true;
        if ($this->color != null)
            return true;
        if ($this->footer != null)
            return true;
        if ($this->author != null)
            return true;
        if ($this->fields != null && !isEmpty($this->fields))
            return true;
        return false;
    }
}
