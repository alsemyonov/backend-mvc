<?
// @todo !!! Encoding
class Backend_Mvc_View_Rss extends Backend_Mvc_View
{
    protected $items;
    protected $title;
    protected $link;

    function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    function getData()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        $xml .= '<rss version="2.0">';
        $xml .= '<channel>';
        $xml .= '<title>'.$this->title.'</title>';
        $xml .= '<link>'.$this->link.'</link>';

        foreach($this->items as $item)
        {
            $xml .= '<item>';
            $xml .= '<title><![CDATA['.$item['title'].']]></title>';
            $xml .= '<link>'.$item['link'].'</link>';
            $xml .= '<description><![CDATA['.$item['description'].']]></description>';
            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        return $xml;
    }

    function show($request, $response)
    {
        $response->setEncoding('UTF-8');
        $response->setContentType('application/xhtml+xml');

        $response->out($this->getData());
    }
}
?>