/**
 * Navbar canli urun aramasi (min 3 karakter).
 */
document.addEventListener('alpine:init', () => {
    window.Alpine.data('shopSearchNav', (config) => ({
        mobileSearch: false,
        mobileMenu: false,
        q: config.initialQ ?? '',
        searchUrl: config.searchUrl,
        productsIndexUrl: config.productsIndexUrl,
        minChars: 3,
        debounceMs: 320,
        debounceTimer: null,
        panelOpen: false,
        mobilePanelOpen: false,
        suggestState: 'idle',
        results: [],
        allResultsUrl: '',
        loading: false,

        onSearchInput(isMobile = false) {
            clearTimeout(this.debounceTimer);
            const v = (this.q || '').trim();

            if (v.length === 0) {
                this.results = [];
                this.suggestState = 'idle';
                this.panelOpen = false;
                this.mobilePanelOpen = false;
                return;
            }

            if (v.length < this.minChars) {
                this.results = [];
                this.suggestState = 'short';
                this.panelOpen = true;
                this.mobilePanelOpen = isMobile ? true : this.mobilePanelOpen;
                return;
            }

            this.debounceTimer = setTimeout(() => this.fetchSuggestions(v, isMobile), this.debounceMs);
        },

        onSearchFocus(isMobile = false) {
            const v = (this.q || '').trim();
            if (v.length === 0) {
                return;
            }
            if (v.length < this.minChars) {
                this.suggestState = 'short';
                this.panelOpen = !isMobile;
                this.mobilePanelOpen = isMobile;
                return;
            }
            this.fetchSuggestions(v, isMobile);
        },

        async fetchSuggestions(v, isMobile = false) {
            this.loading = true;
            this.suggestState = 'loading';
            this.panelOpen = !isMobile;
            this.mobilePanelOpen = isMobile;

            try {
                const url = `${this.searchUrl}?q=${encodeURIComponent(v)}`;
                const res = await fetch(url, {
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                if (!res.ok) {
                    throw new Error('network');
                }
                const data = await res.json();
                this.results = data.products || [];
                this.allResultsUrl = data.all_results_url || `${this.productsIndexUrl}?q=${encodeURIComponent(v)}`;
                this.suggestState = this.results.length ? 'results' : 'empty';
            } catch {
                this.suggestState = 'error';
                this.results = [];
            } finally {
                this.loading = false;
            }
        },

        closePanels() {
            this.panelOpen = false;
            this.mobilePanelOpen = false;
        },

        onSubmitSearch(e) {
            const v = (this.q || '').trim();
            if (v.length > 0 && v.length < this.minChars) {
                e.preventDefault();
                this.suggestState = 'short';
                this.panelOpen = true;
                this.mobilePanelOpen = false;
            }
        },

        pickResult() {
            this.closePanels();
        },
    }));
});
