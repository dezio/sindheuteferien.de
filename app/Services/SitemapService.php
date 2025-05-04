<?php
/**
 * File: SitemapService.php
 * Created: May 2025
 * Project: sindheuteferien.de
 */

namespace App\Services;

class SitemapService
{
    protected array $bundeslandMap = [];
    protected array $customItems = [];

    public function __construct(
        protected HolidayService $holidayService
    )
    {
        $this->bundeslandMap = $this->holidayService->geBundeslandMap();
    }

    public function getSitemap(): array
    {
        $sitemap = [];

        foreach ($this->bundeslandMap as $bundesland) {
            $sitemap[] = [
                'loc' => route('bundesland', ['route' => $bundesland['route']]),
                'lastmod' => now()->startOfDay()->toAtomString(),
            ];
        }

        foreach ($this->customItems as $item) {
            $sitemap[] = [
                'loc' => $item['loc'],
                'lastmod' => now()->startOfDay()->toAtomString(),
            ];
        }

        return $sitemap;
    }

    public function registerCustomItem(string $loc): void
    {
        $this->customItems[] = [
            'loc' => $loc,
            'lastmod' => now()->startOfDay()->toAtomString(),
        ];
    }
}
