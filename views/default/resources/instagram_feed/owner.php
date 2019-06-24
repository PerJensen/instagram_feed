<?php
/**
 * Individual's instagram_feed
 *
 * @package instagram_feed
 */

$username = elgg_extract('username', $vars);

$user = get_user_by_username($username);
if (!$user) {
	throw new \Elgg\EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'instagram_feed', $user);

elgg_register_title_button('instagram_feed', 'add', 'object', 'instagram_feed');

$vars['entity'] = $user;

if ($user->guid == elgg_get_logged_in_user_guid()) {
	$title = elgg_echo("instagram_feed:mine");
} else {
	$title = elgg_echo("collection:object:instagram_feed:owner", [$user->getDisplayName()]);
}

$content = elgg_view('instagram_feed/listing/owner', $vars);

$body = elgg_view_layout('default', [
	'filter_value' => $user->guid == elgg_get_logged_in_user_guid() ? 'mine' : 'none',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('instagram_feed/sidebar', $vars),
]);

echo elgg_view_page($title, $body);
