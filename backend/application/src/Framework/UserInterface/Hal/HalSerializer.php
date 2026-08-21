<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Hal;

use App\Foundation\Serializer\JsonSerializer;

final readonly class HalSerializer
{
    /**
     * @param array<string, mixed> $body
     * @param array<string, array{href: string, templated?: true}> $links
     */
    public function __construct(
        private string $baseUrl,
        private array $body = [],
        private array $links = [],
    ) {
    }

    public function withLink(string $rel, string $href, bool $templated = false): self
    {
        $link = ['href' => $this->baseUrl.$href];

        if ($templated === true) {
            $link['templated'] = true;
        }

        return new self($this->baseUrl, $this->body, [...$this->links, $rel => $link]);
    }

    /** @param array<string, mixed> $attributes */
    public function withResource(array $attributes): self
    {
        return new self($this->baseUrl, $attributes, $this->links);
    }

    /** @param array<array<string, mixed>> $items */
    public function withCollection(array $items, string $embeddedKey): self
    {
        return new self($this->baseUrl, ['_embedded' => [$embeddedKey => array_values($items)]], $this->links);
    }

    public function serialize(): string
    {
        $body = $this->links === [] ? $this->body : [...$this->body, '_links' => $this->links];

        return JsonSerializer::serialize($body);
    }
}
