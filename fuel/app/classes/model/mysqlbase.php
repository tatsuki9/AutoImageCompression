<?php
/**
 * Created by PhpStorm.
 * User: nyoronyoro-kun
 * Date: 2017/07/02
 * Time: 15:02
 */

class Model_MySQLBase
{
    public static function find_all_by($select = array(), $where = array())
    {
        $result = self::create_where(DB::select_array($select)->from(static::$table), $where)->execute();
        return $result->as_array();
    }
    
    public static function insert($data)
    {
        return DB::insert(static::$table)->set($data)->execute();
    }

    public static function delete($where)
    {
        return self::create_where(DB::delete(static::$table), $where)->execute();
    }

    /*
     * TODO::以上、以下、IN句、LIKE句, NOT EQUALなどなど色々まだ未対応なので、必要に応じて追加してください。
     */
    private static function create_where($query, $where)
    {
        if (isset($where['and']))
        {
            $query->where_open();
            $i = 0;
            foreach($where['and'] as $column => $value)
            {
                if ($i <= 0)
                {
                    $query = $query->where($column, $value);
                }
                else
                {
                    $query = $query->and_where($column, $value);
                }
            }
            $query->where_close();
        }
        if (isset($where['or']))
        {
            $query->or_where_open();
            $i = 0;
            foreach($where['or'] as $column => $value)
            {
                if ($i <= 0)
                {
                    $query = $query->where($column, $value);
                }
                else
                {
                    $query = $query->or_where($column, $value);
                }
            }
            $query->or_where_close();
        }
        return $query;
    }
}