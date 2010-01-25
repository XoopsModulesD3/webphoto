<?php
// $Id: main.php,v 1.1 2010/01/25 10:05:02 ohwada Exp $

//=========================================================
// webphoto module
// 2010-01-10 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_main
//=========================================================
class webphoto_main extends webphoto_base_this
{
	var $_public_class;
	var $_sort_class;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_main( $dirname , $trust_dirname )
{
	$this->webphoto_base_this( $dirname , $trust_dirname );

	$this->_public_class
		=& webphoto_photo_public::getInstance( $dirname, $trust_dirname );
	$this->_sort_class 
		=& webphoto_photo_sort::getInstance( $dirname, $trust_dirname );
}

function &getInstance( $dirname , $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_main( $dirname , $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// detail
//---------------------------------------------------------
function build_rows_for_detail( $mode, $sort, $limit, $start )
{
	$title   = $this->build_title( $mode );
	$name    = $this->_sort_class->mode_to_name( $mode );
	$orderby = $this->_sort_class->mode_to_orderby( $mode, $sort );

	$rows  = null;
	$total = $this->_public_class->get_count_by_name_param( $name, null );

	if ( $total > 0 ) {
		$rows = $this->_public_class->get_rows_by_name_param_orderby( 
			$name, null, $orderby, $limit, $start );
	}

	return array( $title, $total, $rows );
}

function build_title( $mode )
{
	$str = $this->sanitize( $this->get_constant( 'title_'. $mode ) );
	return $str;
}

// --- class end ---
}

?>