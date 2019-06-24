<?php
/*
 * Instagram Feed
 *
 * @author Per Jensen
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 * @copyright Copyright (c) 2019, Per Jensen
 *
 */

return function() {
	elgg_register_event_handler('init', 'system', 'instagram_feed_init');
};

function instagram_feed_init() {

	elgg_set_entity_class('object', 'instagram_feed', ElggInstagramFeed::class);

	// plugin specific CSS
	elgg_extend_view('elgg.css', 'instagram_feed/instagram_feed.css');
	
	// add instagram link to owner block
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'instagram_feed_owner_block_menu');

	// Register for notifications
	elgg_register_notification_event('object', 'instagram_feed', ['create']);
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:instagram_feed', 'instagram_feed_prepare_notification');

	// allow to be liked
	elgg_register_plugin_hook_handler('likes:is_likable', 'object:instagram_feed', 'Elgg\Values::getTrue');
	
	// menus
	elgg_register_menu_item('site', [
		'name' => 'instagram',
		'icon' => 'instagram',
		'text' => elgg_echo('collection:object:instagram_feed'),
		'href' => elgg_generate_url('default:object:instagram_feed'),
	]);
	
}

/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $instagram_feed A instagram_feed object.
 * @return array
 */
function instagram_feed_prepare_form_vars($instagram_feed = null) {
	// input names => defaults
	$values = [
		'title' => get_input('title', ''),
		'instagram_access_token' => get_input('instagram_access_token', ''),
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $instagram_feed,
	];

	if ($instagram_feed) {
		foreach (array_keys($values) as $field) {
			if (isset($instagram_feed->$field)) {
				$values[$field] = $instagram_feed->$field;
			}
		}
	}

	if (elgg_is_sticky_form('instagram_feed')) {
		$sticky_values = elgg_get_sticky_values('instagram_feed');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('instagram_feed');

	return $values;
}

/**
 * Prepare a notification message about a new feed
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg\Notifications\Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg\Notifications\Notification
 */
function instagram_feed_prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$language = $params['language'];

	$descr = $entity->description;
	$title = $entity->getDisplayName();

	$notification->subject = elgg_echo('instagram_feed:notify:subject', [$title], $language);
	$notification->body = elgg_echo('instagram_feed:notify:body', [
		$owner->getDisplayName(),
		$title,
		$descr,
		$entity->getURL()
	], $language);
	$notification->summary = elgg_echo('instagram_feed:notify:summary', [$title], $language);
	$notification->url = $entity->getURL();
	return $notification;
}

/**
 * Add a menu item to the user ownerblock
 *
 * @param string         $hook   'register'
 * @param string         $type   'menu:owner_block'
 * @param ElggMenuItem[] $return current return value
 * @param array          $params supplied params
 *
 * @return ElggMenuItem[]
 */
function instagram_feed_owner_block_menu($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);
	if ($entity instanceof ElggUser) {
		$url = elgg_generate_url('collection:object:instagram_feed:owner', ['username' => $entity->username]);
		$item = new ElggMenuItem('instagram_feed', elgg_echo('collection:object:instagram_feed'), $url);
		$return[] = $item;
	}
	
	return $return;
}
