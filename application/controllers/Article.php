<?php

class Article extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('article_model');
  }

  public function index()
{
	$this->load->library('pagination');

	$config['base_url'] = site_url('/article');
	$config['page_query_string'] = TRUE;
	$config['total_rows'] = $this->article_model->get_published_count();
	$config['per_page'] = 2;

	$this->pagination->initialize($config);
	$limit = $config['per_page'];
	$offset = html_escape($this->input->get('per_page'));

	$data['articles'] = $this->article_model->get_published($limit, $offset);

	if(count($data['articles']) > 0){
		$this->load->view('articles/list_article.php', $data);
	} else {
		$this->load->view('articles/empty_article.php');
	}
}

  public function show($slug = null)
  {
    // jika gak ada slug di URL tampilkan 404
    if (!$slug) {
      show_404();
    }

    // ambil artikel dengan slug yang diberikan
    $data['article'] = $this->article_model->find_by_slug($slug);

    // jika artikel tidak ditemuakn di database tampilkan 404
    if (!$data['article']) {
      show_404();
    }

    // tampilkan artikel
    $this->load->view('articles/show_article.php', $data);
  }
}