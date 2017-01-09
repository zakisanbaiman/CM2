<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => array(


		'Facebook' => array(
			'client_id'     => '558941007596404',
			'client_secret' => 'fc36758ae50f7967bc142db503a6d720',
			'scope'         => array('email'),
		),


		'Google' => array(
			'client_id'     => '1036406248829-u7uqe6pg97ngotuqtcg22tvij2tnnpc4.apps.googleusercontent.com',
			'client_secret' => 'HivK7QnGHd6W9C6q2OzFvci5',
			'scope'         => array('userinfo_email', 'userinfo_profile'),
		),


		'Twitter' => array(
			'client_id'     => 'rhWFKprPkwHXvVHKLW183fwVD',
			'client_secret' => 'T5ZToXxBjtG680e8hoeq7uvSVHyMl6Vx3DN7Vx01c0RVl3alwe',
			// No scope - oauth1 doesn't need scope
		),

	)

);