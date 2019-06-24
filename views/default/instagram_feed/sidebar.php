<?php
/**
 * Instagram Feed sidebar
 *
 * @package instagram_feed
 */

echo elgg_view('page/elements/comments_block', [
	'subtypes' => 'instagram_feed',
	'container_guid' => elgg_get_page_owner_guid(),
]);

echo elgg_view('page/elements/tagcloud_block', [
	'subtypes' => 'instagram_feed',
	'container_guid' => elgg_get_page_owner_guid(),
]);
