<?php


class Home extends Controller
{
	public function index()
	{
		$this->load->model('example');
		$this->load->view('example');
	}
}