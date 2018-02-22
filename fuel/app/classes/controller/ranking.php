<?php
class Controller_Ranking extends Controller_Template
{
	public function action_index()
	{
		$this->template->title = '統計';
		$this->template->description = '「ぶらつき学生ポータル」に登録されたデータを集計したランキングです。';
		$this->template->contents = View::forge('ranking/index');
		$high_rate_occupations_query = DB::query('
			SELECT *
			FROM cards_occupations
			INNER JOIN (
				SELECT cards_opinions.card_id, AVG(points) AS average, COUNT(*) AS `count`
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "occupations"
				GROUP BY cards_opinions.card_id
    			HAVING COUNT(*) >= 2
				ORDER BY AVG(points) desc
				LIMIT 5
			) opinions
			ON cards_occupations.occupation_id = opinions.card_id
		');
		$high_rate_occupations_data = $high_rate_occupations_query->execute()->as_array();
		$this->template->contents->high_rate_occupations_data = $this->rank($high_rate_occupations_data, 'average');

		$low_rate_occupations_query = DB::query('
			SELECT *
			FROM cards_occupations
			INNER JOIN (
				SELECT cards_opinions.card_id, AVG(points) AS average, COUNT(*) AS `count`
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "occupations"
				GROUP BY cards_opinions.card_id
    			HAVING COUNT(*) >= 2
				ORDER BY AVG(points) asc
				LIMIT 5
			) opinions
			ON cards_occupations.occupation_id = opinions.card_id
		');
		$low_rate_occupations_data = $low_rate_occupations_query->execute()->as_array();
		$this->template->contents->low_rate_occupations_data = $this->rank($low_rate_occupations_data, 'average');

		$high_rate_minor_improvements_query = DB::query('
			SELECT *
			FROM cards_improvements
			INNER JOIN (
				SELECT cards_opinions.card_id, AVG(points) AS average, COUNT(*) AS `count`
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "improvements"
				AND cards_list.card_id NOT IN ("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "M001", "M002", "M003", "M004", "M005", "M006", "M007", "M008", "M009", "M010", "M011", "M012", "M013", "M014")
				GROUP BY cards_opinions.card_id
    			HAVING COUNT(*) >= 2
				ORDER BY AVG(points) desc
				LIMIT 5
			) opinions
			ON cards_improvements.improvement_id = opinions.card_id
		');
		$high_rate_minor_improvements_data = $high_rate_minor_improvements_query->execute()->as_array();
		$this->template->contents->high_rate_minor_improvements_data = $this->rank($high_rate_minor_improvements_data, 'average');

		$low_rate_minor_improvements_query = DB::query('
			SELECT *
			FROM cards_improvements
			INNER JOIN (
				SELECT cards_opinions.card_id, AVG(points) AS average, COUNT(*) AS `count`
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "improvements"
				AND cards_list.card_id NOT IN ("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "M001", "M002", "M003", "M004", "M005", "M006", "M007", "M008", "M009", "M010", "M011", "M012", "M013", "M014")
				GROUP BY cards_opinions.card_id
    			HAVING COUNT(*) >= 2
				ORDER BY AVG(points) asc
				LIMIT 5
			) opinions
			ON cards_improvements.improvement_id = opinions.card_id
		');
		$low_rate_minor_improvements_data = $low_rate_minor_improvements_query->execute()->as_array();
		$this->template->contents->low_rate_minor_improvements_data = $this->rank($low_rate_minor_improvements_data, 'average');

		$deviate_rate_occupations_query = DB::query('
			SELECT *
			FROM cards_occupations
			INNER JOIN (
				SELECT cards_opinions.card_id, STDDEV(points) AS stddev
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "occupations"
				GROUP BY cards_opinions.card_id
				ORDER BY STDDEV(points) desc
				LIMIT 5
			) opinions
			ON cards_occupations.occupation_id = opinions.card_id
		');
		$deviate_rate_occupations_data = $deviate_rate_occupations_query->execute()->as_array();
		$this->template->contents->deviate_rate_occupations_data = $this->rank($deviate_rate_occupations_data, 'stddev');

		$deviate_rate_minor_improvements_query = DB::query('
			SELECT *
			FROM cards_improvements
			INNER JOIN (
				SELECT cards_opinions.card_id, STDDEV(points) AS stddev
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "improvements"
				AND cards_list.card_id NOT IN ("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "M001", "M002", "M003", "M004", "M005", "M006", "M007", "M008", "M009", "M010", "M011", "M012", "M013", "M014")
				GROUP BY cards_opinions.card_id
				ORDER BY STDDEV(points) desc
				LIMIT 5
			) opinions
			ON cards_improvements.improvement_id = opinions.card_id
		');
		$deviate_rate_minor_improvements_data = $deviate_rate_minor_improvements_query->execute()->as_array();
		$this->template->contents->deviate_rate_minor_improvements_data = $this->rank($deviate_rate_minor_improvements_data, 'stddev');

		$order_rank_5_query = DB::query('
			SELECT player_order, AVG(rank) AS average
			FROM result_score
			JOIN result_overview
			ON result_score.game_id = result_overview.game_id
			WHERE result_overview.player_num = 5
			GROUP BY player_order
			ORDER BY AVG(rank) asc;
		');
		$order_rank_5_data = $order_rank_5_query->execute()->as_array();
		$order_rank_5_data = $this->rank($order_rank_5_data, 'average');
		$this->template->contents->order_rank_5_data = $order_rank_5_data;

		$player_rank_avg_query = DB::query('
			SELECT * FROM (
				SELECT AVG(rank) AS average, result_players.player_id, result_overview.player_num
				FROM result_score
				INNER JOIN result_players
				ON result_score.game_id = result_players.game_id
				AND result_score.player_order = result_players.player_order
				INNER JOIN result_overview
				ON result_score.game_id = result_overview.game_id
				WHERE result_overview.player_num = 5
				GROUP BY result_players.player_id
				HAVING COUNT(*) >= 2
			) average_table
			JOIN users_profile
			ON average_table.player_id = users_profile.user_id
            ORDER BY average ASC
            LIMIT 5;
		');
		$player_rank_avg_data = $player_rank_avg_query->execute()->as_array();
		$this->template->contents->player_rank_avg_data = $this->rank($player_rank_avg_data, 'average');

		$high_score_5_all_query = DB::query('
			SELECT result_score.game_id, result_score.player_order, total_score, player_num, regulation, screen_name
			FROM result_score
			INNER JOIN result_overview
			ON result_score.game_id = result_overview.game_id
			INNER JOIN result_players
			ON result_score.game_id = result_players.game_id
			AND result_score.player_order = result_players.player_order
			INNER JOIN users_profile
			ON result_players.player_id = users_profile.user_id
			WHERE player_num = 5
			AND regulation = "全混ぜ"
			ORDER BY total_score DESC
			LIMIT 5;
		');
		$high_score_5_all_data = $high_score_5_all_query->execute()->as_array();
		$this->template->contents->high_score_5_all_data = $this->rank($high_score_5_all_data, 'total_score');

		$high_score_3_all_m_query = DB::query('
			SELECT result_score.game_id, result_score.player_order, total_score, player_num, regulation, screen_name
			FROM result_score
			INNER JOIN result_overview
			ON result_score.game_id = result_overview.game_id
			INNER JOIN result_players
			ON result_score.game_id = result_players.game_id
			AND result_score.player_order = result_players.player_order
			INNER JOIN users_profile
			ON result_players.player_id = users_profile.user_id
			WHERE player_num = 3
			AND regulation = "全混ぜ+泥沼"
			ORDER BY total_score DESC
			LIMIT 5;
		');
		$high_score_3_all_m_data = $high_score_3_all_m_query->execute()->as_array();
		$this->template->contents->high_score_3_all_m_data = $this->rank($high_score_3_all_m_data, 'total_score');
	}

	private function rank($data, $column)
	{
		$i = count($data);
		$rank = 0;
		$stack = 0;
		for ($i = 0; $i < 5; $i++)
		{
			if ($i === 0 or $data[$i][$column] !== $data[$i - 1][$column])
			{
				if ($stack !== 0)
				{
					$rank += $stack;
					$stack = 0;
				}
				$rank++;
			}
			else
			{
				$stack++;
			}
			$data[$i]['ranking'] = $rank;
		}
		return $data;
	}
}