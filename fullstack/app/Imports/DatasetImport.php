<?php

namespace App\Imports;

use App\Models\Criterion;
use App\Models\Value;
use App\Models\Variant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatasetImport implements ToCollection, WithHeadingRow
{

    public function __construct(private readonly int $datasetId)
    {
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $cachesCriterionIds = [];
        foreach ($rows as $i => $row) {
            if ($i == 0) {
                foreach ($row as $name => $type) {
                    if ($name !== "variants") {
                        $criterionName = Criterion::TYPE_GAIN;
                        if ($type === 'c' || $type === 'cost') {
                            $criterionName = Criterion::TYPE_COST;
                        }
                        $criterion = Criterion::create([
                            'name' => $name,
                            'type' => $criterionName,
                            'dataset_id' => $this->datasetId
                        ]);
                        $cachesCriterionIds[$criterion->name] = $criterion->id;
                    }
                }
                continue;
            }
            $variantName = "";
            $valuesArr = [];
            foreach ($row as $name => $value) {
                if ($name === "variants") {
                    $variantName = $value;
                } else {
                    $valuesArr[] = new Value([
                        'value' => $value,
                        'criterion_id' => $cachesCriterionIds[$name]
                    ]);
                }
            }
            $variant = Variant::create([
                'name' => $variantName,
                'dataset_id' => $this->datasetId
            ]);

            foreach ($valuesArr as $valueModel) {
                $valueModel->variant()->associate($variant);
                $valueModel->save();
            }
        }
    }
}
