<?php
/**
 * View a feed
 *
 * @package instagram_feed
 */

$guid = elgg_extract('guid', $vars);

elgg_entity_gatekeeper($guid, 'object', 'instagram_feed');

$entity = get_entity($guid);

elgg_push_entity_breadcrumbs($entity, false);

$title = $entity->getDisplayName();

$content = elgg_view_entity($entity, [
	'full_view' => true,
	'show_responses' => true,
]);

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'entity' => $entity,
]);

echo elgg_view_page($title, $body);
