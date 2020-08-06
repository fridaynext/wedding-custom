<?php

namespace includes\InstagramUserFeed;

use GuzzleHttp\Exception\GuzzleException;
use Instagram\Api;
use Instagram\Exception\InstagramAuthException;
use Instagram\Exception\InstagramException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class InstagramUserFeed {
	private $username;
	private $password;
	private $profile_username; // this will be from the Vendor Profile
	public $title; // displayed at top of feed
	public $images; // looped through to display in widget
	public $profile_photo;
	
	function __construct($username, $password, $profile_username) {
		$this->username = $username;
		$this->password = $password;
		$this->profile_username = $profile_username;
		
		$this->createFeed();
	}
	
	public function createFeed() {
		$cachePool = new FilesystemAdapter('Instagram', 0, __DIR__ . '/../../cache');
		$api = new Api($cachePool);
		try {
			$api->login( $this->username, $this->password );
		} catch ( GuzzleException $e ) {
		} catch ( InstagramAuthException $e ) {
		} catch ( InvalidArgumentException $e ) {
		} // mandatory
		try {
			$profile = $api->getProfile( $this->profile_username );
			$some_media = $profile->getMedias(); // first 12 photos
			
			$images = array();
			foreach ($some_media as $media) {
				$images[] = '<a target="_blank" href="' . $media->getLink() . '" style="background:url(' . $media->getDisplaySrc() . '); background-size:cover;background-position:center center;" alt="IG photo" /></a>';
			}
			
			$this->profile_photo = $profile->getProfilePicture();
			$this->images = $images;
			$this->title = $profile->getFullName();
		} catch ( InstagramException $e ) {
		}
		
//		print_r($images);
//		echo $profile->getUserName(); // username of the Vendor's IG account
//		echo $profile->getFullName(); // i.e. Robert Downey Jr. Official
//		echo $profile->isPrivate();
//		print_r($profile->getMedias());
	}
}