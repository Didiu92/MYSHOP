<div x-data="accessibilityPanel()" class="fixed bottom-6 right-6 z-50">
    <button
        type="button"
        @click="toggle()"
        class="flex h-12 w-12 items-center justify-center rounded-full bg-gold text-ebony shadow-lg transition hover:bg-copper hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gold"
        aria-label="Abrir ajustes de accesibilidad"
        :aria-expanded="open.toString()"
        aria-controls="accessibility-panel"
    >
        <span class="text-lg font-semibold">Aa</span>
    </button>

    <div
        id="accessibility-panel"
        x-show="open"
        x-transition
        @keydown.escape.window="close()"
        role="dialog"
        aria-modal="true"
        aria-labelledby="accessibility-title"
        class="mt-3 w-80 rounded-xl border border-gold/30 bg-graphite/95 p-5 text-silver shadow-xl"
    >
        <div class="flex items-center justify-between">
            <h2 id="accessibility-title" class="text-lg font-semibold text-gold">Accesibilidad</h2>
            <button type="button" @click="close()" class="text-silver hover:text-gold" aria-label="Cerrar panel">
                ✕
            </button>
        </div>

        <div class="mt-4 space-y-4">
            <div>
                <label class="block text-sm font-semibold text-silver">Tipografía</label>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <button type="button" @click="setFontFamily('default')" :class="buttonClass(settings.fontFamily === 'default')">Predeterminada</button>
                    <button type="button" @click="setFontFamily('hyper')" :class="buttonClass(settings.fontFamily === 'hyper')">Legible</button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-silver">Tamaño de texto</label>
                <div class="mt-2 grid grid-cols-3 gap-2">
                    <button type="button" @click="setFontSize('100%')" :class="buttonClass(settings.fontSize === '100%')">100%</button>
                    <button type="button" @click="setFontSize('112%')" :class="buttonClass(settings.fontSize === '112%')">112%</button>
                    <button type="button" @click="setFontSize('125%')" :class="buttonClass(settings.fontSize === '125%')">125%</button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-silver">Visión cromática</label>
                <select
                    class="mt-2 w-full rounded-md border border-gold/30 bg-ebony px-3 py-2 text-silver"
                    x-model="settings.filter"
                    @change="console.log('Select cambió a:', settings.filter); applyAndSave()"
                >
                    <option value="none">Sin filtro</option>
                    <option value="deuteranopia">Deuteranopia</option>
                    <option value="protanopia">Protanopia</option>
                    <option value="tritanopia">Tritanopia</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-silver">Alto contraste</span>
                <button type="button" @click="toggleContrast()" :class="toggleClass(settings.contrast)">
                    <span class="sr-only">Alternar alto contraste</span>
                    <span class="block h-5 w-5 rounded-full bg-white transition" :class="settings.contrast ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-silver">Reducir movimiento</span>
                <button type="button" @click="toggleReduceMotion()" :class="toggleClass(settings.reduceMotion)">
                    <span class="sr-only">Alternar reducir movimiento</span>
                    <span class="block h-5 w-5 rounded-full bg-white transition" :class="settings.reduceMotion ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>
            </div>
        </div>

        <div class="mt-5 flex justify-between">
            <button type="button" @click="reset()" class="text-sm text-silver underline hover:text-gold">Restablecer</button>
            <button type="button" @click="close()" class="btn-primary">Listo</button>
        </div>
    </div>


</div>