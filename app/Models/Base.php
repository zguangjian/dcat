<?php

/**
 * Created by PhpStorm.
 * User: zguangjian
 * CreateDate: 2021/7/22 11:59
 * Email: zguangjian@outlook.com
 */

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Base
 *
 * @property int $id
 * @method static Builder|Base newModelQuery()
 * @method static Builder|Base newQuery()
 * @method static Builder|Base query()
 * @method static Builder|Base whereId($value)
 * @mixin Eloquent
 */
class Base extends Model
{

    protected $table = "base";

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table ? $this->table : strtolower(str_replace('_model', '', snake_case(class_basename($this))));
    }

    public static function getTableName()
    {
        return (new static())->getTable();
    }

    /**
     * @param $id
     * @return Base|Builder|Model|object|null
     */
    public static function find($id)
    {
        return self::whereId($id)->first();
    }

    /**
     * @param $attribute
     * @return bool
     */
    public static function insertAll($attribute)
    {
        foreach ($attribute as &$item) {
            $item['created_at'] = $item['created_at'] ?? date('Y-m-d H:i:s');
            $item['updated_at'] = $item['updated_at'] ?? date('Y-m-d H:i:s');
        }
        return DB::table((new static())->getTable())->insert($attribute);
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public static function insertOne($attribute)
    {
        return (new static())->create($attribute);
    }

    /**
     * @param array $attribute
     * @param string $select
     * @param string $orderBy
     * @param string $sort
     * @return static|object|null
     */
    public static function findOne($attribute = [], $select = "*", $orderBy = "id", $sort = "desc")
    {
        return (new static())->where($attribute)->select($select)->orderBy($orderBy, $sort)->first();
    }

    /**
     * @param array $attribute
     * @param string $select
     * @param string $orderBy
     * @param string $sort
     * @return Collection
     */
    public static function findAll($attribute = [], $select = "*", $orderBy = "id", $sort = "desc")
    {
        return (new  static())->where($attribute)->select($select)->orderBy($orderBy, $sort)->get();
    }
}
