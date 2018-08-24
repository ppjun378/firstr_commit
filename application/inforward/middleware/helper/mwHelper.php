<?php
/**
 * Created by PhpStorm.
 * User: zico
 * Date: 2018/6/30
 * Time: 下午12:59
 */

namespace app\inforward\middleware\helper;

trait mwHelper
{

    /**
     * 无限极别排序树
     * @param $data
     * @param int $pid
     * @param string $primaryKey
     * @return array
     */
    static public function tree(&$data, &$parent, $primaryKey = 'parent')
    {
        $result = [];
        foreach ($data as $key => $item) {
            if ($item['parent'] == $parent['id']) {
                //  确认关系
                $result[] = $item;
                unset($data[$key]);
                $parent['children'][] = self::tree($data, $item, $primaryKey);
            }
        }
        return $result;
    }

    /**
     * 分类排序（降序）
     */
    static public function sort($arr, $cols)
    {
        //子分类排序
        foreach ($arr as $k => &$v) {
            if (!empty($v['sub'])) {
                $v['sub'] = self::sort($v['sub'], $cols);
            }
            $sort[$k] = $v[$cols];
        }
        if (isset($sort))
            array_multisort($sort, SORT_DESC, $arr);
        return $arr;
    }

    /**
     * 横向分类树
     */
    static public function hTree($arr, $pid = 0)
    {
        foreach ($arr as $k => $v) {
            if ($v['pid'] == $pid) {
                $data[$v['id']] = $v;
                $data[$v['id']]['sub'] = self::hTree($arr, $v['id']);
            }
        }
        return isset($data) ? $data : array();
    }

    /**
     * 纵向分类树
     */
    static public function vTree($arr, $pid = 0)
    {
        foreach ($arr as $k => $v) {
            if ($v['pid'] == $pid) {
                $data[$v['id']] = $v;
                $data += self::vTree($arr, $v['id']);
            }
        }
        return isset($data) ? $data : array();
    }
}