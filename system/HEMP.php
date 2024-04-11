<?php
mb_internal_encoding( "UTF-8" );

class HEMP 
{
    private static $instance;
    private function __construct() {}
    public static function getInstance( bool $is_routed = false, string $config_location = "" ): HEMP_System
    {
        if ( is_null( static::$instance ))
        {
            static::$instance = new HEMP_System( $is_routed, $config_location );

        }
        return static::$instance;
    }
}

class HEMP_System 
{

    public const    VERSION = "0.0.1";
    public const    VERBOSE = false;

    private ?array  $config;

    private array   $headers = [];
    private bool    $is_htmx = false;
    
    private ?string $verb;
    private ?string $resource;
    private ?array  $parameters;
    private ?array  $objects;

    public function __construct( private bool $is_routed, private ?string $config_location  )
    {
        
        //Check for and parse in config
        if ( $config_location )
        {
            $this->config_location = $config_location;
            if ( file_exists( $this->config_location ))
            {
                $this->config = parse_ini_file( $this->config_location, true, INI_SCANNER_TYPED );
            }
        }

        // Collect, sanitize and store HX- headers
        foreach( getallheaders() as $k => $v )
        {
            $key = self::wash( $k );
            $key_name = substr( $k, 3 );
            if ( strncmp( $key, "HX-", 3 ) === 0 && strlen( $key_name ) > 0 )
            {
                $payload = $this->wash( $v );
                $this->headers[$key_name] = $payload;
                
            }
        }

        // Collect, sanitize and store request payload
        if ( isset( $this->headers["Request"] ) && $this->headers["Request"] == "true" )
        {
            $this->is_htmx = true;
        }
        $this->verb = self::wash( $_SERVER["REQUEST_METHOD"] );
        $uri = $_SERVER["REQUEST_URI"];
        
        // $_SERVER["REQUEST_URI"]
        // file?



    }

    public static function wash( string $content ): string
    {
        return htmlspecialchars( $content, ENT_QUOTES, "UTF-8", false );
    }

    public function isHTMX(): bool
    {
        return $this->is_htmx;
    }
    public function getHeaders(): ?array 
    {
        return $this->headers;
    }
    public function getTarget(): ?string
    {
        return $this->headers["Target"] ;
    }
    public function getTargetName(): ?string
    {
        return $this->headers["Target-Name"] ;
    }
    public function getConfigs(): ?array
    {
        return $this->config;
    }
    public function getConfig( ?string $section ): ?array
    {
        if ( isset( $this->config[$section] ) && is_array( $this->config[$section] ))
        {
            return $this->config[$section];
        }
        else
        {
            return null;
        }
    }
    
}
class HEMP_Exception extends Exception { }

?>