<?php  
/*
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
 * The contents of this file are subject to the Common Public Attribution License Version 1.0
 * you may not use this file except in compliance with the License.
 * Copyright (C) <2013> <amar@amkosys.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Official site: http://www.amkosys.com
 * Author: Amar Vora<amar@amkosys.com>
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */
 
if (!defined('BASEPATH')) exit('No direct script access allowed');
	
/**
 * Wall Lib
 *
 * @author Amar Vora <amar@amkosys.com>
 * @copyright Copyright (c) 5 Jan 2013 
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0
**/

class Wall_lib
{
	
	var $ci;
	var $wall_title = 'News Feed';
	var $main_user_pic = '/assets/images/wall/user_image_1.jpg';
	var $new_comment_div;
	var $new_video_div;
	
	/**
	 * __construct
	 *
	 * @access public
	 * @param void
	 * @return void
	**/
	
	public function __construct()
	{
		$this->ci =&get_instance();
		
		$this->new_video_div = '<div class="share_video">
									<div class="video_shot">[VIDEO_SHOT]</div>
									<div class="video_description">
										<span><a href="[VIDEO_URL]" target="_blank">[VIDEO_TITLE]</a></span>
										<p>[VIDEO_DESCRIPTION]</p>
									</div>
								</div>';
		
		$this->new_comment_div = '<div class="user_detail_1" id="user_comment_[WALL_USER_ID]">
							<div class="user_photo_name">
								<div class="user_photo"><img src="[WALL_USER_IMG]" alt="" /></div>
								<div class="user_deta_right">
									<div class="user_name"><span><a href="#">[WALL_USER_NAME]</a></span> [WALL_USER_COMMENT]<label>[WALL_USER_MIN]</label></div>
									<!-- EXTRA SHARE -->
									<ul>
										<li><a href="#" id="like_[WALL_USER_ID]">Like</a></li>
										<li><a href="#" id="view_comment_[WALL_USER_ID]">Comment</a></li>
									</ul>
								</div>
							</div>
							<div class="comment_post"><input type="text" name="comment_text_[WALL_USER_ID]" id="comment_text_[WALL_USER_ID]" class="comment_input" value="Write a Comment..." /></div>
						</div>';
	}
	
	public function render_main_comment_box() {
		
		$box = '<div class="comment_box">
					<div class="comment_box_title">
						<h3>'.$this->wall_title.'</h3>
						<ul>
							<li><a href="#" id="main_comment_tab">Comment</a></li>
							<li><a href="#" id="link_tab">Link</a></li>
							<li><a href="#" id="main_photo_tab">Photo</a></li>
						</ul>
					</div>
					
					<div class="comment_data_box" id="main_comment_share">
						<div class="user_image"><img src="'.$this->main_user_pic.'" /></div>
						<textarea class="comment_textarea" id="main_comment">What\'s on your mind?</textarea>
						<div class="post_part">
							<input type="button" name="share" class="post_button" value="Share" id="main_share_btn" />
							<div style="text-align:center"><img src="/assets/images/wall/loader.gif" id="main_box_loader" style="display:none;" /></div>
						</div>
					</div>
					
					<div class="comment_data_box" id="main_link_share" style="display:none">
						<div class="user_image"><img src="'.$this->main_user_pic.'" /></div>				
						
						<input type="text" name="main_link" id="main_link" size="50" class="link_input" />
						<div class="post_part">
							<input type="button" name="share" class="post_button" value="Share" id="link_share_btn" />
							<div style="text-align:center"><img src="/assets/images/wall/loader.gif" id="link_box_loader" style="display:none;" /></div>
						</div>
					</div>			
				</div>
				<div class="clear"></div>
				<input type="hidden" name="cur_image" id="cur_image" />
				<div id="hold_post" style="display:none;margin-bottom:10px;padding:10px;background-color:#F7F7F7;width:600px; height:150px; border:1px dashed #2588C7;"></div>
		';
		
		return $box;
	}
	
	public function show_new_share($user_comment,$user_name,$user_id,$user_img,$min='') {
		
		$comment_div = $this->new_comment_div;
		$comment_div = preg_replace('@\[WALL_USER_ID\]@',$user_id,$comment_div);		
		$comment_div = preg_replace('@\[WALL_USER_NAME\]@',$user_name,$comment_div);
		$comment_div = preg_replace('@\[WALL_USER_COMMENT\]@',$user_comment,$comment_div);
		$comment_div = preg_replace('@\[WALL_USER_IMG\]@',$user_img,$comment_div);
		$comment_div = preg_replace('@\[WALL_USER_MIN\]@',$min,$comment_div);

		return $comment_div;
	}
	
	public function show_new_video_share($user_comment,$arrVid,$user_name,$user_id,$user_img,$min='') {
		
		$length = 300; //modify for desired width
		
		if (strlen($arrVid['description']) <= $length) {
			$arrVid['description'] = $arrVid['description']; //do nothing
		} else {
			$arrVid['description'] = preg_replace('/\s+?(\S+)?$/', '', substr($arrVid['description'], 0, $length));
			$arrVid['description'] .= '...';
		}
		
		$video_div = $this->new_video_div;
		$video_div = preg_replace('@\[VIDEO_SHOT\]@',$arrVid['video'],$video_div);
		$video_div = preg_replace('@\[VIDEO_TITLE\]@',$arrVid['title'],$video_div);
		$video_div = preg_replace('@\[VIDEO_URL\]@',$arrVid['url'],$video_div);
		$video_div = preg_replace('@\[VIDEO_DESCRIPTION\]@',$arrVid['description'],$video_div);
		
		$comment_div = $this->new_comment_div;
		$comment_div = preg_replace('@\[WALL_USER_ID\]@',$user_id,$comment_div);
		$comment_div = preg_replace('@\[WALL_USER_NAME\]@',$user_name,$comment_div);
		$comment_div = preg_replace('@\[WALL_USER_COMMENT\]@',$arrVid['comments'],$comment_div);
		$comment_div = preg_replace('@\[WALL_USER_IMG\]@',$user_img,$comment_div);
		$comment_div = preg_replace('@\[WALL_USER_MIN\]@',$min,$comment_div);
		$comment_div = preg_replace('@<\!\-\- EXTRA SHARE \-\->@',$video_div,$comment_div);
		
		return $comment_div;
	}
	
	public function checkURLValues($value)
	{
		$value = trim($value);
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		
		$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
		
		return $value;
	}
	
	public function fetch_record_from_link($path)
	{
		$file = fopen($path, "r");
		if (!$file)
		{
			exit("Problem occured");
		}
		$data = '';
		while (!feof($file))
		{
			$data .= fgets($file, 1024);
		}
		return $data;
	}
}