<?php
/*
    Tatoeba Project, free collaborative creation of multilingual corpuses project
    Copyright (C) 2009  HO Ngoc Phuong Trang <tranglich@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


$this->pageTitle = __('Tatoeba user : ',true) . $user['User']['username'];
//$javascript->link('users.followers_and_following.js', false);

$navigation->displayUsersNavigation($user['User']['id'], $user['User']['username']);
?>
<div id="annexe_content">

	<div class="module">
	<h2><?php __('Contact'); ?></h2>
	<?php
	echo $html->link(__('Contact this user', true), array('controller' => 'privateMessages', 'action' => 'write', $user['User']['username']));
	?>
	</div>
	
	<?php
	/* Latest contributions from the user */
	if(count($user['Contributions']) > 0){
		echo '<div class="module">';
			echo '<h2>';
			__('Latest contributions');
			echo '</h2>';

			echo '<div id="logs">';
			foreach($user['Contributions'] as $contribution){
				$logs->annexeEntry($contribution);
			}
			echo '</div>';
		echo '</div>';
	}
	?>
</div>

<div id="main_content">
	<div class="module">
	<h2><?php echo sprintf(__('About %s',true), $user['User']['username']); ?></h2>
	<ul>
		<li><?php __('Member since:'); echo ' '.$date->ago($user['User']['since']); ?></li>
	</ul>
	</div>

	<?php
	// if($session->read('Auth.User.id') AND isset($can_follow)){
		// if($can_follow){
			// $style2 = "style='display: none'";
			// $style1 = "";
		// }else{
			// $style1 = "style='display: none'";
			// $style2 = "";
		// }
		// echo ' (';
		// echo '<a id="start" class="followingOption" '.$style1.'>'. __('Start following this person', true). '</a>';
		// echo '<a id="stop" class="followingOption" '.$style2.'>'. __('Stop following this person', true). '</a>';
		// echo ')';
	// }

	/* People that the user is following */

	if(count($user['Following']) > 0){
		echo '<div class="module">';
			echo '<h2>';
			__('Following');
			echo '</h2>';

			echo '<div class="following">';
			echo '<ul>';
			foreach($user['Following'] as $following){
				echo '<li>'.$following['username'].'</li>';
			}
			echo '<ul>';
			echo '</div>';
		echo '</div>';
	}


	/* People that are following the user */
	if(count($user['Follower']) > 0){
		echo '<div class="module">';
			echo '<h2>';
			__('Followers');
			echo '</h2>';

			echo '<div class="followers">';
			echo '<ul>';
			foreach($user['Follower'] as $follower){
				echo '<li>'.$follower['username'].'</li>';
			}
			echo '<ul>';
			echo '</div>';
		echo '</div>';
	}

	/* Latest favorites from the user */
	if(count($user['Favorite']) > 0){
		echo '<div class="module">';
			echo '<h2>';
			__('Favorite sentences');
			echo ' (';
			echo $html->link(
				__('view all', true),
				array(
					"controller" => "favorites",
					"action" => "of_user",
					$user['User']['id']
				)
			);
			echo ')';
			echo '</h2>';

			echo '<table id="logs">';
			foreach($user['Favorite'] as $favorite){
				$sentences->displaySentence($favorite);
			}
			echo '</table>';

		echo '</div>';
	}

	/* Latest sentences, translations or adoptions from the user */
	if(count($user['Sentences']) > 0){
		echo '<div class="module">';
			echo '<h2>';
			__('Latest sentences');
			echo '</h2>';

			foreach($user['Sentences'] as $sentence){
				$sentences->displaySentence($sentence);
			}
		echo '</div>';
	}

	/* Latest comments from the user */
	if(count($user['SentenceComments']) > 0){
		echo '<div class="module">';
			echo '<h2>';
			__('Latest comments');
			echo '</h2>';

			echo '<table class="comments">';
			foreach($user['SentenceComments'] as $comment) {
				echo '<tr>';
					echo '<td class="title">';
					echo $html->link(
						'['. $comment['sentence_id'] . '] ',
						array(
							"controller" => "sentence_comments",
							"action" => "show",
							$comment['sentence_id']
							));
					echo '</td>';

					echo '<td class="dateAndUser" rowspan="2">';
					echo $date->ago($comment['created']);
					echo '<br/>';
					echo $user['User']['username'];
					echo '</td>';
				echo '</tr>';

				echo '<tr>';
					echo '<td class="commentPreview">';
					echo nl2br($comments->clickableURL($comment['text']));
					echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
		echo '</div>';
	}
	?>

</div>

