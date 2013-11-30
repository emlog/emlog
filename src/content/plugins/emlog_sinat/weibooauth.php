<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}

class OAuthException extends Exception
{
    // pass 
}
/** 
 * @ignore 
 */
class OAuthConsumer
{
    public $key;
    public $secret;
    function __construct ($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }
    function __toString ()
    {
        return "OAuthConsumer[key=$this->key,secret=$this->secret]";
    }
}
/** 
 * @ignore 
 */
class OAuthToken
{
    // access tokens and request tokens 
    public $key;
    public $secret;
    /** 
     * key = the token 
     * secret = the token secret 
     */
    function __construct ($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }
    /** 
     * generates the basic string serialization of a token that a server 
     * would respond to request_token and access_token calls with 
     */
    function to_string ()
    {
        return "oauth_token=" . OAuthUtil::urlencode_rfc3986($this->key) .
         "&oauth_token_secret=" . OAuthUtil::urlencode_rfc3986($this->secret);
    }
    function __toString ()
    {
        return $this->to_string();
    }
}
/** 
 * @ignore 
 */
class OAuthSignatureMethod
{
    public function check_signature (&$request, $consumer, $token, $signature)
    {
        $built = $this->build_signature($request, $consumer, $token);
        return $built == $signature;
    }
}
/** 
 * @ignore 
 */
class OAuthSignatureMethod_HMAC_SHA1 extends OAuthSignatureMethod
{
    function get_name ()
    {
        return "HMAC-SHA1";
    }
    public function build_signature ($request, $consumer, $token)
    {
        $base_string = $request->get_signature_base_string();
        //print_r( $base_string );
        $request->base_string = $base_string;
        $key_parts = array($consumer->secret, ($token) ? $token->secret : "");
        //print_r( $key_parts );
        $key_parts = OAuthUtil::urlencode_rfc3986($key_parts);
        $key = implode('&', $key_parts);
        return base64_encode(hash_hmac('sha1', $base_string, $key, true));
    }
}
/** 
 * @ignore 
 */
class OAuthSignatureMethod_PLAINTEXT extends OAuthSignatureMethod
{
    public function get_name ()
    {
        return "PLAINTEXT";
    }
    public function build_signature ($request, $consumer, $token)
    {
        $sig = array(OAuthUtil::urlencode_rfc3986($consumer->secret));
        if ($token) {
            array_push($sig, OAuthUtil::urlencode_rfc3986($token->secret));
        } else {
            array_push($sig, '');
        }
        $raw = implode("&", $sig);
        // for debug purposes 
        $request->base_string = $raw;
        return OAuthUtil::urlencode_rfc3986($raw);
    }
}
/** 
 * @ignore 
 */
class OAuthSignatureMethod_RSA_SHA1 extends OAuthSignatureMethod
{
    public function get_name ()
    {
        return "RSA-SHA1";
    }
    protected function fetch_public_cert (&$request)
    {
        // not implemented yet, ideas are: 
        // (1) do a lookup in a table of trusted certs keyed off of consumer 
        // (2) fetch via http using a url provided by the requester 
        // (3) some sort of specific discovery code based on request 
        // 
        // either way should return a string representation of the certificate 
        throw Exception(
        "fetch_public_cert not implemented");
    }
    protected function fetch_private_cert (&$request)
    {
        // not implemented yet, ideas are: 
        // (1) do a lookup in a table of trusted certs keyed off of consumer 
        // 
        // either way should return a string representation of the certificate 
        throw Exception(
        "fetch_private_cert not implemented");
    }
    public function build_signature (&$request, $consumer, $token)
    {
        $base_string = $request->get_signature_base_string();
        $request->base_string = $base_string;
        // Fetch the private key cert based on the request 
        $cert = $this->fetch_private_cert($request);
        // Pull the private key ID from the certificate 
        $privatekeyid = openssl_get_privatekey($cert);
        // Sign using the key 
        $ok = openssl_sign($base_string, $signature, $privatekeyid);
        // Release the key resource 
        openssl_free_key($privatekeyid);
        return base64_encode($signature);
    }
    public function check_signature (&$request, $consumer, $token, $signature)
    {
        $decoded_sig = base64_decode($signature);
        $base_string = $request->get_signature_base_string();
        // Fetch the public key cert based on the request 
        $cert = $this->fetch_public_cert($request);
        // Pull the public key ID from the certificate 
        $publickeyid = openssl_get_publickey($cert);
        // Check the computed signature against the one passed in the query 
        $ok = openssl_verify($base_string, $decoded_sig, $publickeyid);
        // Release the key resource 
        openssl_free_key($publickeyid);
        return $ok == 1;
    }
}
/** 
 * @ignore 
 */
