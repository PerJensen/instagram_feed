<?php
/**
 * Check In
 *
 */
 
class ElggInstagramFeed extends ElggObject {

	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "instagram_feed";
	}
}
