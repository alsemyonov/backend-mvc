<?
/**
 * ������� ������ ����� (������� �����).
 */
class Backend_Routes_Item
{
    /**
     * ������ �������.
     * @var array
     */
    protected $url = array();

    /**
     * ������ �������.
     * @var array
     */
    protected $cnd = array();
  
    /**
     * ������ �������-���������� ���������.
     * @var array
     */
    protected $urlRegexp = array();
        
    /**
     * ������ ����������.
     * @var array
     */
    protected $params = array();

    /**
     * ��������� � ������ ������� �������� �����.
     *
     * ������ ����� ���� ���������:
     *  - ������ ����� ����� (/news/2007/) ��� ����� (/robots.txt).
     *  - ������� ���������� ���������: "/news/y($year)/".
     *  - ����� ���� "r/.../" - ������� ���������� ���������.
     *
     * @param string $url �����.
     * @param string $matchNames ������������ ����������, ����������� � ������� ���������� ���������.
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
     * ��������� � ������ ������� �������� ����� � ���� ����������� ���������.
     *
     * ������:
     * @code
     * $item->urlRegexp( '\/manager\/edit\/(.*)\/$', array( 'id' ) );
     * @endcode
     *
     * @param $regExp string ���������� ���������.
     * @param $matchNames array ������ ��� ����������, � ������� ����� �������� ����� ������. 
     */
    private function urlRegexp( $regExp, $matchNames = array() )
    {
        $this->urlRegexp[] = array( $regExp, $matchNames );

        return $this;
    }

    /**
     * ��������� ������.
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
     * ��������� ��������.
     */
    function param($key, $value)
    {
        $this->params[ $key ] = $value;
        return $this;
    }

    /**
     * ��������� ���������� ���������.
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
     * ��������� ��������.
     */
    function cnd($cnd)
    {
        $this->cnd[] = $cnd;
        return $this;
    }

    /**
     * ���������� ������ ���� ����� �� ���������� ��������� � ����� �� ������� � �������� �����.
     * @param $url ����.
     * @param $args ��������� �������.
     * @param &$matchesRet ����� ����������� ���������.
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
                    // ���� ����� ����������� ������ �� ������, ���������� �� � ���� ��������� �������.
                    if ( !$toMatch[ 1 ] ) $matchesRet = array_splice( $matches, 1 );

                    // ���� ������ - � ���� ����.
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