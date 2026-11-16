import argparse
import pandas as pd

from app.tissue_coordinates import (
    generate_tissue_coordinates,
)


def main():

    parser = argparse.ArgumentParser()

    parser.add_argument(
        "--slide",
        required=True,
        help="Path to the original TIFF slide",
    )

    parser.add_argument(
        "--csv",
        required=True,
        help="Path to the existing coordinate CSV",
    )

    args = parser.parse_args()


    print("\nGenerating coordinates...")
    print("--------------------------------")


    generated = generate_tissue_coordinates(
        args.slide
    )


    reference = pd.read_csv(
        args.csv
    )


    if not {"x", "y"}.issubset(
        reference.columns
    ):
        raise ValueError(
            "Reference CSV must contain x and y columns."
        )


    reference = reference[
        ["x", "y"]
    ].copy()


    reference["x"] = (
        reference["x"]
        .astype(int)
    )

    reference["y"] = (
        reference["y"]
        .astype(int)
    )


    generated_set = set(
        map(
            tuple,
            generated[
                ["x", "y"]
            ].to_numpy()
        )
    )


    reference_set = set(
        map(
            tuple,
            reference[
                ["x", "y"]
            ].to_numpy()
        )
    )


    matches = (
        generated_set
        & reference_set
    )


    missing = (
        reference_set
        - generated_set
    )


    extra = (
        generated_set
        - reference_set
    )


    reference_coverage = (
        len(matches)
        / len(reference_set)
        * 100
        if reference_set
        else 0
    )


    generated_precision = (
        len(matches)
        / len(generated_set)
        * 100
        if generated_set
        else 0
    )


    union = (
        generated_set
        | reference_set
    )


    jaccard = (
        len(matches)
        / len(union)
        * 100
        if union
        else 0
    )


    print("\nRESULT")
    print("================================")

    print(
        f"Reference CSV coordinates : "
        f"{len(reference_set)}"
    )

    print(
        f"Generated coordinates     : "
        f"{len(generated_set)}"
    )

    print(
        f"Exact matches             : "
        f"{len(matches)}"
    )

    print(
        f"Missing from generated    : "
        f"{len(missing)}"
    )

    print(
        f"Extra generated           : "
        f"{len(extra)}"
    )

    print("--------------------------------")

    print(
        f"Reference coverage        : "
        f"{reference_coverage:.2f}%"
    )

    print(
        f"Generated precision       : "
        f"{generated_precision:.2f}%"
    )

    print(
        f"Jaccard similarity        : "
        f"{jaccard:.2f}%"
    )


    if missing:

        print(
            "\nFirst missing coordinates:"
        )

        for coordinate in sorted(
            missing
        )[:10]:

            print(coordinate)


    if extra:

        print(
            "\nFirst extra coordinates:"
        )

        for coordinate in sorted(
            extra
        )[:10]:

            print(coordinate)


if __name__ == "__main__":
    main()