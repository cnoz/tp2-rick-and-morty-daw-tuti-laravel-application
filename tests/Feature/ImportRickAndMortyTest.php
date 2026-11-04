<?php

namespace Tests\Feature;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImportRickAndMortyTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_command_preserves_api_ids_and_relations(): void
    {
        Http::fake([
            '*/api/location' => Http::response([
                'info' => ['next' => null],
                'results' => [[
                    'id' => 20,
                    'name' => 'Earth (Replacement Dimension)',
                    'type' => 'Planet',
                    'dimension' => 'Replacement Dimension',
                ]],
            ]),
            '*/api/episode' => Http::response([
                'info' => ['next' => null],
                'results' => [[
                    'id' => 1,
                    'name' => 'Pilot',
                    'air_date' => 'December 2, 2013',
                    'episode' => 'S01E01',
                ]],
            ]),
            '*/api/character' => Http::response([
                'info' => ['next' => null],
                'results' => [[
                    'id' => 1,
                    'name' => 'Rick Sanchez',
                    'status' => 'Alive',
                    'species' => 'Human',
                    'type' => '',
                    'gender' => 'Male',
                    'image' => 'https://example.com/rick.jpg',
                    'origin' => ['url' => 'https://rickandmortyapi.com/api/location/20'],
                    'location' => ['url' => 'https://rickandmortyapi.com/api/location/20'],
                    'episode' => ['https://rickandmortyapi.com/api/episode/1'],
                ]],
            ]),
        ]);

        $this->artisan('rick-morty:import')->assertSuccessful();

        $this->assertDatabaseHas('locations', ['id' => 20]);
        $this->assertDatabaseHas('episodes', ['id' => 1]);
        $this->assertDatabaseHas('characters', [
            'id' => 1,
            'origin_location_id' => 20,
            'current_location_id' => 20,
        ]);
        $this->assertDatabaseHas('character_episode', [
            'character_id' => 1,
            'episode_id' => 1,
        ]);
        $this->assertSame('Earth (Replacement Dimension)', Character::findOrFail(1)->origin->name);
        $this->assertCount(1, Episode::findOrFail(1)->characters);
        $this->assertCount(1, Location::findOrFail(20)->currentCharacters);
        Http::assertSentCount(3);
    }
}
