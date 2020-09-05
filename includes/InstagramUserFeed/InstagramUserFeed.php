<?php

namespace includes\InstagramUserFeed;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use Instagram\Api;
use Instagram\Exception\InstagramAuthException;
use Instagram\Exception\InstagramException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require(realpath(dirname(__FILE__)) . '/../../vendor/autoload.php');


class InstagramUserFeed {
	private $username;
	private $password;
	private $profile_username; // this will be from the Vendor Profile
	public $title; // displayed at top of feed
	public $images; // looped through to display in widget
	public $profile_photo;
	public $cachePool;
	
	function __construct($username, $password, $profile_username) {
		$this->username = $username;
		$this->password = $password;
		$this->profile_username = $profile_username;
		$this->cachePool = new FilesystemAdapter('Instagram', 0, 'cache');
		$this->createFeed();
	}
	
	public function createFeed() {
		try {
			$api = new Api($this->cachePool);
			$api->login( $this->username, $this->password );
		} catch ( GuzzleException $e ) {
			return false;
		} catch ( ClientException $e ) {
			return false;
		} catch ( InstagramAuthException $e ) {
			return false;
		} catch ( InvalidArgumentException $e ) {
			return false;
		} // mandatory
		try {
			$profile = $api->getProfile( $this->profile_username );
			$some_media = $profile->getMedias(); // first 12 photos
			sleep(1);
			
			$images = array();
			foreach ($some_media as $media) {
				$images[] = '<a target="_blank" href="' . $media->getLink() . '" style="background:url(' . $media->getDisplaySrc() . '); background-size:cover;background-position:center center;" alt="IG photo" /></a>';
			}
			
			$this->profile_photo = $profile->getProfilePicture();
			$this->images = $images;
			$this->title = $profile->getFullName();
		} catch ( InstagramException $e ) {
			return false;
		} catch ( ClientException $e ) {
			return false;
		}
		
//		print_r($images);
//		echo $profile->getUserName(); // username of the Vendor's IG account
//		echo $profile->getFullName(); // i.e. Robert Downey Jr. Official
//		echo $profile->isPrivate();
//		print_r($profile->getMedias());
	}
}