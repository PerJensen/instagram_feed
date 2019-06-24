<?php
/**
 * Elgg Instagram Feed view
 *
 * @uses $vars['entity'] ElggInstagramFeed to show
 */

$full = elgg_extract('full_view', $vars, false);
$entity = elgg_extract('entity', $vars, false);
if (!elgg_instanceof($entity, 'object', 'instagram_feed')) {
	return;
}

if ($full && !elgg_in_context('gallery')) {

	elgg_require_js('instagram_feed/get-feed');
	
	$token = $entity->instagram_access_token;
		
	$body = elgg_format_element('div', [
		'id' => 'instagram-user-info',
		'class' => 'elgg-image-block'
	], '');
	
	$instagram = elgg_format_element('ul', [
		'id' => 'instagram-feed-canvas',
		'class' => 'elgg-gallery'
	]);
	
	$body .= elgg_format_element('div', ['id' => 'instafeed'], $instagram);
	
	$token = json_encode($token);
	$body .= "<script>var accesstoken = $token;</script>";
	
	$params = [
		'show_summary' => true,
		'icon' => true,
		'body' => $body,
		'show_responses' => elgg_extract('show_responses', $vars, false),
		'show_navigation' => true,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/full', $params);
	
} else {
	
	// brief view
	$params = [
		'content' => elgg_get_excerpt($entity->description),
		'icon' => true,
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}
