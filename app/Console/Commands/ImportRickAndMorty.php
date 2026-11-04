<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Location;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class ImportRickAndMorty extends Command
{
    protected $signature = 'rick-morty:import {--fresh : Elimina los datos anteriores antes de importar}';

    protected $description = 'Importa ubicaciones, episodios y personajes desde la API de Rick and Morty';

    public function handle(): int
    {
        try {
            $this->info('Consultando la API de Rick and Morty...');

            $locations = $this->fetchAll('location');
            $episodes = $this->fetchAll('episode');
            $characters = $this->fetchAll('character');

            DB::transaction(function () use ($locations, $episodes, $characters): void {
                if ($this->option('fresh')) {
                    DB::table('character_episode')->delete();
                    Character::query()->delete();
                    Episode::query()->delete();
                    Location::query()->delete();
                }

                Location::query()->upsert(
                    collect($locations)->map(fn (array $location): array => [
                        'id' => $location['id'],
                        'name' => $location['name'],
                        'type' => $location['type'],
                        'dimension' => $location['dimension'],
                    ])->all(),
                    ['id'],
                    ['name', 'type', 'dimension'],
                );

                Episode::query()->upsert(
                    collect($episodes)->map(fn (array $episode): array => [
                        'id' => $episode['id'],
                        'name' => $episode['name'],
                        'air_date' => $episode['air_date'],
                        'episode' => $episode['episode'],
                    ])->all(),
                    ['id'],
                    ['name', 'air_date', 'episode'],
                );

                foreach ($characters as $characterData) {
                    $character = Character::query()->updateOrCreate(
                        ['id' => $characterData['id']],
                        [
                            'name' => $characterData['name'],
                            'status' => $characterData['status'],
                            'species' => $characterData['species'],
                            'type' => $characterData['type'],
                            'gender' => $characterData['gender'],
                            'image' => $characterData['image'],
                            'origin_location_id' => $this->idFromUrl($characterData['origin']['url']),
                            'current_location_id' => $this->idFromUrl($characterData['location']['url']),
                        ],
                    );

                    $episodeIds = collect($characterData['episode'])
                        ->map(fn (string $url): ?int => $this->idFromUrl($url))
                        ->filter()
                        ->all();

                    $character->episodes()->sync($episodeIds);
                }
            });

            $this->info(sprintf(
                'Importación completa: %d ubicaciones, %d episodios y %d personajes.',
                count($locations),
                count($episodes),
                count($characters),
            ));

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('No se pudo completar la importación: '.$exception->getMessage());

            return self::FAILURE;
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchAll(string $resource): array
    {
        $results = [];
        $nextUrl = "https://rickandmortyapi.com/api/{$resource}";

        while ($nextUrl !== null) {
            $data = Http::retry([1000, 2000, 4000])
                ->timeout(30)
                ->get($nextUrl)
                ->throw()
                ->json();

            $results = array_merge($results, $data['results']);
            $nextUrl = $data['info']['next'];

            if (! app()->runningUnitTests()) {
                usleep(250_000);
            }
        }

        return $results;
    }

    private function idFromUrl(string $url): ?int
    {
        if ($url === '') {
            return null;
        }

        return (int) basename($url);
    }
}
