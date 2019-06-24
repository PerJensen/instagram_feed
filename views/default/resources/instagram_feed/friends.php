<?php
/**
 * Friends Instagram feed
 *
 * @package instagram_feed
 */

$username = elgg_extract('username', $vars);
$owner = get_user_by_username($username);

if (!$owner) {
	throw new \Elgg\EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'instagram_feed', $user, true);

elgg_register_title_button('instagram_feed', 'add', 'object', 'instagram_feed');

$title = elgg_echo("collection:object:instagram_feed:friends");

$params = $vars;
$params['entity'] = $owner;
$content = elgg_view('instagram_feed/listing/friends', $params);

$body = elgg_view_layout('content', [
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
]);

echo elgg_view_page($title, $body);
