export default function registerPathologyViewer(Alpine) {

    Alpine.data('pathologyViewer', (config) => ({

        viewer: null,

        slides: config.slides ?? [],

        initialSlideId: Number(config.initialSlideId) || null,

        activeSlideId: null,

        loading: true,

        error: null,
        reviewDecision: '',
        reviewNotes: '',


        infoController: null,


        get activeSlide() {

            return this.slides.find(
                slide => slide.id === this.activeSlideId
            ) ?? null;
        },

        get activeAnalysis() {

            return this.activeSlide?.analysis ?? null;
        },

        get activeReview() {

            return this.activeSlide?.review ?? null;
        },

        async init() {



            /*
            |--------------------------------------------------------------------------
            | Make sure viewer element exists
            |--------------------------------------------------------------------------
            */

            const viewerElement = this.$refs.viewer;

            if (!viewerElement) {
                this.loading = false;
                this.error = 'Viewer container could not be initialized.';
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Create ONE OpenSeadragon viewer
            |--------------------------------------------------------------------------
            */

            this.viewer = OpenSeadragon({

                element: viewerElement,

                showNavigationControl: false,

                showNavigator: true,
                navigatorPosition: 'BOTTOM_RIGHT',
                navigatorSizeRatio: 0.16,

                animationTime: 0.6,

                immediateRender: true,

                blendTime: 0,

                minPixelRatio: 0.5,

                maxZoomPixelRatio: 4,

                imageSmoothingEnabled: false,

                maxTilesPerFrame: 2,

                maxImageCacheCount: 400,

                imageLoaderLimit: 6,

                tileRetryMax: 2,

                tileRetryDelay: 500,

                timeout: 30000,

                constrainDuringPan: true,

                visibilityRatio: 0.8,

                gestureSettingsMouse: {
                    scrollToZoom: true,
                    clickToZoom: false,
                    dblClickToZoom: true,
                    dragToPan: true,
                },

                zoomPerScroll: 1.25,
            });


            /*
            |--------------------------------------------------------------------------
            | Make sure OpenSeadragon initialized
            |--------------------------------------------------------------------------
            */

            if (!this.viewer) {
                this.loading = false;
                this.error = 'Whole slide viewer could not be initialized.';
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Viewer events
            |--------------------------------------------------------------------------
            */

            this.viewer.addHandler(
                'open',
                () => {
                    this.loading = false;
                    this.error = null;

                    this.viewer.viewport.goHome(true);
                }
            );


            this.viewer.addHandler(
                'open-failed',
                () => {
                    this.loading = false;

                    this.error =
                        'The whole slide image could not be rendered.';
                }
            );


            this.viewer.addHandler(
                'tile-load-failed',
                (event) => {
                    console.error(
                        'Tile failed:',
                        event
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Open first slide only AFTER viewer exists
            |--------------------------------------------------------------------------
            */

            const initialSlide =
                this.slides.find(
                    slide => slide.id === this.initialSlideId
                ) ?? this.slides[0];

            await this.selectSlide(
                initialSlide.id
            );
        },

        async selectSlide(slideId) {

            /*
            |--------------------------------------------------------------------------
            | Do nothing if already active
            |--------------------------------------------------------------------------
            */

            if (
                this.activeSlideId === slideId &&
                !this.error
            ) {
                return;
            }


            const slide = this.slides.find(
                item => item.id === slideId
            );


            if (!slide) {
                return;
            }
            this.reviewDecision =
                slide.review?.decision ?? '';

            this.reviewNotes =
                slide.review?.notes ?? '';

            if (!this.viewer) {

                this.loading = false;

                this.error =
                    'The whole slide viewer is not ready yet.';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Cancel previous metadata request
            |--------------------------------------------------------------------------
            */

            if (this.infoController) {
                this.infoController.abort();
            }


            this.infoController =
                new AbortController();


            this.activeSlideId = slide.id;

            this.loading = true;

            this.error = null;


            try {

                /*
                |--------------------------------------------------------------------------
                | Get slide information through Laravel
                |--------------------------------------------------------------------------
                */

                const response = await fetch(
                    slide.infoUrl, {
                    headers: {
                        'Accept': 'application/json',
                    },

                    signal: this.infoController.signal,
                }
                );


                if (!response.ok) {

                    throw new Error(
                        'Slide information could not be loaded.'
                    );
                }


                const info =
                    await response.json();


                const maxLevel =
                    info.deep_zoom.level_count - 1;


                /*
                |--------------------------------------------------------------------------
                | Build tile source for selected slide
                |--------------------------------------------------------------------------
                */

                const tileSource = {

                    width: info.width,

                    height: info.height,

                    tileSize: info.deep_zoom.tile_size,

                    tileOverlap: 0,

                    minLevel: 0,

                    maxLevel: maxLevel,


                    getTileUrl: function (
                        level,
                        x,
                        y
                    ) {

                        return slide.tileUrl

                            .replace(
                                '__LEVEL__',
                                level
                            )

                            .replace(
                                '__COLUMN__',
                                x
                            )

                            .replace(
                                '__ROW__',
                                y
                            );
                    },
                };


                /*
                |--------------------------------------------------------------------------
                | Open selected slide in SAME viewer
                |--------------------------------------------------------------------------
                */

                this.viewer.open(
                    tileSource
                );

            } catch (exception) {

                if (
                    exception.name ===
                    'AbortError'
                ) {
                    return;
                }


                this.loading = false;

                this.error =
                    exception.message ??
                    'The slide could not be opened.';
            }
        },

        formatDate(value) {
            if (!value) {
                return '—';
            }

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) {
                return value;
            }

            return new Intl.DateTimeFormat('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
            }).format(date);
        },

        zoomIn() {

            if (!this.viewer) {
                return;
            }

            this.viewer.viewport.zoomBy(
                2
            );

            this.viewer.viewport.applyConstraints();
        },


        zoomOut() {

            if (!this.viewer) {
                return;
            }

            this.viewer.viewport.zoomBy(0.5);

            this.viewer.viewport.applyConstraints();
        },


        goHome() {

            if (!this.viewer) {
                return;
            }

            this.viewer.viewport.goHome();
        },


        toggleFullScreen() {

            if (!this.viewer) {
                return;
            }

            this.viewer.setFullScreen(
                !this.viewer.isFullPage()
            );
        },

    }));

}