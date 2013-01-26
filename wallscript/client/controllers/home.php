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
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public $data = array();
	
	public function __construct() {
	  parent::__construct();
	  
	  $this->load->library('wall_lib');
	  $this->load->library('youtube_video_info');
	}
	
	/**
	 * Default Home page Action
	 */
	public function index()
	{
		$data['render_comment_box'] = $this->wall_lib->render_main_comment_box();
		
		$this->load->view('view_wall',$data);
	}	
	
	/**
	 * Action For New Comments and Youtube Video sharing
	 */
	public function new_share() {
		
		if($this->input->post('form') && $this->input->post('form') == 'main_comment_req' && $this->input->post('comment')) {
			
			$user_comment = $this->input->post('comment');
			$user_name = 'David Mathew';
			$user_id = '11';
			$user_img = '/assets/images/wall/user_4.jpg';
			
			// Check if Youtube video link found, then fetch full video info // 
			$arrVid = $this->youtube_video_info->is_youtube_url($user_comment);
			
			/**
			 * ==========================================
			 * HERE WE HAVEN'T USED DATABASE, BUT NOW
			 * AT THIS STAGE, SAVE ALL POST INFO TO DB  
			 * AND GET LAST INSERTED ID BACK...
			 * i.e. $last_post_id;
			 * ==========================================
			 */
			
			// If Video Link Found then render the video //
			if(!empty($arrVid))
				echo $this->wall_lib->show_new_video_share($user_comment,$arrVid,$user_name,$user_id,$user_img);
			else
				echo $this->wall_lib->show_new_share($user_comment,$user_name,$user_id,$user_img); 
		}
		
		exit;
	}
	
	/**
	 * Action For Link Extracting 
	 */
	public function get_link() {
		
		if($this->input->post('form') && $this->input->post('form') == 'main_comment_req' && $this->input->post('url')) {
			
			$url = $this->input->post('url');
			$url = $this->wall_lib->checkURLValues($url);
			$url = preg_replace('@/$@','',$url);
			
			// Check if Youtube video link found, then fetch full video info //
			$arrVid = $this->youtube_video_info->is_youtube_url($url);
			
			if(!empty($arrVid)){
				
				$user_name = 'Amar Vora';
				$user_id = '11';
				$user_img = '/assets/images/wall/user_4.jpg';
				
				echo "--VID--".$this->wall_lib->show_new_video_share($url,$arrVid,$user_name,$user_id,$user_img);
				exit;
			}
			
			$this->load->library('simple_html_dom');
			
			// Get HTML Source Code //
			@$raw = file_get_html($url);
						
			//Get Title and Description //
			$title = $description = '';
			foreach(@$raw->find('title') as $element) {
				$title = @$element->plaintext; 
				break;
			}
			
			$description = @$raw->find("meta[name=description]",0)->getAttribute('content');
			
			// STart Image Fetching //
			$str = '<div class="images">';
			
			$k= 0; $images_array = array();
			foreach(@$raw->find('img') as $element) {
				
				if($k == 6)
					break;
				
				$image_url = @$element->src;
				if(!preg_match('@^http://@',$element->src))
				{
					$image = preg_replace('@^/@','',$element->src);
					$image_url = $url.'/'.$image;
				}
				
				if(@getimagesize($image_url) && preg_match('@^http://@',$image_url))
				{
					list($width, $height, $type, $attr) = getimagesize($image_url);
				
					if($width >= 50 && $height >= 50 ){
						$str .= "<img src='".$image_url."' width='100' id='".$k."' >";
							
						$k++;
					}
				}
			}
			
			$str .= '<input type="hidden" name="total_images" id="total_images" value="'.--$k.'" />
					</div>
					<div class="info">';
			
			$str .= '<label class="title">'.$title.'</label>';			
			$str .= '<br clear="all" />';
			$str .= '<label class="url">'.substr($url,0,35).'</label><br clear="all" /><br clear="all" />';
			$str .= '<label class="desc">'.$description.'</label><br clear="all" /><br clear="all" />';
			$str .= '<label style="float:left"><img src="/assets/images/wall/prev.png" id="prev_prev_img" alt="" /><img src="/assets/images/wall/next.png" id="next_prev_img" alt="" /></label>';
			$str .= '<label class="totalimg">Total '.$k.' images</label>';
			$str .= '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="post_link_btn" value="Post" id="post_link_btn" style="background-color:#2588C7; color:#fff; padding:5px 5px 3px 5px;" /></label>';
			$str .= '<br clear="all" />';
			$str .= '</div>';
				
			echo $str; exit;
		}
	}
}