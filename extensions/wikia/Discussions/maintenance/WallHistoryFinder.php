<?php

namespace Discussions;

class WallHistoryFinder {

	const TABLE_WALL_HISTORY = 'wall_history';
	const TABLE_PAGE = 'page';

	const COLUMNS = [
		'revision_id',
		'comment_id',
		'event_date',
		'action',
		'is_reply',
		'post_user_id',
	];
	private $dbh;

	public function __construct( $dbh ) {
		$this->dbh = $dbh;
	}

	/**
	 * Wall_history
	 * +-------------------+------------------+------+-----+-------------------+-------+
	 * | Field             | Type             | Null | Key | Default           | Extra |
	 * +-------------------+------------------+------+-----+-------------------+-------+
	 * | parent_page_id    | int(8) unsigned  | YES  | MUL | NULL              |       |
	 * | post_user_id      | int(10) unsigned | YES  |     | NULL              |       |
	 * | post_user_ip_bin  | varbinary(16)    | YES  |     | NULL              |       |
	 * | is_reply          | tinyint(1)       | YES  |     | NULL              |       |
	 * | action            | tinyint(3)       | YES  |     | NULL              |       |
	 * | metatitle         | varchar(201)     | YES  |     | NULL              |       |
	 * | reason            | varchar(101)     | YES  |     | NULL              |       |
	 * | parent_comment_id | int(8) unsigned  | YES  | MUL | NULL              |       |
	 * | comment_id        | int(8) unsigned  | YES  | MUL | NULL              |       |
	 * | revision_id       | int(8) unsigned  | YES  |     | NULL              |       |
	 * | event_date        | timestamp        | NO   |     | CURRENT_TIMESTAMP |       |
	 * +-------------------+------------------+------+-----+-------------------+-------+
	 *
	 * Page
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 * | Field             | Type                | Null | Key | Default        | Extra          |
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 * | page_id           | int(10) unsigned    | NO   | PRI | NULL           | auto_increment |
	 * | page_namespace    | int(10) unsigned    | NO   | MUL | NULL           |                |
	 * | page_title        | varchar(255)        | NO   |     | NULL           |                |
	 * | page_restrictions | tinyblob            | NO   |     | NULL           |                |
	 * | page_is_redirect  | tinyint(3) unsigned | NO   | MUL | 0              |                |
	 * | page_is_new       | tinyint(3) unsigned | NO   |     | 0              |                |
	 * | page_random       | double unsigned     | NO   | MUL | NULL           |                |
	 * | page_touched      | binary(14)          | NO   |     |                |                |
	 * | page_latest       | int(10) unsigned    | NO   |     | NULL           |                |
	 * | page_len          | int(10) unsigned    | NO   | MUL | NULL           |                |
	 * +-------------------+---------------------+------+-----+----------------+----------------+
	 */
	public function find() {
		return ( new \WikiaSQL() )->SELECT( ...self::COLUMNS )
			->FROM( self::TABLE_WALL_HISTORY )
			->LEFT_JOIN( self::TABLE_PAGE )
			->ON( 'parent_page_id', 'page_id' )
			->AS_( 'p' )
			->WHERE( 'p.page_namespace' )
			->EQUAL_TO( NS_WIKIA_FORUM_BOARD )
			->runLoop( $this->dbh, function ( &$entries, $row ) {
				$entries[] = get_object_vars($row);
			} );
	}

}
