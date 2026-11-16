from io import BytesIO
from pydantic import BaseModel
from .inference import analyze_slide
from pathlib import Path

from fastapi import FastAPI, HTTPException, Query
from fastapi.responses import Response
from openslide import OpenSlide, OpenSlideUnsupportedFormatError
from openslide.deepzoom import DeepZoomGenerator


app = FastAPI(
    title="Pathology WSI Service",
    version="1.0.0",
)

class AnalysisRequest(BaseModel):
    storage_path: str

# ---------------------------------------------------------
# Paths
# ---------------------------------------------------------

LARAVEL_ROOT = Path(__file__).resolve().parent.parent.parent

SLIDE_ROOT = (
    LARAVEL_ROOT
    / "storage"
    / "app"
    / "private"
).resolve()

SERVICE_ROOT = Path(__file__).resolve().parent.parent


MODEL_PATH = (
    SERVICE_ROOT
    / "model"
    / "mil_effnet_maxpooling_best_model.pth"
).resolve()





MODEL_VERSION = "EffNet-MaxPooling-v1"


# ---------------------------------------------------------
# Viewer configuration
# ---------------------------------------------------------

TILE_SIZE = 256


# ---------------------------------------------------------
# Helpers
# ---------------------------------------------------------

def resolve_slide_path(relative_path: str) -> Path:
    normalized_path = relative_path.replace("\\", "/").lstrip("/")

    requested_path = (
        SLIDE_ROOT / normalized_path
    ).resolve()

    try:
        requested_path.relative_to(SLIDE_ROOT)
    except ValueError:
        raise HTTPException(
            status_code=403,
            detail="Invalid slide path.",
        )

    if not requested_path.is_file():
        raise HTTPException(
            status_code=404,
            detail="Slide file not found.",
        )

    return requested_path


def open_slide(slide_path: Path) -> OpenSlide:
    try:
        return OpenSlide(str(slide_path))

    except OpenSlideUnsupportedFormatError:
        raise HTTPException(
            status_code=422,
            detail="The slide is not supported by OpenSlide.",
        )


def create_deep_zoom(slide: OpenSlide) -> DeepZoomGenerator:
    return DeepZoomGenerator(
        slide,
        tile_size=TILE_SIZE,
        overlap=0,
        limit_bounds=False,
    )


# ---------------------------------------------------------
# Health
# ---------------------------------------------------------

@app.get("/health")
def health():
    return {
        "status": "ok",
        "service": "pathology-wsi",
    }


# ---------------------------------------------------------
# Slide information
# ---------------------------------------------------------

@app.get("/slides/info")
def slide_info(
    path: str = Query(..., min_length=1),
):
    slide_path = resolve_slide_path(path)

    slide = open_slide(slide_path)

    try:
        deep_zoom = create_deep_zoom(slide)

        width, height = slide.dimensions

        return {
            "file_name": slide_path.name,

            "width": width,
            "height": height,

            "level_count": slide.level_count,

            "level_dimensions": [
                {
                    "width": dimensions[0],
                    "height": dimensions[1],
                }
                for dimensions in slide.level_dimensions
            ],

            "level_downsamples": [
                float(value)
                for value in slide.level_downsamples
            ],

            "deep_zoom": {
                "level_count": deep_zoom.level_count,
                "tile_size": TILE_SIZE,
            },
        }

    finally:
        slide.close()


# ---------------------------------------------------------
# Deep Zoom descriptor
# ---------------------------------------------------------

@app.get("/slides/dzi")
def slide_dzi(
    path: str = Query(..., min_length=1),
):
    slide_path = resolve_slide_path(path)

    slide = open_slide(slide_path)

    try:
        deep_zoom = create_deep_zoom(slide)

        dzi = deep_zoom.get_dzi("png")

        return Response(
            content=dzi,
            media_type="application/xml",
        )

    finally:
        slide.close()


# ---------------------------------------------------------
# Deep Zoom tile
# ---------------------------------------------------------

@app.get("/slides/tiles/{level}/{column}/{row}")
def slide_tile(
    level: int,
    column: int,
    row: int,
    path: str = Query(..., min_length=1),
):
    slide_path = resolve_slide_path(path)

    slide = open_slide(slide_path)

    try:
        deep_zoom = create_deep_zoom(slide)

        # Check zoom level
        if level < 0 or level >= deep_zoom.level_count:
            raise HTTPException(
                status_code=404,
                detail="Invalid zoom level.",
            )

        columns, rows = deep_zoom.level_tiles[level]

        # Check tile coordinates
        if (
            column < 0
            or row < 0
            or column >= columns
            or row >= rows
        ):
            raise HTTPException(
                status_code=404,
                detail="Invalid tile coordinates.",
            )

        tile = deep_zoom.get_tile(
            level,
            (column, row),
        )

        buffer = BytesIO()

        tile.save(
            buffer,
            format="PNG",
        )

        return Response(
            content=buffer.getvalue(),
            media_type="image/png",
            headers={
                "Cache-Control": "private, max-age=3600",
            },
        )

    finally:
        slide.close()
@app.post("/analysis/run")
def run_analysis(request: AnalysisRequest):

    slide_path = resolve_slide_path(
        request.storage_path
    )

    if not MODEL_PATH.is_file():
        raise HTTPException(
            status_code=500,
            detail="AI model is not configured."
        )

    try:

        result = analyze_slide(
            slide_path=str(slide_path),
            model_path=str(MODEL_PATH),
        )

    except Exception as exc:

        print(f"AI analysis error: {exc}")
        raise HTTPException(
            status_code=500,
            detail="AI analysis failed."
        )

    return {
        "prediction": result["prediction"],
        "score": result["score"],
        "model_version": MODEL_VERSION,
    }

   