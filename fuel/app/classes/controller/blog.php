<?php
class Controller_Blog extends Controller_Template
{
	public function action_list($page)
	{

	}

	public function action_article($blog_id)
	{
		$articles_query = DB::select()
							->from('blog_articles')
							->where('blog_id', '=', $blog_id);
		try
		{
			$articles_data = $articles_query->execute->as_array();
		}
		catch (DatabaseException $e)
		{
			throw new HttpNotFoundException;
		}
		if ($articles_data === [])
		{
			throw new HttpNotFoundException;
		}
		$comments_query = DB::select()
							->from('blog_comments')
							->where('blog_id', '=', $blog_id)
							->order_by('timestamp', 'asc');
		try
		{
			$comments_data = $comments_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			throw new HttpNotFoundException;
		}
	}

	public function action_edit()
	{
		Authplus::check_and_redirect([1]);
		$this->template->contents = View::forge('blog/edit');
		if (Input::post('submit'))
		{
			foreach ($this->fields as $field)
			{
				Session::set_flash($field, Input::post($field));
			}
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが再度送信してください。';
				return;
			}
			$val = $this->generate_val();
			if (! $val->run())
			{
				$this->template->contents->error = $val->error();
				return;
			}
			Response::redirect('blog/confirm');
		}
	}

	public function action_confirm()
	{
		Authplus::check_and_redirect([1]);
		$this->template->title = '確認ページ';
		$this->template->contents = View::forge('blog/confirm');
		foreach ($this->fields as $field)
		{
			$data[$field] = Session::get_flash($field);
			Session::keep_flash($field);
		}
		if ($data[''] === null)
		{
			throw new HttpNotFoundException;
		}
		if (Input::post('return'))
		{
			Response::redirect('blog/edit');
		}
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			$data['blog_id'] = time();
			$query = DB::insert('blog_data')->set($data);
			try
			{
				$query->execute();
				Response::redirect('blog/success');
			}
			catch (DatabaseException $e)
			{
				$this->template->contents->error = 'DB Error';
				return;
			}
		}
	}

	public function action_success()
	{
		foreach ($this->fields as $field)
		{
			Session::delete_flash($field);
		}
		$this->template->title = '作成完了';
		$this->template->contents = View::forge('edit/success');
	}
}