<?php

class ExactTargetUpdatesHooks {

	public static function onSignupConfirmEmailComplete( User $user ) {
		$thisInstance = new ExactTargetUpdatesHooks();
		$thisInstance->onSignupConfirmEmailCompleteRun( $user );
		return true;
	}

	public function onSignupConfirmEmailCompleteRun( User $user ) {
		global $wgWikiaEnvironment;
		if ( $wgWikiaEnvironment != WIKIA_ENV_DEV && $wgWikiaEnvironment != WIKIA_ENV_INTERNAL ) {
			$aParams = $this->prepareParams( $user );
			$task = new ExactTargetAddUserTask();
			$task->call( 'sendNewUserData', $aParams );
			$task->queue();
		}
		return true;
	}

	public function prepareParams( User $oUser ) {
		$aUserParams = [
			'user_id' => $oUser->getId(),
			'user_name' => $oUser->getName(),
			'user_real_name' => $oUser->getRealName(),
			'user_email' => $oUser->getEmail(),
			'user_email_authenticated' => $oUser->getEmailAuthenticationTimestamp(),
			'user_registration' => $oUser->getRegistration(),
			'user_editcount' => $oUser->getEditCount(),
			'user_options' => $oUser->getOptions(),
			'user_touched' => $oUser->getTouched()
		];
		return $aUserParams;
	}
}
