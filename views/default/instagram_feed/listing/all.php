<?php
/**
 * List all users with an Instagram feed
 *
 * @package instagram_feed
 */

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'instagram_feed',
	'no_results' => elgg_echo('instagram_feed:none'),
	'distinct' => false,
]);
