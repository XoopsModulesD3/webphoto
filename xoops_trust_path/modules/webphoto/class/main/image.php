<?php
// $Id: image.php,v 1.3 2008/11/19 10:26:00 ohwada Exp $

//=========================================================
// webphoto module
// 2008-11-16 K.OHWADA
//=========================================================

if ( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_main_image
//=========================================================
class webphoto_main_image extends webphoto_file_read
{
	var $_kind_class ;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_main_image( $dirname, $trust_dirname )
{
	$this->webphoto_file_read( $dirname, $trust_dirname );

	$this->_kind_class =& webphoto_kind::getInstance();
}

function &getInstance( $dirname, $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_main_image( $dirname, $trust_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// public
//---------------------------------------------------------
function main()
{
	$item_id   = $this->_post_class->get_post_get_int('item_id');
	$file_kind = $this->_post_class->get_post_get_int('file_kind');

	$item_row = $this->get_item_row( $item_id );
	if ( !is_array($item_row) ) {
		exit();
	}

	$file_row = $this->get_file_row( $item_row, $file_kind );
	if ( !is_array($file_row) ) {
		exit();
	}

	$ext  = $file_row['file_ext'] ;
	$mime = $file_row['file_mime'] ;
	$size = $file_row['file_size'] ;
	$file = $file_row['file_full'] ;

	if ( ! $this->_kind_class->is_image_ext( $ext ) ) {
		exit();
	}

	$this->zlib_off();
	$this->http_output_pass();

	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: '. $mime );
	header('Content-Length: '. $size );

	readfile( $file ) ;
	exit();
}

// --- class end ---
}

?>