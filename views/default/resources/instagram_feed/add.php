<?php
/**
 * Add Instagram Feed
 *
 * @package instagram_feed
 */

$title = elgg_echo('add:object:instagram_feed');

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid);

$page_owner = get_entity($guid);

if (!$page_owner->canWriteToContainer(0, 'object', 'instagram_feed')) {
	throw new \Elgg\EntityPermissionsException();
}

elgg_push_collection_breadcrumbs('object', 'instagram_feed', $page_owner);
elgg_push_breadcrumb($title);

$vars = instagram_feed_prepare_form_vars();
$content = elgg_view_form('instagram_feed/save', [], $vars);

$body = elgg_view_layout('default', [
	'filter_id' => 'instagram_feed/edit',
	'content' => $content,
	'title' => $title,
]);

echo elgg_view_page($title, $body);
