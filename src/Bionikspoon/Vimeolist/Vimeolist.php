<?php namespace Bionikspoon\Vimeolist;
/**
* 
*/
class Vimeolist
{
	private $base_url = 'http://vimeo.com/api/v2/{username}/videos.json';
	private $username;
	function __construct($username = 'userscape')
	{
		$this->setUser($username);
		return $this;
	}

	public function setUser($username = NULL)
	{
		$this->username = is_null($username) ? $this->username : urlencode($username);
		return $this;
	}

	private function getFeed()
	{
		$url = str_replace('{username}', $this->username, $this->base_url);
		$feed = file_get_contents($url);
		return $feed;
	}
	private function parseFeed()
	{
		$json = $this->getFeed();
		$object = json_decode($json);
		return $object;
	}

	public function getList()
	{
		$list = [];
		$posts = $this->parseFeed();
		foreach ($posts as $post) {
			$list[$post->id]['title'] = $post->title;
			$list[$post->id]['url'] = $post->url;
			$list[$post->id]['description'] = $post->description;
			$list[$post->id]['thumbnail'] = $post->thumbnail_small;
		}
		return $list;
	}
}