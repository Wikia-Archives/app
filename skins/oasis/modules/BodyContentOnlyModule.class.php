<?php
class BodyContentOnlyModule extends WikiaController {

	public function executeIndex() {
		$this->bodytext = $this->app->getSkinTemplateObj()->data['bodytext'];
	}
}
