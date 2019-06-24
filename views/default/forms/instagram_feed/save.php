<?php
/**
 * Edit / add a feed
 *
 * @package instagram_feed
 */

$url = "https://instagram.pixelunion.net/";

$text = elgg_echo('instagram_feed:token:text');
$item = elgg_format_element('div', [
	'class' => 'elgg-content mbl'
], $text);

$item .= elgg_view('output/url', [
	'href' => $url,
	'text' => elgg_echo('instagram_feed:token:button'),
	'icon' => 'instagram',
	'class' => 'elgg-button elgg-button-action mbl',
	'is_trusted' => true,
]);

echo elgg_view_module('info', elgg_echo('instagram_feed:usersettings:module:title'), $item);

$categories_vars = $vars;
$categories_vars['#type'] = 'categories';

$fields = [
	[
		'#label' => elgg_echo('title'),
		'#type' => 'text',
		'required' => true,
		'name' => 'title',
		'value' => elgg_extract('title', $vars),
	],
	[
		'#label' => elgg_echo('instagram_feed:token:label'),
		'#type' => 'text',
		'required' => true,
		'name' => 'instagram_access_token',
		'value' => elgg_extract('instagram_access_token', $vars),
	],
	[
		'#label' => elgg_echo('description'),
		'#type' => 'text',
		'name' => 'description',
		'value' => elgg_extract('description', $vars),
		'editor_type' => 'simple',
	],
	[
		'#label' => elgg_echo('tags'),
		'#type' => 'tags',
		'name' => 'tags',
		'id' => 'instagram_tags',
		'value' => elgg_extract('tags', $vars),
	],
	$categories_vars,
	[
		'#label' => elgg_echo('access'),
		'#type' => 'access',
		'name' => 'access_id',
		'value' => elgg_extract('access_id', $vars, ACCESS_DEFAULT),
		'entity' => get_entity(elgg_extract('guid', $vars)),
		'entity_type' => 'object',
		'entity_subtype' => 'instagram_feed',
	],
	[
		'#type' => 'hidden',
		'name' => 'container_guid',
		'value' => elgg_extract('container_guid', $vars),
	],
	[
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => elgg_extract('guid', $vars),
	],
];

foreach ($fields as $field) {
	echo elgg_view_field($field);
}

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);
elgg_set_form_footer($footer);
