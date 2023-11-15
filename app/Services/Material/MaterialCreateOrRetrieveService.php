<?php

namespace App\Services\Material;

use App\Models\Material;

class MaterialCreateOrRetrieveService
{

public function createOrRetrieveMaterials($materialNames)
    {
        $materials = [];

        foreach ($materialNames as $materialName) {
            $material = Material::firstOrCreate(['name' => $materialName]);
            $materials[] = $material->id;
        }

        return $materials;
    }
}
