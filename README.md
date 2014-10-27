Product Hunt API PHP Library
==============================

This is a PHP Library for interacting with the Product Hunt API. I developed it during the 2014 YC/ProductHunt hackathon to use for HunterList.co.

Api Docs available at: https://api.producthunt.com/v1/docs/

How to use
---------------

	require_once('ProductHunt.php');

	//init object
	$productHunt = new ProductHunt($client_id,$client_secret);

	//get posts for a given day
	$posts = $productHunt->getPostsByDay('today');

	//get newest posts
	$newestPosts = $productHunt->getNewestPosts(array('per_page'=>10));

	//get votes for a post
	$postVotes = $productHunt->getPostVotes($post_id,array('order'=>'asc'));

	//get comments for a post
	$postComments = $productHunt->getPostComments($post_id,array('order'=>'asc'));

	//get details for particular post
	$postDetails = $productHunt->showPost($post_id);

	//get votes for a user
	$userVotes = $productHunt->getUserVotes($user_id,array('per_page'=>10));

	//get comments for a user
	$userComments = $productHunt->getUserComments($user_id,array('order'=>'desc'));

	//get a list of users
	$allUsers = $productHunt->getUsers(array('per_page'=>50));

	//get info about a specific user
	$userData = $productHunt->getUser($username);



