<?php
/**
 * Individual's Instagram Feed
 *
 * @package instagram_feed
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggUser) {
	return;
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'instagram_feed',
	'owner_guids' => $entity->guid,
	'no_results' => elgg_echo('instagram_feed:none'),
]);
