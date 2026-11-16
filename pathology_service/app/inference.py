import argparse
import numpy as np
import torch
import torch.nn as nn
from torchvision import models, transforms
import openslide

from .tissue_coordinates import generate_tissue_coordinates


# =========================================================
# FIXED INFERENCE SETTINGS
# Same values used in your successful test.
# =========================================================

DEVICE = torch.device("cuda" if torch.cuda.is_available() else "cpu")
BAG_SIZE = 128
N_VOTES = 5
THRESHOLD = 0.5814


# =========================================================
# MODEL
# =========================================================

class EfficientNetMIL(nn.Module):
    def __init__(self):
        super().__init__()

        self.base_model = models.efficientnet_b0(weights=None)
        self.feature_extractor = self.base_model.features
        self.avgpool = self.base_model.avgpool

        self.classifier = nn.Sequential(
            nn.Dropout(p=0.5),
            nn.Linear(1280, 1),
        )

    def forward(self, x):
        features = self.feature_extractor(x)
        features = self.avgpool(features)
        features = torch.flatten(features, 1)

        instance_scores = self.classifier(features)
        bag_score, _ = torch.max(instance_scores, dim=0)

        return bag_score


# =========================================================
# PREPROCESSING
# Same preprocessing used in the existing test code.
# =========================================================

TEST_TRANSFORM = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
    transforms.Normalize(
        [0.485, 0.456, 0.406],
        [0.229, 0.224, 0.225],
    ),
])


# =========================================================
# SINGLE-SLIDE INFERENCE
# =========================================================

def analyze_slide(slide_path: str, model_path: str) -> dict:
    print(f"Device: {DEVICE}")
    print(f"Slide: {slide_path}")
    print(f"Model: {model_path}")

    # Generate tissue coordinates directly from the WSI.
    coordinates = generate_tissue_coordinates(
        slide_path
    )

    if coordinates.empty:
        raise ValueError(
            "No tissue coordinates were detected."
        )

    if "x" not in coordinates.columns or "y" not in coordinates.columns:
        raise ValueError(
            "Generated coordinates must contain x and y columns."
        )

    print(
        f"Available tissue coordinates: {len(coordinates)}"
    )

    model = EfficientNetMIL().to(DEVICE)

    state_dict = torch.load(
        model_path,
        map_location=DEVICE,
    )

    model.load_state_dict(state_dict)
    model.eval()

    slide = openslide.OpenSlide(slide_path)

    slide_scores = []

    try:
        for vote in range(N_VOTES):
            print(f"\nProcessing bag {vote + 1}/{N_VOTES}")

            if len(coordinates) >= BAG_SIZE:
                selected = coordinates.sample(
                    n=BAG_SIZE,
                    replace=False,
                    random_state=42 + vote,
                )
            else:
                selected = coordinates.sample(
                    n=BAG_SIZE,
                    replace=True,
                    random_state=42 + vote,
                )

            patches = []

            for _, row in selected.iterrows():
                x = int(row["x"])
                y = int(row["y"])

                patch = slide.read_region(
                    (x, y),
                    0,
                    (256, 256),
                ).convert("RGB")

                patch = TEST_TRANSFORM(patch)
                patches.append(patch)

            bag = torch.stack(patches).to(DEVICE)

            with torch.no_grad():
                output = model(bag)
                probability = torch.sigmoid(output).item()

            slide_scores.append(probability)

            print(
                f"Bag probability: {probability:.4f}"
            )

    finally:
        slide.close()

    final_score = float(
        np.max(slide_scores)
    )

    prediction = (
        "Cancer"
        if final_score > THRESHOLD
        else "Non-Cancer"
    )

    result = {
        "prediction": prediction,
        "score": final_score,
        "threshold": THRESHOLD,
        "bags": N_VOTES,
    }

    print("\n")
    print("=" * 55)
    print("SINGLE SLIDE AI RESULT")
    print("=" * 55)
    print(f"Bags:         {N_VOTES}")
    print(f"Threshold:    {THRESHOLD:.4f}")
    print(f"Final Score:  {final_score:.4f}")
    print(f"Prediction:   {prediction}")
    print("=" * 55)

    return result


# =========================================================
# COMMAND LINE
# =========================================================

def main():
    parser = argparse.ArgumentParser(
        description="Run EfficientNet MIL inference on one pathology WSI."
    )

    parser.add_argument(
        "--slide",
        required=True,
        help="Full path to the TIFF/WSI file.",
    )

    parser.add_argument(
        "--model",
        required=True,
        help="Full path to the trained .pth model file.",
    )

    args = parser.parse_args()

    analyze_slide(
        slide_path=args.slide,
        model_path=args.model,
    )


if __name__ == "__main__":
    main()