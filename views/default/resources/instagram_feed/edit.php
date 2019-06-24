<?php
/**
 * Add instagram_feed page
 *
 * @package instagram_feed
 */

$instagram_feed_guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($instagram_feed_guid, 'object', 'instagram_feed');

$instagram_feed = get_entity($instagram_feed_guid);

if (!$instagram_feed->canEdit()) {
	throw new \Elgg\EntityPermissionsException(elgg_echo('instagram_feed:unknown_instagram_feed'));
}

$title = elgg_echo('edit:object:instagram_feed');

elgg_push_entity_breadcrumbs($instagram_feed);
elgg_push_breadcrumb($title);

$vars = instagram_feed_prepare_form_vars($instagram_feed);
$content = elgg_view_form('instagram_feed/save', [], $vars);

$body = elgg_view_layout('default', [
	'filter_id' => 'instagram_feed/edit',
	'content' => $content,
	'title' => $title,
]);

echo elgg_view_page($title, $body);
