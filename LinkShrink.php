<?php
class LinkShrink
{
	private $redis;
	private $shrinkerUrl = 'http://perfnerd.de/7val-ls';

	public function __construct()
	{
		$this->redis = $this->redisConnect();
	}

	private function redisConnect()
	{
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		return $redis;
	}

	public function checkLinkExists($shortLink)	
	{
		if ($shortLink != '') {
			if ($this->redis->exists($shortLink) > 0) {
				return true;
			}
		} else {
			return false;
		}
	}

	public function shrinkUrls(string $url, string $campaignSource, string $campaignMedium, string $campaignName, string $campaignTerm, string $campaignContent, string $customLink = '')	
	{
		$sources = [];

		if (preg_match('/.*\[([0-9,].+)\]$/', $campaignSource, $matches) && $customLink == '') {
			if (count($numbers = explode(',', $matches[1])) == 2) {
				for ($i = $numbers[0]; $i <= $numbers[1]; $i++) {
					$sources[] = $i;	
				}
				$campaignSource = substr($campaignSource, 0, strpos($campaignSource, '['));
			}
		} else {
			$sources[] = '';
		}

		foreach ($sources as $postfix) {
			$analyticsUrls[] = $url . '/?utm_source=' . rawurlencode($campaignSource) . $postfix . '&utm_medium=' .rawurlencode($campaignMedium) . '&utm_campaign=' . rawurlencode($campaignName) . '&utm_term=' . rawurlencode($campaignTerm) . '&utm_content=' . rawurlencode($campaignContent); 
		}

		foreach ($analyticsUrls as $anUrl) {
			$shortUrl = $this->generateShortLink($anUrl);
			if (!empty($customLink) && !$this->checkLinkExists($customLink)) {
				$shortUrl = $this->shrinkerUrl . '/' . $customLink;
			}
			$urls[] = ['longurl' => $anUrl, 'shorturl' => $shortUrl]; 
			$this->saveLink($anUrl, $shortUrl);
		}

		return $urls;
	}

	public function expandUrl(string $shortUrl) : string
	{
		return $this->redis->get($shortUrl);
	}

	public function saveLink(string $longLink, string $shortLink) : bool
	{
		return $this->redis->set($shortLink, $longLink);
	}

	public function generateShortLink(string $longLink) : string
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$randomString = '';
    		do {
			for ($i = 0; $i < 5; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
		} while ($this->checkLinkExists($randomString));

    		return $this->shrinkerUrl. '/' . $randomString;
	}
}
