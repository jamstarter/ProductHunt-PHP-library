<?php
/**
* ProductHunt PHP Library
*
* Use PHP to interact with the ProductHunt API
* https://api.producthunt.com/v1/docs/
* 
* @author  Brandon Swift <brandon@paywhirl.com>
*/
class ProductHunt
{
	
    protected $_hostDomain;
    protected $_client_id;
    protected $_client_secret;
    protected $_client_access_token;

    public function __construct($client_id,$client_secret){
    	$this->_hostDomain = "https://api.producthunt.com";
    	$this->_client_id = $client_id;
    	$this->_client_secret = $client_secret;

        $this->getClientLevelToken();
    }

    /**
    * Retrieve Client Level Access Token 
    */
    public function getClientLevelToken(){
    	$endpoint = "/v1/oauth/token";

    	$params = array(
    		'client_id' => $this->_client_id,
    		'client_secret' => $this->_client_secret,
    		'grant_type' => 'client_credentials'
    	);
    	$response = $this->post($endpoint,$params);

        $this->_client_access_token = $response->access_token;

    	return $response;
    }

    /**
    * Retrieve posts for a given day
    */
    public function getPostsByDay($date){
        $endpoint = "/v1/posts";
        $params['day'] = date('Y-m-d',strtotime($date));
        return $this->get($endpoint,$params);
    }

    /**
    * Retrieve posts for a given day
    * @array $params [search,older,newer,per_page]
    */
    public function getNewestPosts($params){
        $endpoint = "/v1/posts/all";
        return $this->get($endpoint,$params);
    }

    /**
    * Retrieve votes for a given post
    * @array $params [older,newer,per_page,order]
    * @int $id Id of Post
    */
    public function getPostVotes($id,$params){
        $endpoint = "/v1/posts/$id/votes";
        return $this->get($endpoint,$params);
    }


    /**
    * Retrieve post comments
    * @array $params [older,newer,per_page,order]
    * @int $id Id of User
    */
    public function getPostComments($id,$params){
        $endpoint = "/v1/posts/$id/comments";
        return $this->get($endpoint,$params);
    }

    /**
    * Show details for a single post
    * @int $id Id of a single post
    */
    public function showPost($id){
        $endpoint = "/v1/posts/1";
        $params = array();
        return $this->get($endpoint,$params);
    }

    /**
    * Retrieve votes for a given user
    * @array $params [older,newer,per_page,order]
    * @int $id Id of User
    */
    public function getUserVotes($id,$params){
        $endpoint = "/v1/users/$id/votes";
        return $this->get($endpoint,$params);
    }

   
    /**
    * Retrieve post comments
    * @array $params [older,newer,per_page,order]
    * @int $id Id of User
    */
    public function getUserComments($id,$params){
        $endpoint = "/v1/users/$id/comments";
        return $this->get($endpoint,$params);
    }
    

    /**
    * Retrieve user records
    * @array $params [older,newer,per_page,order]
    */
    public function getUsers($params){
        $endpoint = "/v1/users";
        return $this->get($endpoint,$params);
    }

    /**
    * Retrieve user records
    * @array $params [older,newer,per_page,order]
    */
    public function getUser($username){
        $endpoint = "/v1/users/".$username;
        return $this->get($endpoint,$params);
    }

    /**
    * Send POST request
    */
    public function post($endpoint,$params=array()){
        $params['access_token'] = $this->_client_access_token;
    	$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$this->_hostDomain.$endpoint);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		 curl_setopt($ch, CURLOPT_POSTFIELDS, 
		          http_build_query($params));

		// receive server response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

        return json_decode($server_output);
    }

     /**
    * Send GET request
    */
    public function get($endpoint,$params=array()){
        $params['access_token'] = $this->_client_access_token;
        $ch = curl_init(); 
 
        $query = http_build_query($params);

        curl_setopt($ch,CURLOPT_URL,$this->_hostDomain.$endpoint.'?'.$query);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
     
        $output=curl_exec($ch);
   
        curl_close($ch);
        return json_decode($output);
    }
    
}
