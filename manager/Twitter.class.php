<?php

class Twitter
{
	public function __construct()
	{

	}

	public function getTweetsByHashtag($json)
	{
		$hashtag = $json['hashtag'];
		$data = file_get_contents('http://loklak.org/api/search.json?timezoneOffset=-60&q=%23'.$hashtag);
		$data = json_decode($data, true);

		$tweets = [];
		$i = 0;
		foreach ($data['statuses'] as $tweet)
		{
			$tweets[$i] = ['id' => $tweet['id_str'],
						 'created' => date('Y-m-d H:i:s', strtotime($tweet['created_at'])),
						 'text' => $tweet['text'],
						 'link' => $tweet['link'],
						 'nb_favourites' => $tweet['favourites_count'],
						 'nb_retweet' => $tweet['retweet_count'],
						 'hashtags' => $tweet['hashtags'],
						 'user' => ['id' => $tweet['user']['user_id'],
						 			'name' => $tweet['user']['name'],
						 			'screen_name' => $tweet['user']['screen_name'],
						 			'image_url' => (isset($tweet['user']['profile_image_url_https']) ? $tweet['user']['profile_image_url_https'] : null)],
						 'location' => null,
						 'language' => (isset($tweet['classifier_language']) ? $tweet['classifier_language'] : null)];
			if (isset($tweet['place_name']) && isset($tweet['location_point']))
			{
				$place_name = explode(', ', $tweet['place_name']);
				$tweets[$i]['location'] = ['city' => $place_name[0],
										   'state' => (count($place_name) == 2 ? $place_name[1] : null),
										   'latitude' => round($tweet['location_point'][0], 8),
										   'longitude' => round($tweet['location_point'][1], 8)];
			}
			$i++;
		}
		//Response::quickResponse(200, date('Y-m-d H:i:s', strtotime($tweets[0]['created'])));
		//Response::quickResponse(200, print_r($tweets, true));
		TweetRepo::addAll($tweets);
	}

}
