import numpy as np
import pandas as pd
import cv2
import openslide


PATCH_SIZE = 256
DOWNSAMPLE = 32

BRIGHTNESS_THRESHOLD = 240
SATURATION_THRESHOLD = 20

MIN_TISSUE_PERCENTAGE = 0.05


def get_tissue_mask_hsv(
    slide: openslide.OpenSlide,
    downsample: int = DOWNSAMPLE,
) -> np.ndarray:
    """
    Create a binary tissue mask from a downsampled WSI thumbnail.

    1 = probable tissue
    0 = background / low-saturation area
    """

    width, height = slide.dimensions

    thumb_width = int(width / downsample)
    thumb_height = int(height / downsample)

    thumbnail = slide.get_thumbnail(
        (thumb_width, thumb_height)
    ).convert("RGB")

    thumbnail_np = np.array(thumbnail)

    hsv = cv2.cvtColor(
        thumbnail_np,
        cv2.COLOR_RGB2HSV,
    )

    saturation = hsv[:, :, 1]
    value = hsv[:, :, 2]

    mask = (
        (value < BRIGHTNESS_THRESHOLD)
        & (saturation > SATURATION_THRESHOLD)
    )

    return mask.astype(np.uint8)


def generate_tissue_coordinates(
    slide_path: str,
) -> pd.DataFrame:
    """
    Generate level-0 256x256 tissue patch coordinates
    using the same HSV filtering logic used by the
    preprocessing code.

    Returns a DataFrame containing only:
        x, y
    """

    slide = openslide.OpenSlide(slide_path)

    try:

        width, height = slide.dimensions

        mask = get_tissue_mask_hsv(
            slide,
            DOWNSAMPLE,
        )

        rows, cols = mask.shape

        step_mask = int(
            PATCH_SIZE / DOWNSAMPLE
        )

        required_pixels_mask = int(
            (step_mask * step_mask)
            * MIN_TISSUE_PERCENTAGE
        )

        coordinates = []

        for y in range(
            0,
            height,
            PATCH_SIZE,
        ):

            for x in range(
                0,
                width,
                PATCH_SIZE,
            ):

                mx = int(
                    x / DOWNSAMPLE
                )

                my = int(
                    y / DOWNSAMPLE
                )

                if (
                    mx + step_mask >= cols
                    or my + step_mask >= rows
                ):
                    continue

                mask_region = mask[
                    my:my + step_mask,
                    mx:mx + step_mask
                ]

                if (
                    np.sum(mask_region)
                    <= required_pixels_mask
                ):
                    continue

                if (
                    x + PATCH_SIZE > width
                    or y + PATCH_SIZE > height
                ):
                    continue

                coordinates.append({
                    "x": x,
                    "y": y,
                })

        return pd.DataFrame(
            coordinates,
            columns=["x", "y"],
        )

    finally:
        slide.close()