<?php
/**
 * New Instagram Feed river entry
 *
 * @package instagram_feed
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
$vars['message'] = elgg_get_excerpt($object->description);

echo elgg_view('river/elements/layout', $vars);
