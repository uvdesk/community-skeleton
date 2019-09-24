<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Response implements \JsonSerializable
{
    private $body;
    private $origHeaders;
    private $headers;
    private $code;

    /**
     * @param mixed $body The response as JSON
     */
    public function __construct($body, array $headers = [], int $code = 200)
    {
        $this->body = $body;
        $this->origHeaders = $headers;
        $this->headers = $this->parseHeaders($headers);
        $this->code = $code;
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function getHeader(string $name): string
    {
        return $this->headers[strtolower($name)][0] ?? '';
    }

    public function getHeaders(string $name): array
    {
        return $this->headers[strtolower($name)] ?? [];
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getOrigHeaders(): array
    {
        return $this->origHeaders;
    }

    public static function fromJson(array $json): self
    {
        $response = new self($json['body']);
        $response->headers = $json['headers'];

        return $response;
    }

    public function jsonSerialize()
    {
        return ['body' => $this->body, 'headers' => $this->headers];
    }

    private function parseHeaders(array $headers): array
    {
        $values = [];
        foreach (array_reverse($headers) as $header) {
            if (preg_match('{^([^\:]+):\s*(.+?)\s*$}i', $header, $match)) {
                $values[strtolower($match[1])][] = $match[2];
            } elseif (preg_match('{^HTTP/}i', $header)) {
                break;
            }
        }

        return $values;
    }
}
