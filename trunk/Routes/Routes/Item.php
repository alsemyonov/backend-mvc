<?
/**
 * Элемент списка путей (базовый класс).
 */
class Backend_Routes_Item
{
    /**
     * Массив адресов.
     * @var array
     */
    protected $url = array();

    /**
     * Массив условий.
     * @var array
     */
    protected $cnd = array();
  
    /**
     * Массив адресов-регулярных выражений.
     * @var array
     */
    protected $urlRegexp = array();
        
    /**
     * Массив параметров.
     * @var array
     */
    protected $params = array();

    /**
     * Добавляет в список адресов элемента адрес.
     *
     * Формат может быть следующим:
     *  - Прямой адрес папки (/news/2007/) или файла (/robots.txt).
     *  - Простое регулярное выражение: "/news/y($year)/".
     *  - Адрес вида "r/.../" - сложное регулярное выражение.
     *
     * @param string $url Адрес.
     * @param string $matchNames Наименования переменных, вычленяемых в сложном регулярном выражении.
     * @return $this
     */
    function url($url, $matchNames = array())
    {
        if (( strpos( $url, '$' ) != 0) && ($url[0]!='r') ){
            preg_match_all('/\(\$(.*?)\)/', $url, $matches);
            $matchNames = $matches[1];
            foreach( $matchNames as $varName )
            {
                $url = str_replace('($'.$varName.')', '([\w-]+)', $url);            
            }

            $url = str_replace( '/', '\/', $url );
            if (strpos($url, '$') != 0)
            {
                throw new Exception( 'Incorrect simplified regexp string: '.$url);
            }
            $url = '/^'.$url.'$/';           
            $this->urlRegexp($url, $matchNames);           
        } else if ($url[0]=='r') {
            $url = substr($url,1);
            $this->urlRegexp($url, $matchNames);
        } else {
            $this->url[] = $url;
        }
        return $this;
    }

    /**
     * Добавляет в список адресов элемента адрес в виде регулярного выражения.
     *
     * Пример:
     * @code
     * $item->urlRegexp( '\/manager\/edit\/(.*)\/$', array( 'id' ) );
     * @endcode
     *
     * @param $regExp string Регулярное выражение.
     * @param $matchNames array Массив имён переменных, в которые нужно вырезать части адреса. 
     */
    private function urlRegexp( $regExp, $matchNames = array() )
    {
        $this->urlRegexp[] = array( $regExp, $matchNames );

        return $this;
    }

    /**
     * Добавляет шаблон.
     */
    function using($template)
    {
        if (!is_subclass_of($template, 'Backend_Routes_Item')) {
            throw new Exception('Template item is not subclass of Routes_Item');
        }
        $this->params = array_merge($this->params, $template->params);
        $this->cnd    = array_merge($this->cnd, $template->cnd);
        return $this;
    }
    
    /**
     * Добавляет параметр.
     */
    function param($key, $value)
    {
        $this->params[ $key ] = $value;
        return $this;
    }

    /**
     * Добавляет возвращает параметры.
     */
    function getParams()
    {
        return $this->params;
    }

    /**
     * Returns parameter value.
     */
    function getParam($name)
    {
        return $this->params[$name];
    }
  
    /**
     * Добавляет параметр.
     */
    function cnd($cnd)
    {
        $this->cnd[] = $cnd;
        return $this;
    }

    /**
     * Возвращает истину если адрес из параметров совпадает с одним из адресов в элементе карты.
     * @param $url Путь.
     * @param $args Аргументы условий.
     * @param &$matchesRet Части регулярного выражения.
     */
    function match($url, &$matchesRet = null, $args = array())
    {
        extract($args);

        foreach($this->cnd as $cnd)
        {
            $cnd = 'return ('.$cnd.');';
            if (!eval($cnd)) return false;
        }

        if (in_array($url, $this->url)) return true;
           
        foreach($this->urlRegexp as $toMatch)
        {
            if (preg_match($toMatch[ 0 ], $url, $matches))
            {
                if ($matches)
                {
                    // Если имена вычленяемым кускам не заданы, возвращаем их в виде линейного массива.
                    if ( !$toMatch[ 1 ] ) $matchesRet = array_splice( $matches, 1 );

                    // Если заданы - в виде хэша.
                    for( $i = 0; $i < count( $matches )-1; $i++ )
                    {
                        $matchesRet[ $toMatch[ 1 ][ $i ] ] = $matches[ $i+1 ];
                    }                    
                }

                return true;
            }
        }

        return false;
    }
}
?>