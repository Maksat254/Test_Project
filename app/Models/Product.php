<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasNesting;
use A17\Twill\Models\Behaviors\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use A17\Twill\Models\Model;

class Product extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, HasNesting, HasFactory;

    protected $fillable = [
        'published',
        'title',
        'description',
        'position',
        'name',
        'type',
        'price',
        'color',
        'size',
        'quantity',
        'cover',
    ];
        public $mediasParams = [
            'cover' => [
                'default' => [
                    [
                        'role' => 'cover',
                        'crop' => 'default',
                    ],
                ],
            ],
        ];


    public $slugAttributes = [
        'title',
    ];

    public function orders()
    {
        return $this->morphMany(Order::class, 'morphable');
    }


}
