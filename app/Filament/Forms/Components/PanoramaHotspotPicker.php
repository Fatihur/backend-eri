<?php

namespace App\Filament\Forms\Components;

use App\Models\PanoramaHotspot;
use App\Models\PanoramaScene;
use Filament\Forms\Components\Field;

class PanoramaHotspotPicker extends Field
{
    protected string $view = 'filament.forms.components.panorama-hotspot-picker';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (PanoramaHotspotPicker $component, $state) {
            $record = $component->getRecord();
            if ($record instanceof PanoramaScene) {
                $hotspots = $record->hotspots()->get()->map(fn ($h) => [
                    'id' => $h->id,
                    'yaw' => (float) $h->yaw,
                    'pitch' => (float) $h->pitch,
                    'target_scene_id' => $h->target_scene_id,
                    'label' => $h->label,
                ])->all();
                $component->state($hotspots);
            } else {
                $component->state([]);
            }
        });

        $this->dehydrated(true);

        $this->saveRelationshipsUsing(function (PanoramaHotspotPicker $component, $state) {
            $record = $component->getRecord();
            if (! $record instanceof PanoramaScene) {
                return;
            }

            $state = is_array($state) ? $state : [];
            $keepIds = [];

            foreach ($state as $row) {
                if (! isset($row['yaw'], $row['pitch'])) {
                    continue;
                }
                $attrs = [
                    'yaw' => (float) $row['yaw'],
                    'pitch' => (float) $row['pitch'],
                    'target_scene_id' => $row['target_scene_id'] ?? null,
                    'label' => $row['label'] ?? null,
                    'type' => 'navigation',
                ];

                if (! empty($row['id']) && $existing = PanoramaHotspot::find($row['id'])) {
                    $existing->update($attrs);
                    $keepIds[] = $existing->id;
                } else {
                    $created = $record->hotspots()->create($attrs);
                    $keepIds[] = $created->id;
                }
            }

            $record->hotspots()->whereNotIn('id', $keepIds)->delete();
        });
    }

    public function getScenes(): array
    {
        $record = $this->getRecord();
        if (! $record instanceof PanoramaScene || ! $record->story_id) {
            return [];
        }
        return PanoramaScene::where('story_id', $record->story_id)
            ->where('id', '!=', $record->id)
            ->orderBy('order')
            ->get(['id', 'title'])
            ->map(fn ($s) => ['id' => $s->id, 'title' => $s->title])
            ->all();
    }

    public function getPanoramaUrl(): ?string
    {
        $record = $this->getRecord();
        if (! $record instanceof PanoramaScene || ! $record->panorama_image) {
            return null;
        }
        return asset('storage/' . ltrim($record->panorama_image, '/'));
    }
}
