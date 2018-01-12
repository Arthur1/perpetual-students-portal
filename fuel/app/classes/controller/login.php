<?php
class Controller_Login extends Controller_Template
{
    public function action_index()
    {
        $this->template->title = 'login';
        $view = View::forge('login');
        $url = Session::get_flash('url', '/mypage');
        Session::keep_flash('url');
        if (Input::post('submit'))
        {
            if (! Security::check_token())
            {
                $view->error = 'CSRF token error';
                $this->template->contents = $view;
                return;
            }
            if (! Auth::login())
            {
                $view->error = 'ログインに失敗しました';
                $this->template->contents = $view;
                return;
            }
            Response::redirect($url);
        }
        $this->template->contents = $view;
    }
}