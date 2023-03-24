<?php


namespace App\Traits;

use App\Models\Base;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Trait ModelTrait
 * @package App\Traits
 */
trait ModelTrait
{
    protected static $model;

    /**
     * @param array $attribute
     * @return bool
     */
    public static function insertAll(array $attribute)
    {
        foreach ($attribute as &$item) {
            $item['created_at'] = $item['created_at'] ?? date('Y-m-d H:i:s');
            $item['updated_at'] = $item['updated_at'] ?? date('Y-m-d H:i:s');
        }
        return DB::table((new static())->getTable())->insert($attribute);
    }

    /**
     * @param $id
     * @return Base|Builder|Model|object|null
     */
    public static function find($id)
    {
        return self::whereId($id)->first();
    }
}
