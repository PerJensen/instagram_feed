<?php
/**
 * List all users with an Instagram Feed
 *
 * @package instagram_feed
 */

elgg_push_collection_breadcrumbs('object', 'instagram_feed');

elgg_register_title_button('instagram_feed', 'add', 'object', 'instagram_feed');

$title = elgg_echo('collection:object:instagram_feed:all');
$content = elgg_view('instagram_feed/listing/all', $vars);
$sidebar = elgg_view('instagram_feed/sidebar', $vars);

$body = elgg_view_layout('content', [
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
]);

echo elgg_view_page($title, $body);
