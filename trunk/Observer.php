<?php
/**
 * 观察者模式
 * 
 * 定义对象间的一种一对多的依赖关系,以便当一个对象的状态发生改变时,所有依赖于它的对象都得到通知并自动刷新
 * 能够便利地创建查看目标对象状态的对象,并且提供与核心对象非耦合的指定功能
 * 插件系统
 */
class Observerable
{
    private $_observers = array();

    public function registerObserver($observer)
    {
        $this->_observers[] = $observer;
    }

    public function removeObserver($observer)
    {
        $key = array_search($observer,$this->_observers);
        if(!($key === false))
        {
            unset($this->_observers[$key]);
        }
    }

    public function notifyObservers()
    {
        foreach($this->_observers as $observer)
        {
            if($observer instanceof Observer) $observer->update($this);
        }
    }
}

interface Observer
{
    public function update($observer);
}

interface DisplayElement
{
    public function display();
}

// -- 实例类定义
class NewsObserverable extends Observerable
{
    private $_sports_news;
    public function setSportsNews($data)
    {
        $this->_sports_news = $data;
        $this->notifyObservers();
    }

    public function getSportsNews()
    {
        return $this->_sports_news;
    }

    private $_local_news;
    public function setLocalNews($data)
    {
        $this->_local_news = $data;
        $this->notifyObservers();
    }

    public function getLocalNews()
    {
        return $this->_local_news;
    }
}

class SportsNews implements Observer,DisplayElement
{
    private $_data = null;
    public function update($observer)
    {
        if($this->_data != $observer->getSportsNews())
        {
            $this->_data = $observer->getSportsNews();
            $this->display();
        }
    }

    public function display()
    {
        echo $this->_data.date("Y-m-d H:i:s")."<br/>";
    }
}

class LocalNews implements Observer,DisplayElement
{
    private $_data = null;
    public function update($observer)
    {
        if($this->_data != $observer->getLocalNews())
        {
            $this->_data = $observer->getLocalNews();
            $this->display();
        }
    }

    public function display()
    {
        echo $this->_data.date("Y-m-d H:i:s")."<br/>";
    }
}

// -- 实例化 ---

$objObserver = new NewsObserverable();
$local = new LocalNews();
$sports = new SportsNews();

$objObserver->registerObserver($local);
$objObserver->registerObserver($sports);

$objObserver->setSportsNews("sports news 1 ");
$objObserver->setLocalNews("local news 1 ");
$objObserver->removeObserver($sports);
$objObserver->setLocalNews("local news 2 ");
$objObserver->setSportsNews("sports news 2 ");
$objObserver->removeObserver($local);
$objObserver->setLocalNews("local news 3 ");
/*
class CD
{
    public $title= "";
    public $band = "";
    protected $_obsevers = array();

    public function __construct($title,$band)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function attachObserver($type,$observer)
    {
        $this->_obsevers[$type][] =  $observer;
    }

    public function notifyObserver($type)
    {
        if(isset($this->_obsevers[$type])) 
        {
            foreach($this->_obsevers[$type] as $observer)
            {
                $observer->update($this);
            }
        }
    }

    public function buy()
    {
        $this->notifyObserver('purchased');
    }
}

class buyCDNotifyStreamObserver
{
    public function update(CD $cd)
    {
        $activity = "The Cd named {$cd->title} by {$cd->band} was just purchased.";
        activityStream::addNewItem($activity);s
    }
}

class activityStream
{
    public static function addNewItem($item)
    {
        print $item;
    }
}

$cd = new CD("Waste of a Rib","Never Again");
$observer = new buyCDNotifyStreamObserver();
$cd->attachObserver('purchased',$observer);
$cd->buy();*/
?>