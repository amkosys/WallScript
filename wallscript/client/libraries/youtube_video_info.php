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
 * Youtube Video Info Lib
 *
 * @author Amar Vora <amar@amkosys.com>
 * @copyright Copyright (c) 5 Jan 2013 
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0
**/

	class youtube_video_info
	{
		public $url;
		public $id;
		
		public function url2id()
		{
			$aux = explode("?",$this->url);
			$aux2 = explode("&",$aux[1]);			
			foreach($aux2 as $campo => $valor)
			{
				$aux3 = explode("=",$valor);
				if($aux3[0] == 'v') $video = $aux3[1];
			}
			return $this->id = $video;
		}
		
		public function url2id_($url)
		{
			$aux = explode("?",$url);
			$aux2 = explode("&",$aux[1]);			
			foreach($aux2 as $campo => $valor)
			{
				$aux3 = explode("=",$valor);
				if($aux3[0] == 'v') $video = $aux3[1];
			}
			return $this->id = $video;
		}
		
		public function thumb_url($tamanho=NULL)
		{
			$tamanho = $tamanho == "large"?"hq":"";				
			$this->url2id();
			return 'http://i1.ytimg.com/vi/'.$this->id.'/'.$tamanho.'default.jpg';
		}
		
		public function thumb($tamanho=NULL)
		{
			$tamanho = $tamanho == "large"?"hq":"";
			$this->url2id();	
			return '<img src="http://i1.ytimg.com/vi/'.$this->id.'/'.$tamanho.'default.jpg">';			
		}
		
		public function info()
		{
			$feedURL = 'http://gdata.youtube.com/feeds/base/videos?q='.$this->id.'&client=ytapi-youtube-search&v=2';    
			$sxml = simplexml_load_file($feedURL);
			foreach ($sxml->entry as $entry)
			{
				$details = $entry->content;
				$info["title"] = $entry->title;
				$details = preg_replace('@'.$info["title"].'@','',$details);
			}
			
			$details_notags = strip_tags($details);
			$texto = explode("From",$details_notags);
			$info["description"] = $texto[0];
			$aux = explode("Views:",$texto[1]);
			$aux2 = explode(" ",$aux[1]);
			$info["views"] = $aux2[0];
			
			$aux = explode("Time:",$texto[1]);
			$aux2 = explode("More",$aux[1]);
			$info["tempo"] = $aux2[0];
			
			$imgs = strip_tags($details,'<img>');
			$aux = explode("<img",$imgs);
			array_shift($aux);
			array_shift($aux);
			$aux2 = explode("gif\">",$aux[4]);
			array_pop($aux);
			$aux3 = $aux2[0].'gif">';
			$aux[] = $aux3;
			$imagens = '';
			foreach($aux as $campo => $valor)
			{
				$imagens .= '<img'.$valor;
			}
			$info["ratings"] = $imagens;
			return $info;
		}
		
		public function search($palavra)
		{
			$feedURL = 'http://gdata.youtube.com/feeds/base/videos?q='.$palavra.'&client=ytapi-youtube-search&v=2';    
			$sxml = simplexml_load_file($feedURL);	
			$i=0;
			foreach ($sxml->entry as $entry)
			{
				$details = $entry->content;	
				$info[$i]["title"] = $entry->title;	
				$aux = explode($info[$i]["title"],$details);			
				$aux2 = explode("<a",$aux[0]);				
				$aux3 = explode('href="',$aux2[1]);
				$aux4 = explode('&',$aux3[1]);
				$info[$i]["link"] = $aux4[0];
				$details_notags = strip_tags($details);
				$texto = explode("From",$details_notags);
				$info[$i]["description"] = $texto[0];
				$aux = explode("Views:",$texto[1]);
				$aux2 = explode(" ",$aux[1]);
				$info[$i]["views"] = $aux2[0];
				
				$aux = explode("Time:",$texto[1]);
				$aux2 = explode("More",$aux[1]);
				$info[$i]["tempo"] = $aux2[0];
				
				$imgs = strip_tags($details,'<img>');
				$aux = explode("<img",$imgs);
				array_shift($aux);
				array_shift($aux);
				$aux2 = explode("gif\">",$aux[4]);
				array_pop($aux);
				$aux3 = $aux2[0].'gif">';
				$aux[] = $aux3;
				$imagens = '';
				foreach($aux as $campo => $valor)
				{
					$imagens .= '<img'.$valor;
				}
				$info[$i]["ratings"] = $imagens;
				$i++;
			}
			return $info;
		}
		
		public function player($width,$height)
		{
			$this->url2id();
			return '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$this->id.'&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$this->id.'&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>';	
		}
		
		public function is_youtube_url($comments) {
			
			$arrVid = array();
			
			if(preg_match('@(http|https)://(.+)youtube\.com(.+?)v=(\w+\-\w+|\w+)@',$comments,$match)) {
				
				$this->url = $match[0];
				$this->id = $match[4];
				
				$arrVid['key'] = $match[4]; 
				$arrVid['url'] = $match[0];
				$arrVid['thumb'] = "<img src='".$this->thumb_url()."' />";
				$arrVid['video'] = $this->player("250","175");
				
				$arrinfo = $this->info();
				$arrVid['title'] =$arrinfo["title"];
				$arrVid['description'] =$arrinfo["description"];
				
				$set_link = '<a href="'.$this->url.'" target="_blank">'.$this->url.'</a>';				
				$arrVid['comments'] = preg_replace('@http://(.+)youtube\.com(.+?)v=(\w+\-\w+|\w+)@',$set_link,$comments);
			}
			
			return $arrVid;
		}
	}
?>