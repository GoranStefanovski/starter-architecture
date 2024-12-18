<?php

namespace App\Applications\DayType\DTO;

use App\Applications\DayType\Model\DayType;
use Illuminate\Http\Request;

class DayTypeDTO
{
    public string $slug;
    public string $name;
    public bool $is_paid;

    public function __construct(
        string $slug,
        string $name,
        bool $is_paid = false,
    ) {
        $this->slug = $slug;
        $this->name = $name;
        $this->is_paid = $is_paid;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('slug'),
            $request->input('name'),
            (bool) $request->input('is_paid', false),
        );
    }

    public static function fromRequestForCreate(Request $request): self
    {
        return new self(
            $request->input('slug'),
            $request->input('name'),
            is_paid: false,
        );
    }

    public static function fromModel(DayType $dayType): self
    {
        return new self(
            $dayType->slug,
            $dayType->name,
            (bool) $dayType->is_paid,
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'is_paid' => $this->is_paid,
        ];
    }

    public static function fromCollection(iterable $dayTypes): array
    {
        return array_map(function (DayType $dayType) {
            return self::fromModel($dayType);
        }, $dayTypes->all());
    }
}
