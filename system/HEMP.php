<?php
declare(strict_types=1);
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
    
    private ?array  $request;
    private ?string $verb;
    private ?string $resource;
    private ?array  $parameters;
    private ?array  $objects;

    public function __construct( private bool $is_routed, private ?string $config_location )
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
            $key = self::wash( content: $k );
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
        $this->verb = self::wash( content: $_SERVER["REQUEST_METHOD"] );
        $this->request = parse_url( 
            ( isset( $_SERVER["HTTPS"] ) || ( isset( $_SERVER["REQUEST_SCHEME"]) && $_SERVER["REQUEST_SCHEME"] == "https" )) ? "https" : "http" .
            "://" .
            $_SERVER["SERVER_ADDR"] .
            $_SERVER["REQUEST_URI"]
        );
        $this->resource = substr( $this->request["path"], strlen( $this->getConfig( section: "system", key: "path_prefix" )));
        //$this->parameters = substr( $request["path"], strlen( $this->getConfig( section: "system", key: "path_prefix" )));

        if ( in_array( $this->request, [ "GET", "POST" ] ))
        {
            //Normal workflow
        }
        else {

        }
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
    public function getConfig( ?string $section, ?string $key ): array|string|null
    {
        if ( $section && isset( $this->config[$section] ) && is_array( $this->config[$section] ))
        {
            if ( $key && isset( $this->config[$section][$key] ))
            {
                return $this->config[$section][$key];
            }
            elseif ( $key )
            {
                return null;
            }
            else {
                return $this->config[$section];
            }
        }
        elseif ( $section )
        {
            return null;
        }
        else
        {
            return $this->config;
        }
    }
    
}
class HEMP_Exception extends Exception { }

?>