class OAuthRequest
{
    private $parameters;
    private $http_method;
    private $http_url;
    // for debug purposes 
    public $base_string;
    public static $version = '1.0a';
    public static $POST_INPUT = 'php://input';
    function __construct ($http_method, $http_url, $parameters = NULL)
    {
        @$parameters or $parameters = array();
        $this->parameters = $parameters;
        $this->http_method = $http_method;
        $this->http_url = $http_url;
    }
    /** 
     * attempt to build up a request from what was passed to the server 
     */
    public static function from_request ($http_method = NULL, $http_url = NULL, 
    $parameters = NULL)
    {
        $scheme = (! isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") ? 'http' : 'https';
        @$http_url or $http_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . ':' .
         $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        @$http_method or $http_method = $_SERVER['REQUEST_METHOD'];
        // We weren't handed any parameters, so let's find the ones relevant to 
        // this request. 
        // If you run XML-RPC or similar you should use this to provide your own 
        // parsed parameter-list 
        if (! $parameters) {
            // Find request headers 
            $request_headers = OAuthUtil::get_headers();
            // Parse the query-string to find GET parameters 
            $parameters = OAuthUtil::parse_parameters(
            $_SERVER['QUERY_STRING']);
            // It's a POST request of the proper content-type, so parse POST 
            // parameters and add those overriding any duplicates from GET 
            if ($http_method == "POST" && @strstr(
            $request_headers["Content-Type"], 
            "application/x-www-form-urlencoded")) {
                $post_data = OAuthUtil::parse_parameters(
                file_get_contents(self::$POST_INPUT));
                $parameters = array_merge($parameters, $post_data);
            }
            // We have a Authorization-header with OAuth data. Parse the header 
            // and add those overriding any duplicates from GET or POST 
            if (@substr(
            $request_headers['Authorization'], 0, 6) == "OAuth ") {
                $header_parameters = OAuthUtil::split_header(
                $request_headers['Authorization']);
                $parameters = array_merge($parameters, $header_parameters);
            }
        }
        return new OAuthRequest($http_method, $http_url, $parameters);
    }
    /** 
     * pretty much a helper function to set up the request 
     */
    public static function from_consumer_and_token ($consumer, $token, 
    $http_method, $http_url, $parameters = NULL)
    {
        @$parameters or $parameters = array();
        $defaults = array("oauth_version" => OAuthRequest::$version, 
        "oauth_nonce" => OAuthRequest::generate_nonce(), 
        "oauth_timestamp" => OAuthRequest::generate_timestamp(), 
        "oauth_consumer_key" => $consumer->key);
        if ($token)
            $defaults['oauth_token'] = $token->key;
        $parameters = array_merge($defaults, $parameters);
        return new OAuthRequest($http_method, $http_url, $parameters);
    }
    public function set_parameter ($name, $value, $allow_duplicates = true)
    {
        if ($allow_duplicates && isset($this->parameters[$name])) {
            // We have already added parameter(s) with this name, so add to the list 
            if (is_scalar($this->parameters[$name])) {
                // This is the first duplicate, so transform scalar (string) 
                // into an array so we can add the duplicates 
                $this->parameters[$name] = array(
                $this->parameters[$name]);
            }
            $this->parameters[$name][] = $value;
        } else {
            $this->parameters[$name] = $value;
        }
    }
    public function get_parameter ($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }
    public function get_parameters ()
    {
        return $this->parameters;
    }
    public function unset_parameter ($name)
    {
        unset($this->parameters[$name]);
    }
    /** 
     * The request parameters, sorted and concatenated into a normalized string. 
     * @return string 
     */
    public function get_signable_parameters ()
    {
        // Grab all parameters 
        $params = $this->parameters;
        // remove pic 
        if (isset($params['pic'])) {
            unset($params['pic']);
        }
        if (isset($params['image'])) {
            unset($params['image']);
        }
        // Remove oauth_signature if present 
        // Ref: Spec: 9.1.1 ("The oauth_signature parameter MUST be excluded.") 
        if (isset($params['oauth_signature'])) {
            unset($params['oauth_signature']);
        }
        return OAuthUtil::build_http_query($params);
    }
    /** 
     * Returns the base string of this request 
     * 
     * The base string defined as the method, the url 
     * and the parameters (normalized), each urlencoded 
     * and the concated with &. 
     */
    public function get_signature_base_string ()
    {
        $parts = array($this->get_normalized_http_method(), 
        $this->get_normalized_http_url(), $this->get_signable_parameters());
        //print_r( $parts );
        $parts = OAuthUtil::urlencode_rfc3986($parts);
        return implode('&', $parts);
    }
    /** 
     * just uppercases the http method 
     */
    public function get_normalized_http_method ()
    {
        return strtoupper($this->http_method);
    }
    /** 
     * parses the url and rebuilds it to be 
     * scheme://host/path 
     */
    public function get_normalized_http_url ()
    {
        $parts = parse_url($this->http_url);
        $port = @$parts['port'];
        $scheme = $parts['scheme'];
        $host = $parts['host'];
        $path = @$parts['path'];
        $port or $port = ($scheme == 'https') ? '443' : '80';
        if (($scheme == 'https' && $port != '443') ||
         ($scheme == 'http' && $port != '80')) {
            $host = "$host:$port";
        }
        return "$scheme://$host$path";
    }
    /** 
     * builds a url usable for a GET request 
     */
    public function to_url ()
    {
        $post_data = $this->to_postdata();
        $out = $this->get_normalized_http_url();
        if ($post_data) {
            $out .= '?' . $post_data;
        }
        return $out;
    }
    /** 
     * builds the data one would send in a POST request 
     */
    public function to_postdata ($multi = false)
    {
        //echo "multi=" . $multi . '`';
        if ($multi)
            return OAuthUtil::build_http_query_multi($this->parameters);
        else
            return OAuthUtil::build_http_query($this->parameters);
    }
    /** 
     * builds the Authorization: header 
     */
    public function to_header ()
    {
        $out = 'Authorization: OAuth realm=""';
        $total = array();
        foreach ($this->parameters as $k => $v) {
            if (substr($k, 0, 5) != "oauth")
                continue;
            if (is_array($v)) {
                throw new OAuthException('Arrays not supported in headers');
            }
            $out .= ',' . OAuthUtil::urlencode_rfc3986($k) . '="' .
             OAuthUtil::urlencode_rfc3986($v) . '"';
        }
        return $out;
    }
    public function __toString ()
    {
        return $this->to_url();
    }
    public function sign_request ($signature_method, $consumer, $token)
    {
        $this->set_parameter("oauth_signature_method", 
        $signature_method->get_name(), false);
        $signature = $this->build_signature($signature_method, $consumer, 
        $token);
        //echo "sign=" . $signature;
        $this->set_parameter("oauth_signature", $signature, false);
    }
    public function build_signature ($signature_method, $consumer, $token)
    {
        $signature = $signature_method->build_signature($this, $consumer, 
        $token);
        return $signature;
    }
    /** 
     * util function: current timestamp 
     */
    private static function generate_timestamp ()
    {
        //return 1273566716;
        //echo date("y-m-d H:i:s");
        return time();
    }
    /** 
     * util function: current nonce 
     */
    private static function generate_nonce ()
    {
        //return '462d316f6f40c40a9e0eef1b009f37fa';
        $mt = microtime();
        $rand = mt_rand();
        return md5($mt . $rand); // md5s look nicer than numbers 
    }
}
/** 
 * @ignore 
 */
class OAuthServer
{
    protected $timestamp_threshold = 300; // in seconds, five minutes 
    protected $version = 1.0; // hi blaine 
    protected $signature_methods = array();
    protected $data_store;
    function __construct ($data_store)
    {
        $this->data_store = $data_store;
    }
    public function add_signature_method ($signature_method)
    {
        $this->signature_methods[$signature_method->get_name()] = $signature_method;
    }
    // high level functions 
    /** 
     * process a request_token request 
     * returns the request token on success 
     */
    public function fetch_request_token (&$request)
    {
        $this->get_version($request);
        $consumer = $this->get_consumer($request);
        // no token required for the initial token request 
        $token = NULL;
        $this->check_signature($request, $consumer, $token);
        $new_token = $this->data_store->new_request_token($consumer);
        return $new_token;
    }
    /** 
     * process an access_token request 
     * returns the access token on success 
     */
    public function fetch_access_token (&$request)
    {
        $this->get_version($request);
        $consumer = $this->get_consumer($request);
        // requires authorized request token 
        $token = $this->get_token($request, $consumer, "request");
        $this->check_signature($request, $consumer, $token);
        $new_token = $this->data_store->new_access_token($token, $consumer);
        return $new_token;
    }
    /** 
     * verify an api call, checks all the parameters 
     */
    public function verify_request (&$request)
    {
        $this->get_version($request);
        $consumer = $this->get_consumer($request);
        $token = $this->get_token($request, $consumer, "access");
        $this->check_signature($request, $consumer, $token);
        return array($consumer, $token);
    }
    // Internals from here 
    /** 
     * version 1 
     */
    private function get_version (&$request)
    {
        $version = $request->get_parameter("oauth_version");
        if (! $version) {
            $version = 1.0;
        }
        if ($version && $version != $this->version) {
            throw new OAuthException("OAuth version '$version' not supported");
        }
        return $version;
    }
    /** 
     * figure out the signature with some defaults 
     */
    private function get_signature_method (&$request)
    {
        $signature_method = @$request->get_parameter("oauth_signature_method");
        if (! $signature_method) {
            $signature_method = "PLAINTEXT";
        }
        if (! in_array($signature_method, array_keys($this->signature_methods))) {
            throw new OAuthException(
            "Signature method '$signature_method' not supported " .
             "try one of the following: " .
             implode(", ", array_keys($this->signature_methods)));
        }
        return $this->signature_methods[$signature_method];
    }
    /** 
     * try to find the consumer for the provided request's consumer key 
     */
    private function get_consumer (&$request)
    {
        $consumer_key = @$request->get_parameter("oauth_consumer_key");
        if (! $consumer_key) {
            throw new OAuthException("Invalid consumer key");
        }
        $consumer = $this->data_store->lookup_consumer($consumer_key);
        if (! $consumer) {
            throw new OAuthException("Invalid consumer");
        }
        return $consumer;
    }
    /** 
     * try to find the token for the provided request's token key 
     */
    private function get_token (&$request, $consumer, $token_type = "access")
    {
        $token_field = @$request->get_parameter('oauth_token');
        $token = $this->data_store->lookup_token($consumer, $token_type, 
        $token_field);
        if (! $token) {
            throw new OAuthException("Invalid $token_type token: $token_field");
        }
        return $token;
    }
    /** 
     * all-in-one function to check the signature on a request 
     * should guess the signature method appropriately 
     */
    private function check_signature (&$request, $consumer, $token)
    {
        // this should probably be in a different method 
        $timestamp = @$request->get_parameter('oauth_timestamp');
        $nonce = @$request->get_parameter('oauth_nonce');
        $this->check_timestamp($timestamp);
        $this->check_nonce($consumer, $token, $nonce, $timestamp);
        $signature_method = $this->get_signature_method($request);
        $signature = $request->get_parameter('oauth_signature');
        $valid_sig = $signature_method->check_signature($request, $consumer, 
        $token, $signature);
        if (! $valid_sig) {
            throw new OAuthException("Invalid signature");
        }
    }
    /** 
     * check that the timestamp is new enough 
     */
    private function check_timestamp ($timestamp)
    {
        // verify that timestamp is recentish 
        $now = time();
        if ($now - $timestamp > $this->timestamp_threshold) {
            throw new OAuthException(
            "Expired timestamp, yours $timestamp, ours $now");
        }
    }
    /** 
     * check that the nonce is not repeated 
     */
    private function check_nonce ($consumer, $token, $nonce, $timestamp)
    {
        // verify that the nonce is uniqueish 
        $found = $this->data_store->lookup_nonce($consumer, $token, 
        $nonce, $timestamp);
        if ($found) {
            throw new OAuthException("Nonce already used: $nonce");
        }
    }
}
/** 
 * @ignore 
 */
class OAuthDataStore
{
    function lookup_consumer ($consumer_key)
    {
        // implement me 
    }
    function lookup_token ($consumer, $token_type, $token)
    {
        // implement me 
    }
    function lookup_nonce ($consumer, $token, $nonce, $timestamp)
    {
        // implement me 
    }
    function new_request_token ($consumer)
    {
        // return a new token attached to this consumer 
    }
    function new_access_token ($token, $consumer)
    {
        // return a new access token attached to this consumer 
    // for the user associated with this token if the request token 
    // is authorized 
    // should also invalidate the request token 
    }
}
/** 
 * @ignore 
 */
class OAuthUtil
{
    public static $boundary = '';
    public static function urlencode_rfc3986 ($input)
    {
        if (is_array($input)) {
            return array_map(array('OAuthUtil', 'urlencode_rfc3986'), $input);
        } else 
            if (is_scalar($input)) {
                return str_replace('+', ' ', 
                str_replace('%7E', '~', rawurlencode($input)));
            } else {
                return '';
            }
    }
    // This decode function isn't taking into consideration the above 
    // modifications to the encoding process. However, this method doesn't 
    // seem to be used anywhere so leaving it as is. 
    public static function urldecode_rfc3986 ($string)
    {
        return urldecode($string);
    }
    // Utility function for turning the Authorization: header into 
    // parameters, has to do some unescaping 
    // Can filter out any non-oauth parameters if needed (default behaviour) 
    public static function split_header ($header, 
    $only_allow_oauth_parameters = true)
    {
        $pattern = '/(([-_a-z]*)=("([^"]*)"|([^,]*)),?)/';
        $offset = 0;
        $params = array();
        while (preg_match($pattern, $header, $matches, PREG_OFFSET_CAPTURE, 
        $offset) > 0) {
            $match = $matches[0];
            $header_name = $matches[2][0];
            $header_content = (isset($matches[5])) ? $matches[5][0] : $matches[4][0];
            if (preg_match('/^oauth_/', $header_name) ||
             ! $only_allow_oauth_parameters) {
                $params[$header_name] = OAuthUtil::urldecode_rfc3986(
                $header_content);
            }
            $offset = $match[1] + strlen($match[0]);
        }
        if (isset($params['realm'])) {
            unset($params['realm']);
        }
        return $params;
    }
    // helper to try to sort out headers for people who aren't running apache 
    public static function get_headers ()
    {
        if (function_exists('apache_request_headers')) {
            // we need this to get the actual Authorization: header 
            // because apache tends to tell us it doesn't exist 
            return apache_request_headers();
        }
        // otherwise we don't have apache and are just going to have to hope 
        // that $_SERVER actually contains what we need 
        $out = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == "HTTP_") {
                // this is chaos, basically it is just there to capitalize the first 
                // letter of every word that is not an initial HTTP and strip HTTP 
                // code from przemek 
                $key = str_replace(
                " ", "-", 
                ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
                $out[$key] = $value;
            }
        }
        return $out;
    }
    // This function takes a input like a=b&a=c&d=e and returns the parsed 
    // parameters like this 
    // array('a' => array('b','c'), 'd' => 'e') 
    public static function parse_parameters ($input)
    {
        if (! isset($input) || ! $input)
            return array();
        $pairs = explode('&', $input);
        $parsed_parameters = array();
        foreach ($pairs as $pair) {
            $split = explode('=', $pair, 2);
            $parameter = OAuthUtil::urldecode_rfc3986($split[0]);
            $value = isset($split[1]) ? OAuthUtil::urldecode_rfc3986($split[1]) : '';
            if (isset($parsed_parameters[$parameter])) {
                // We have already recieved parameter(s) with this name, so add to the list 
                // of parameters with this name 
                if (is_scalar(
                $parsed_parameters[$parameter])) {
                    // This is the first duplicate, so transform scalar (string) into an array 
                    // so we can add the duplicates 
                    $parsed_parameters[$parameter] = array(
                    $parsed_parameters[$parameter]);
                }
                $parsed_parameters[$parameter][] = $value;
            } else {
                $parsed_parameters[$parameter] = $value;
            }
        }
        return $parsed_parameters;
    }
    public static function build_http_query_multi ($params)
    {
        if (! $params)
            return '';
             //print_r( $params );
        //return null;
        // Urlencode both keys and values 
        $keys = array_keys($params);
        $values = array_values($params);
        //$keys = OAuthUtil::urlencode_rfc3986(array_keys($params)); 
        //$values = OAuthUtil::urlencode_rfc3986(array_values($params)); 
        $params = array_combine($keys, $values);
        // Parameters are sorted by name, using lexicographical byte value ordering. 
        // Ref: Spec: 9.1.1 (1) 
        uksort($params, 'strcmp');
        $pairs = array();
        self::$boundary = $boundary = uniqid('------------------');
        $MPboundary = '--' . $boundary;
        $endMPboundary = $MPboundary . '--';
        $multipartbody = '';
        foreach ($params as $parameter => $value) {
            //if( $parameter == 'pic' && $value{0} == '@' )
            if (in_array($parameter, array("pic", "image")) &&
             $value{0} == '@') {
                $url = ltrim($value, '@');
                $content = file_get_contents($url);
                $filename = reset(explode('?', basename($url)));
                $mime = self::get_image_mime($url);
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'Content-Disposition: form-data; name="' .
                 $parameter . '"; filename="' . $filename . '"' . "\r\n";
                $multipartbody .= 'Content-Type: ' . $mime . "\r\n\r\n";
                $multipartbody .= $content . "\r\n";
            } else {
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'content-disposition: form-data; name="' .
                 $parameter . "\"\r\n\r\n";
                $multipartbody .= $value . "\r\n";
            }
        }
        $multipartbody .= $endMPboundary;
        // For each parameter, the name is separated from the corresponding value by an '=' character (ASCII code 61) 
        // Each name-value pair is separated by an '&' character (ASCII code 38) 
        // echo $multipartbody;
        return $multipartbody;
    }
    public static function build_http_query ($params)
    {
        if (! $params)
            return '';
             // Urlencode both keys and values 
        $keys = OAuthUtil::urlencode_rfc3986(array_keys($params));
        $values = OAuthUtil::urlencode_rfc3986(array_values($params));
        $params = array_combine($keys, $values);
        // Parameters are sorted by name, using lexicographical byte value ordering. 
        // Ref: Spec: 9.1.1 (1) 
        uksort($params, 'strcmp');
        $pairs = array();
        foreach ($params as $parameter => $value) {
            if (is_array($value)) {
                // If two or more parameters share the same name, they are sorted by their value 
                // Ref: Spec: 9.1.1 (1) 
                natsort($value);
                foreach ($value as $duplicate_value) {
                    $pairs[] = $parameter . '=' . $duplicate_value;
                }
            } else {
                $pairs[] = $parameter . '=' . $value;
            }
        }
        // For each parameter, the name is separated from the corresponding value by an '=' character (ASCII code 61) 
        // Each name-value pair is separated by an '&' character (ASCII code 38) 
        return implode('&', $pairs);
    }
    public static function get_image_mime ($file)
    {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $mime = 'image/jpg';
                break;
            case 'png':
                $mime = 'image/png';
                break;
            case 'gif':
            default:
                $mime = 'image/gif';
                break;
        }
        return $mime;
    }
}
/** 
 * 新浪微博操作类 
 * 
 * @package sae 
 * @author Easy Chen 
 * @version 1.0 
 */
