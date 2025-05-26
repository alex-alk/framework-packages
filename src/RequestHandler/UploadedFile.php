<?php

namespace App;

use Framework\RequestHandler\Stream;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\StreamInterface;

class UploadedFile implements UploadedFileInterface
{
    private string $file;
    private int $size;
    private int $error;
    private string $clientFilename;
    private string $clientMediaType;
    private bool $moved = false;

    public function __construct(
        string $file,
        int $size,
        int $error,
        string $clientFilename,
        string $clientMediaType
    ) {
        $this->file = $file;
        $this->size = $size;
        $this->error = $error;
        $this->clientFilename = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    public function getStream(): StreamInterface
    {
        if ($this->moved) {
            throw new \RuntimeException("File already moved");
        }
        return new Stream(fopen($this->file, 'rb'));
    }

    public function moveTo($targetPath): void
    {
        if ($this->moved) {
            throw new \RuntimeException("File already moved");
        }
        if (!is_uploaded_file($this->file) || !move_uploaded_file($this->file, $targetPath)) {
            throw new \RuntimeException("Failed to move uploaded file");
        }
        $this->moved = true;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getClientFilename(): ?string
    {
        return $this->clientFilename;
    }

    public function getClientMediaType(): ?string
    {
        return $this->clientMediaType;
    }
}