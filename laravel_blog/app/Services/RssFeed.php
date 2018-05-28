<?php

namespace App\Services;

use App\Http\Model\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
  /**
   * Return the content of the RSS feed
   */
  public function getRSS()
  {
    if (Cache::has('rss-feed')) {
      return Cache::get('rss-feed');
    }

    $rss = $this->buildRssData();
    Cache::add('rss-feed', $rss, 120);

    return $rss;
  }

  /**
   * Return a string with the feed data
   *
   * @return string
   */
  protected function buildRssData()
  {
    $now = Carbon::now();
    $feed = new Feed();
    $channel = new Channel();
    $channel
      ->title(config('rss.title'))
      ->description(config('rss.description'))
      ->url(url('/'))
      ->language('en')
      ->copyright('Copyright (c) '.config('rss.author'))
      ->lastBuildDate($now->timestamp)
      ->appendTo($feed);

    $posts = Article::where('created_at', '<=', time())
      ->orderBy('created_at', 'desc')
      ->take(config('rss.rss_size'))
      ->get();
    foreach ($posts as $post) {
      $item = new Item();
      $item
        ->title($post->art_title)
        ->description($post->art_description)
        ->url(url('a/'.$post->art_id))
        ->pubDate($post->created_at)
        ->guid($post->art_id, true)
        ->appendTo($channel);
    }

    $feed = (string)$feed;

    // Replace a couple items to make the feed more compliant
    $feed = str_replace(
      '<rss version="2.0">',
      '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
      $feed
    );
    $feed = str_replace(
      '<channel>',
      '<channel>'."\n".'    <atom:link href="'.url('/rss').
      '" rel="self" type="application/rss+xml" />',
      $feed
    );

    return $feed;
  }
}