<?php
/**
 * 委托模式
 *
 * 
 */
class PlayList
{
    var $_songs = array();
    var $_object = null;

    function PlayList($type)
    {
        $object = $type."PlayListDelegation";
        $this->_object = new $object();
    }

    function addSong($location,$title,$extension)
    {
        $this->_songs[] = array("location"=>$location,"title"=>$title,"extension"=>$extension);
    }

    function getPlayList()
    {
        return $this->_object->getPlayList($this->_songs);
    }
}

class mp3PlayListDelegation
{
    function getPlayList($songs)
    {
        $aResult = array();
        foreach($songs as $key=>$item)
        {
            $path = pathinfo($item['location']);
            if(strtolower($item['extension']) == "mp3")
            {
                $aResult[] = $item;
            }
        }
        return $aResult;
    }
}

class rmvbPlayListDelegation
{
    function getPlayList($songs)
    {
        $aResult = array();
        foreach($songs as $key=>$item)
        {
            $path = pathinfo($item['location']);
            if(strtolower($item['extension']) == "rmvb")
            {
                $aResult[] = $item;
            }
        }
        return $aResult;
    }
}

echo '<pre>';
$oMP3PlayList = new PlayList("mp3");
$oMP3PlayList->addSong('usa','to be loved','mp3');
$oMP3PlayList->addSong('usa','to be','mp3');
var_dump($oMP3PlayList->getPlayList());

$oRMVBPlayList = new PlayList("rmvb");
$oRMVBPlayList->addSong('cn','moon','rmvb');
$oRMVBPlayList->addSong('cn','ccc','rmvb');
var_dump($oRMVBPlayList->getPlayList());
?>
