<?php

namespace App\Http;

class Flash 
{
	/**
	 * Create a flash message
	 *
	 * @param string 		$title 
	 * @param string 		$message 
	 * @param string 		$level 
	 * @param string | null	$key
	 * @return void 
	 */
	public function create( $title, $message, $level, $key = 'flash_message' )
	{
		session()->flash( $key, [
			'title'		=> $title,
			'message'	=> $message,
			'level'		=> $level
		]);
	} 

	/**
	 * Create information flash message
	 *
	 * @param string 		$title 
	 * @param string 		$message
	 * @return void 
	 */
	public function info( $title, $message )
	{
		return $this->create( $title, $message, 'info' );
	}

	/**
	 * Create success flash message
	 *
	 * @param string 		$title 
	 * @param string 		$message
	 * @return void 
	 */
	public function success( $title, $message )
	{
		return $this->create( $title, $message, 'success' );
	}

	/**
	 * Create error flash message
	 *
	 * @param string 		$title 
	 * @param string 		$message
	 * @return void 
	 */
	public function error( $title, $message )
	{
		return $this->create( $title, $message, 'error' );
	}

	/**
	 * Create overlay flash message
	 *
	 * @param string 		$title 
	 * @param string 		$message
	 * @param string 		$level
	 * @return void 
	 */
	public function overlay( $title, $message, $level = 'success' )
	{
		return $this->create( $title, $message, $level, 'flash_message_overlay' );
	}    
}