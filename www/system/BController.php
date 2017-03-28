<?php

/**
 * Created by Ana Zalozna
 * Date: 23/01/17
 * Time: 7:07 PM
 */
abstract class BController extends Controller
{
	public function __construct(){
		parent::__construct();

		$this->_template = Config::get('global')['admin_template'];
	}
}