<?php
/**
 * File: PageService.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace App\Services;

class PageService
{
    protected string $appName = "";
    protected string $title = "";
    protected string $description = "";
    protected string $author = "";
    protected string $keywords = "";

    public function __construct(
        string $appName = ""
    )
    {
        $this->appName = $appName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function hasTitle() : bool
    {
        return !empty($this->title);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getKeywords(): string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function setAppName(string $appName): self
    {
        $this->appName = $appName;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'appName' => $this->appName,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author,
            'keywords' => $this->keywords,
        ];
    }
}
