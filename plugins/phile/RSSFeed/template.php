<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo $site_title ?></title>
		<link><?php echo $base_url ?></link>
		<description>RSS feed for <?php echo $site_title ?></description>
		<atom:link href="<?php echo $base_url.$feed_url ?>" rel="self" type="application/rss+xml" />
		<?php foreach ($pages as $page): ?>
			<?php if (isset($page['meta'][$post_key])): ?>
				<item>
					<title><?php echo $page['title'] ?></title>
					<description><![CDATA[<?php echo $page['content'] ?>]]></description>
					<link><?php echo $base_url.'/'.$page['url'] ?></link>
					<pubDate><?php echo date("D, d M Y H:i:s O", strtotime($page['meta']['date'])) ?></pubDate>
					<guid><?php echo $base_url.'/'.$page['url'] ?></guid>
				</item>
			<?php endif ?>
		<?php endforeach ?>
	</channel>
</rss>