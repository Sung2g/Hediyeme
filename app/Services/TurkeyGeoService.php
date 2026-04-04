<?php

namespace App\Services;

final class TurkeyGeoService
{
    /** @var array<int, array<string, mixed>>|null */
    private static ?array $rawProvinces = null;

    /**
     * @return list<array{name: string, districts: list<string>}>
     */
    public function provincesForSelect(): array
    {
        return collect($this->rawProvinces())
            ->map(fn (array $p): array => [
                'name' => $p['name'],
                'districts' => collect($p['districts'] ?? [])
                    ->pluck('name')
                    ->map(fn ($n) => (string) $n)
                    ->sort()
                    ->values()
                    ->all(),
            ])
            ->sortBy('name')
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    public function provinceNames(): array
    {
        return collect($this->rawProvinces())->pluck('name')->map(fn ($n) => (string) $n)->sort()->values()->all();
    }

    public function isValidDistrictForCity(string $city, string $district): bool
    {
        foreach ($this->rawProvinces() as $p) {
            if ($p['name'] === $city) {
                return collect($p['districts'] ?? [])->pluck('name')->contains($district);
            }
        }

        return false;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function rawProvinces(): array
    {
        if (self::$rawProvinces !== null) {
            return self::$rawProvinces;
        }

        $path = resource_path('data/turkiye_provinces.json');
        if (! is_readable($path)) {
            return self::$rawProvinces = [];
        }

        $decoded = json_decode((string) file_get_contents($path), true);
        if (! is_array($decoded)) {
            return self::$rawProvinces = [];
        }

        $data = $decoded['data'] ?? null;

        return self::$rawProvinces = is_array($data) ? $data : [];
    }
}
