<?php

class SlabRequest
{
    public string $name;

    public int $id;

    public int $width;

    public function __construct(int $id, string $name, int $width)
    {
        $this->id = $id;
        $this->name = $name;
        $this->width = $width;
    }
}

class Slab
{
    public function __construct(
        public string $name,
        public int $id = 1,
        public int $width = 24
    ) {}

    public static function fromRequest(SlabRequest $request): Slab
    {
        return new Slab(
            name: $request->name,
            id: $request->id,
            width: $request->width
        );
    }
}

class SlabFactory
{
    public static function create($data): Slab
    {
        return new Slab($data);
    }
}

$slab = Slab::fromRequest(new SlabRequest(id: 65, name: 'fred', width: 32));

// $slab = SlabFactory::create(['name' => 'rock', 'id' => 2, 'width' => 1]);

print_r($slab);
