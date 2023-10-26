<?php

namespace App\Http\Resources;

use App\Entity\AgendaEntity;
use Illuminate\Support\Collection;

class AgendaCollection extends Collection
{
    public function __construct($agendas)
    {
        $this->items = collect($this->getArrayableItems($agendas))->map(function ($data) {
            return AgendaEntity::fromArray(is_array($data) ? $data : $data->toArray());
        });
    }

    public static function makeFromAgendas($agendas): self
    {
        $agendasArray = collect($agendas)->map(function ($data) {
            return AgendaEntity::fromArray(is_array($data) ? $data : []);
        });

        return new static($agendasArray);
    }

    public function toArray(): array
    {
        return $this->items->map(function ($data) {
            return $data->toArray();
        })->all();
    }
}
