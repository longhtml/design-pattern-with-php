<?php
/**
 * 适配器模式
 *
 * 将一个类的接口转换成客户希望的另外一个接口,使用原本不兼容的而不能在一起工作的那些类可以在一起工作
 */

// 这个是原有的类型
class OldCache
{
    public function __construct()
    {
        echo "OldCache construct<br/>";
    }

    public function store($key,$value)
    {
        echo "OldCache store<br/>";
    }

    public function remove($key)
    {
        echo "OldCache remove<br/>";
    }

    public function fetch($key)
    {
        echo "OldCache fetch<br/>";
    }
}

interface Cacheable
{
    public function set($key,$value);
    public function get($key);
    public function del($key);
}

class OldCacheAdapter implements Cacheable
{
    private $_cache = null;
    public function __construct()
    {
        $this->_cache = new OldCache();
    }

    public function set($key,$value)
    {
        return $this->_cache->store($key,$value);
    }

    public function get($key)
    {
        return $this->_cache->fetch($key);
    }

    public function del($key)
    {
        return $this->_cache->remove($key);
    }
}

$objCache = new OldCacheAdapter();
$objCache->set("test",1);
$objCache->get("test");
$objCache->del("test",1);

/*
// 也可以是接口
class Target
{
    function Request()
    {
        echo "普通请求";
    }
}

// 需要适配的类
class Adaptee
{
    function SpecificRequest()
    {
        echo "特殊请求";
    }
}

class Adapter extends Target
{
    var $_adaptee = null;

    function Adapater()
    {
        $this->_adaptee = new Adaptee();
    }

    function Request()
    {
        $this->_adaptee->Request();
    }
}

$obj = new Adapter();
target.Request();
*/

/**
 * 常用到的地方:
 * 不同的数据库处理 不同的缓存处理
 */
?>