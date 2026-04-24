@php
    $statePath = $getStatePath();
    $panoramaUrl = $getPanoramaUrl();
    $scenes = $getScenes();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @if (! $panoramaUrl)
        <div class="fi-in-panorama-empty rounded-lg border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
            Upload & simpan gambar panorama terlebih dahulu, kemudian buka kembali scene ini untuk memasang hotspot panah.
        </div>
    @else
        <div
            x-data="panoramaHotspotPicker({
                statePath: @js($statePath),
                panoramaUrl: @js($panoramaUrl),
                scenes: @js($scenes),
                initial: $wire.get(@js($statePath)) ?? [],
            })"
            x-init="init()"
            wire:ignore
            class="fi-in-panorama"
        >
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
            <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js" defer></script>

            <div class="flex items-center justify-between gap-2 pb-2">
                <p class="text-xs text-gray-500">
                    <strong>Klik panorama</strong> untuk menambah panah. Lalu pilih scene tujuan di panel kanan.
                </p>
                <button type="button" @click="clearAll" class="text-xs text-red-600 hover:underline">
                    Hapus semua
                </button>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2 relative overflow-hidden rounded-xl border border-gray-200" style="height: 420px;">
                    <div :id="viewerId" class="w-full h-full"></div>
                </div>

                <div class="col-span-1 space-y-2 max-h-[420px] overflow-y-auto pr-1">
                    <template x-for="(h, idx) in hotspots" :key="idx">
                        <div class="rounded-lg border border-gray-200 p-2 space-y-1 bg-white">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>Panah #<span x-text="idx + 1"></span></span>
                                <button type="button" class="text-red-500 hover:underline" @click="removeHotspot(idx)">Hapus</button>
                            </div>
                            <div class="text-xs">
                                yaw: <span x-text="Number(h.yaw).toFixed(1)"></span>°,
                                pitch: <span x-text="Number(h.pitch).toFixed(1)"></span>°
                            </div>
                            <label class="block text-xs text-gray-600">Scene tujuan</label>
                            <select class="w-full text-xs rounded border-gray-300" x-model="h.target_scene_id" @change="sync()">
                                <option :value="null">— (tanpa navigasi) —</option>
                                <template x-for="s in scenes" :key="s.id">
                                    <option :value="s.id" x-text="s.title"></option>
                                </template>
                            </select>
                            <label class="block text-xs text-gray-600">Label (opsional)</label>
                            <input type="text" class="w-full text-xs rounded border-gray-300" x-model="h.label" @input="sync()"/>
                        </div>
                    </template>
                    <div x-show="hotspots.length === 0" class="text-xs text-gray-500 italic text-center py-4">
                        Belum ada panah. Klik panorama untuk menambah.
                    </div>
                </div>
            </div>
        </div>

        <script>
            function panoramaHotspotPicker(cfg) {
                return {
                    viewerId: 'pano_' + Math.random().toString(36).slice(2, 8),
                    hotspots: [],
                    scenes: cfg.scenes || [],
                    viewer: null,

                    init() {
                        this.hotspots = Array.isArray(cfg.initial) ? cfg.initial.map(h => ({...h})) : [];

                        const start = () => {
                            if (!window.pannellum) { setTimeout(start, 100); return; }
                            this.viewer = pannellum.viewer(this.viewerId, {
                                type: 'equirectangular',
                                panorama: cfg.panoramaUrl,
                                autoLoad: true,
                                showControls: true,
                                mouseZoom: true,
                            });
                            this.viewer.on('mousedown', (e) => { this._downAt = Date.now(); });
                            this.viewer.on('mouseup', (e) => {
                                if (Date.now() - (this._downAt || 0) > 250) return;
                                const coords = this.viewer.mouseEventToCoords(e);
                                if (!coords) return;
                                this.addHotspot(coords[0], coords[1]);
                            });
                            this.renderViewerHotspots();
                        };
                        start();
                    },

                    renderViewerHotspots() {
                        if (!this.viewer) return;
                        (this.viewer.getConfig().hotSpots || []).slice().forEach(h => {
                            this.viewer.removeHotSpot(h.id);
                        });
                        this.hotspots.forEach((h, idx) => {
                            this.viewer.addHotSpot({
                                id: 'hs_' + idx,
                                pitch: Number(h.pitch),
                                yaw: Number(h.yaw),
                                type: 'info',
                                text: h.label || ('Panah ' + (idx + 1)),
                            });
                        });
                    },

                    addHotspot(pitch, yaw) {
                        this.hotspots.push({
                            yaw: yaw,
                            pitch: pitch,
                            target_scene_id: null,
                            label: '',
                        });
                        this.sync();
                        this.renderViewerHotspots();
                    },

                    removeHotspot(idx) {
                        this.hotspots.splice(idx, 1);
                        this.sync();
                        this.renderViewerHotspots();
                    },

                    clearAll() {
                        this.hotspots = [];
                        this.sync();
                        this.renderViewerHotspots();
                    },

                    sync() {
                        $wire.set(cfg.statePath, this.hotspots, false);
                    },
                };
            }
        </script>
    @endif
</x-dynamic-component>
