<?php

namespace App\Service;

use App\Filters\FilterInformationFilter;
use App\Filters\LocationInformationFilter;

class LocationReader extends ExcelReader
{
    const COLUMN = "D";
    const START_ROW = 2;
    const NAME = 'location';
    const TYPE = 'dropdown';

    public function readLocation(): array
    {
        $locationInformation = $this->read(
            new LocationInformationFilter([self::COLUMN]),
            self::COLUMN,
            self::COLUMN,
            self::START_ROW,
        );

        $locationValue = [];
        foreach ($locationInformation as $location) {
            if(!in_array($location[self::COLUMN], $locationValue)) {
                $locationValue[] = $location[self::COLUMN];
            }
        }
        unset($locationInformation);

        return [
            'name' => self::NAME,
            'type' => self::TYPE,
            'value' => $locationValue
        ];
    }
}
