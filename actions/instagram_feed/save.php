<?php
/**
* Elgg Instagram Feed save action
*
* @package instagram_feed
*/

$title = elgg_get_title_input();
$description = get_input('description');
$instagram_access_token = get_input('instagram_access_token');
$access_id = get_input('access_id');
$tags = get_input('tags');
$guid = get_input('guid');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());

elgg_make_sticky_form('instagram_feed');

if (!$title) {
	return elgg_error_response(elgg_echo('instagram_feed:save:failed'));
}

if (!$instagram_access_token) {
	return elgg_error_response(elgg_echo('instagram_feed:save:failed'));
}

if ($guid == 0) {
	$instagram_feed = new ElggInstagramFeed;
	$instagram_feed->container_guid = (int) get_input('container_guid', elgg_get_logged_in_user_guid());
	$new = true;
} else {
	$instagram_feed = get_entity($guid);
	if (!$instagram_feed instanceof ElggInstagramFeed || !$instagram_feed->canEdit()) {
		return elgg_error_response(elgg_echo('instagram_feed:save:failed'));
	}
}

$instagram_feed->instagram_access_token = $instagram_access_token;
$instagram_feed->title = $title;
$instagram_feed->description = $description;
$instagram_feed->access_id = $access_id;
$instagram_feed->tags = string_to_tag_array($tags);

if (!$instagram_feed->save()) {
	return elgg_error_response(elgg_echo('instagram_feed:save:failed'));
}

elgg_clear_sticky_form('instagram_feed');

//add to river only if new
if ($new) {
	elgg_create_river_item([
		'view' => 'river/object/instagram_feed/create',
		'action_type' => 'create',
		'object_guid' => $instagram_feed->getGUID(),
	]);
}

return elgg_ok_response('', elgg_echo('instagram_feed:save:success'), $instagram_feed->getURL());
