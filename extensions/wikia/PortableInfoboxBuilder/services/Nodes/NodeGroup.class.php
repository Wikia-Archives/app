<?php

namespace Wikia\PortableInfoboxBuilder\Nodes;

class NodeGroup extends Node {
	const XML_TAG_NAME = 'group';

	/**
	 * @var array string
	 */
	protected $allowedChildNodes = [ 'data', 'header', 'image' ];

	/**
	 * @var array
	 */
	protected $requiredChildNodes = [ 'header' ];


	public function asJsonObject() {
		return $this->getChildrenAsJsonObjects();
	}
}