class WeiboClient
{
    /** 
     * 构造函数 
     * 
     * @access public 
     * @param mixed $akey 微博开放平台应用APP KEY 
     * @param mixed $skey 微博开放平台应用APP SECRET 
     * @param mixed $accecss_token OAuth认证返回的token 
     * @param mixed $accecss_token_secret OAuth认证返回的token secret 
     * @return void 
     */
    function __construct ($akey, $skey, $accecss_token, $accecss_token_secret)
    {
        $this->oauth = new WeiboOAuth($akey, $skey, $accecss_token, 
        $accecss_token_secret);
    }
    /** 
     * 个人资料 
     * 
     * @access public 
     * @param mixed $uid_or_name 用户UID或微博昵称。 
     * @return array 
     */
    function show_user ($uid_or_name = null)
    {
        return $this->request_with_uid('http://api.t.sina.com.cn/users/show.json', $uid_or_name);
    }
    /** 
     * 发表微博 
     * 
     * @access public 
     * @param mixed $text 要更新的微博信息。 
     * @return array 
     */
    function update ($text)
    {
        //  http://api.t.sina.com.cn/statuses/update.json 
        $param = array();
        $param['status'] = $text;
        return $this->oauth->post(
        'http://api.t.sina.com.cn/statuses/update.json', $param);
    }
    /** 
     * 发表图片微博 
     * 
     * @access public 
     * @param string $text 要更新的微博信息。 
     * @param string $text 要发布的图片路径,支持url。[只支持png/jpg/gif三种格式,增加格式请修改get_image_mime方法] 
     * @return array 
     */
    function upload ($text, $pic_path)
    {
        //  http://api.t.sina.com.cn/statuses/update.json 
        $param = array();
        $param['status'] = $text;
        $param['pic'] = '@' . $pic_path;
        return $this->oauth->post(
        'http://api.t.sina.com.cn/statuses/upload.json', $param, true);
    }
    // ========================================= 
    /** 
     * @ignore 
     */
    protected function request_with_pager ($url, $page = false, $count = false)
    {
        $param = array();
        if ($page)
            $param['page'] = $page;
        if ($count)
            $param['count'] = $count;
        return $this->oauth->get($url, $param);
    }
    /** 
     * @ignore 
     */
    protected function request_with_uid ($url, $uid_or_name, $page = false, 
    $count = false, $cursor = false, $post = false)
    {
        $param = array();
        if ($page)
            $param['page'] = $page;
        if ($count)
            $param['count'] = $count;
        if ($cursor)
            $param['cursor'] = $cursor;
        if ($post)
            $method = 'post';
        else
            $method = 'get';
        if (is_numeric($uid_or_name)) {
            $param['user_id'] = $uid_or_name;
            return $this->oauth->$method($url, $param);
        } elseif ($uid_or_name !== null) {
            $param['screen_name'] = $uid_or_name;
            return $this->oauth->$method($url, $param);
        } else {
            return $this->oauth->$method($url, $param);
        }
    }
}
/** 
 * 新浪微博 OAuth 认证类 
 * 
 * @package sae 
 * @author Easy Chen 
 * @version 1.0 
 */
