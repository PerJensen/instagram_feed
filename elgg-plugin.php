<?php

return [
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'instagram_feed',
			'class' => 'ElggInstagramFeed',
			'searchable' => true,
		],
	],
	'actions' => [
		'instagram_feed/save' => [],
	],
	'routes' => [
		'default:object:instagram_feed' => [
			'path' => '/instagram_feed',
			'resource' => 'instagram_feed/all',
		],
		'collection:object:instagram_feed:all' => [
			'path' => '/instagram_feed/all',
			'resource' => 'instagram_feed/all',
		],
		'collection:object:instagram_feed:owner' => [
			'path' => '/instagram_feed/owner/{username}',
			'resource' => 'instagram_feed/owner',
		],
		'collection:object:instagram_feed:friends' => [
			'path' => '/instagram_feed/friends/{username}',
			'resource' => 'instagram_feed/friends',
		],
		'add:object:instagram_feed' => [
			'path' => '/instagram_feed/add/{guid}',
			'resource' => 'instagram_feed/add',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'view:object:instagram_feed' => [
			'path' => '/instagram_feed/view/{guid}/{title?}',
			'resource' => 'instagram_feed/view',
		],
		'edit:object:instagram_feed' => [
			'path' => '/instagram_feed/edit/{guid}',
			'resource' => 'instagram_feed/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
	],
];
