<?php
class Controller_Book extends Controller_template
{
	public function action_index()
	{
		$this->template->title = '教養特論：アグリコラ拡張学・特設ページ';
		$this->template->ogp_image_large = 'book/banner.png';
		$this->template->description = '2018年11月下旬より、アグリコラ拡張本「教養特論：アグリコラ拡張学」を頒布いたします！';
		$this->template->contents = View::forge('book/index');
	}
}