class WeiboOAuth
{
    /** 
     * Contains the last HTTP status code returned.  
     * 
     * @ignore 
     */
    public $http_code;
    /** 
     * Contains the last API call. 
     * 
     * @ignore 
     */
    public $url;
    /** 
     * Set up the API root URL. 
     * 
     * @ignore 
     */
    public $host = "http://api.t.sina.com.cn/";
    /** 
     * Set timeout default. 
     * 
     * @ignore 
     */
    public $timeout = 30;
    /**  
     * Set connect timeout. 
     * 
     * @ignore 
     */
    public $connecttimeout = 30;
    /** 
     * Verify SSL Cert. 
     * 
     * @ignore 
     */
    public $ssl_verifypeer = FALSE;
    /** 
     * Respons format. 
     * 
     * @ignore 
     */
    public $format = 'json';
    /** 
     * Decode returned json data. 
     * 
     * @ignore 
     */
    public $decode_json = TRUE;
    /** 
     * Contains the last HTTP headers returned. 
     * 
     * @ignore 
     */
    public $http_info;
    /** 
     * Set the useragnet. 
     * 
     * @ignore 
     */
    public $useragent = 'Sae T OAuth v0.2.0-beta2';
    /* Immediately retry the API call if the response was not successful. */
    //public $retry = TRUE; 
    /** 
     * Set API URLS 
     */
    /** 
     * @ignore 
     */
    function accessTokenURL ()
    {
        return 'http://api.t.sina.com.cn/oauth/access_token';
    }
    /** 
     * @ignore 
     */
    function authenticateURL ()
    {
        return 'http://api.t.sina.com.cn/oauth/authenticate';
    }
    /** 
     * @ignore 
     */
    function authorizeURL ()
    {
        return 'http://api.t.sina.com.cn/oauth/authorize';
    }
    /** 
     * @ignore 
     */
    function requestTokenURL ()
    {
        return 'http://api.t.sina.com.cn/oauth/request_token';
    }
    /** 
     * Debug helpers 
     */
    /** 
     * @ignore 
     */
    function lastStatusCode ()
    {
        return $this->http_status;
    }
    /** 
     * @ignore 
     */
    function lastAPICall ()
    {
        return $this->last_api_call;
    }
    /** 
     * construct WeiboOAuth object 
     */
    function __construct ($consumer_key, $consumer_secret, $oauth_token = NULL, 
    $oauth_token_secret = NULL)
    {
        $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
        $this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
        if (! empty($oauth_token) && ! empty($oauth_token_secret)) {
            $this->token = new OAuthConsumer($oauth_token, $oauth_token_secret);
        } else {
            $this->token = NULL;
        }
    }
    /** 
     * Get a request_token from Weibo 
     * 
     * @return array a key/value array containing oauth_token and oauth_token_secret 
     */
    function getRequestToken ($oauth_callback = NULL)
    {
        $parameters = array();
        if (! empty($oauth_callback)) {
            $parameters['oauth_callback'] = $oauth_callback;
        }
        $request = $this->oAuthRequest($this->requestTokenURL(), 'GET', 
        $parameters);
        $token = OAuthUtil::parse_parameters($request);
        $this->token = new OAuthConsumer($token['oauth_token'], 
        $token['oauth_token_secret']);
        return $token;
    }
    /** 
     * Get the authorize URL 
     * 
     * @return string 
     */
    function getAuthorizeURL ($token, $sign_in_with_Weibo = TRUE, $url)
    {
        if (is_array($token)) {
            $token = $token['oauth_token'];
        }
        if (empty($sign_in_with_Weibo)) {
            return $this->authorizeURL() .
             "?oauth_token={$token}&oauth_callback=" . urlencode($url);
        } else {
            return $this->authenticateURL() .
             "?oauth_token={$token}&oauth_callback=" . urlencode($url);
        }
    }
    /** 
     * Exchange the request token and secret for an access token and 
     * secret, to sign API calls. 
     * 
     * @return array array("oauth_token" => the access token, 
     * "oauth_token_secret" => the access secret) 
     */
    function getAccessToken ($oauth_verifier = FALSE, $oauth_token = false)
    {
        $parameters = array();
        if (! empty($oauth_verifier)) {
            $parameters['oauth_verifier'] = $oauth_verifier;
        }
        $request = $this->oAuthRequest($this->accessTokenURL(), 'GET', 
        $parameters);
        $token = OAuthUtil::parse_parameters($request);
        $this->token = new OAuthConsumer($token['oauth_token'], 
        $token['oauth_token_secret']);
        return $token;
    }
    /** 
     * GET wrappwer for oAuthRequest. 
     * 
     * @return mixed 
     */
    function get ($url, $parameters = array())
    {
        $response = $this->oAuthRequest($url, 'GET', $parameters);
        if ($this->format === 'json' && $this->decode_json) {
            return json_decode($response, true);
        }
        return $response;
    }
    /** 
     * POST wreapper for oAuthRequest. 
     * 
     * @return mixed 
     */
    function post ($url, $parameters = array(), $multi = false)
    {
        $response = $this->oAuthRequest($url, 'POST', $parameters, $multi);
        if ($this->format === 'json' && $this->decode_json) {
            return json_decode($response, true);
        }
        return $response;
    }
    /** 
     * DELTE wrapper for oAuthReqeust. 
     * 
     * @return mixed 
     */
    function delete ($url, $parameters = array())
    {
        $response = $this->oAuthRequest($url, 'DELETE', $parameters);
        if ($this->format === 'json' && $this->decode_json) {
            return json_decode($response, true);
        }
        return $response;
    }
    /** 
     * Format and sign an OAuth / API request 
     * 
     * @return string 
     */
    function oAuthRequest ($url, $method, $parameters, $multi = false)
    {
        if (strrpos($url, 'http://') !== 0 && strrpos($url, 'http://') !== 0) {
            $url = "{$this->host}{$url}.{$this->format}";
        }
        // echo $url ; 
        $request = OAuthRequest::from_consumer_and_token(
        $this->consumer, $this->token, $method, $url, $parameters);
        $request->sign_request($this->sha1_method, $this->consumer, 
        $this->token);
        switch ($method) {
            case 'GET':
                //echo $request->to_url(); 
                return $this->http($request->to_url(), 'GET');
            default:
                return $this->http($request->get_normalized_http_url(), $method, 
                $request->to_postdata($multi), $multi);
        }
    }
    
	function http($url, $method, $postfields = NULL, $multi = false) {
		$host = 'api.t.sina.com.cn';
		$path = str_replace('http://api.t.sina.com.cn', '', $url);
		$request = $postfields;
		$port = 80;

	    $contentLength = strlen($request);
		$http_request  = "$method $path HTTP/1.1\r\n";
		$http_request .= "Host: $host\r\n";
		$http_request .= "Content-type: application/x-www-form-urlencoded\r\n";
		$http_request .= "Content-Length: $contentLength\r\n";
		$http_request .= "User-Agent: emlog_sinat V1.0\r\n";
	    $http_request .= "Connection: close\r\n";
	    $http_request .= "\r\n";
		$http_request .= $request;

		$response = '';
		if( false != ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
			fwrite($fs, $http_request);
			while ( !feof($fs) )
				$response .= fgets($fs, 1160); // One TCP-IP packet
			fclose($fs);
			$response = explode("\r\n\r\n", $response, 2);
		}
		return $response[1]; 
	}
    /** 
     * Get the header info to store. 
     * 
     * @return int 
     */
    function getHeader ($ch, $header)
    {
        $i = strpos($header, ':');
        if (! empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->http_header[$key] = $value;
        }
        return strlen($header);
    }
} 
