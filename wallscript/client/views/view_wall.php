<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Facebook Style Wall Comment | PHP Script For Wall Comment | Free Facebook Script</title>
<meta name="description" content="Free Php Script for Facebook style wall comments, Youtube Embeded Video, Link Extract." />
<link href="/assets/css/wall/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/js/jquery.js"></script>
<script type="text/javascript" src="/assets/js/wall/jquery.livequery.js"></script>
<script type="text/javascript" src="/assets/js/wall/jquery.watermarkinput.js"></script>
<script type="text/javascript" src="/assets/js/wall/wall.js"></script>
</head>

<body>
<div class="main">
<!--Innar Detail 1-->
<div class="inner_detail_1">
	<!--Inner Left Part-->	
    <div class="inner_detail_1_left">
    	<!--Inner Nav Menu-->
        <div class="inner_nav_menu">
        	<ul>
            	<li><a href="#"><img src="/assets/images/wall/home-icon.png" alt="" /></a></li>
            	<li><a href="#">Wall</a></li>
              <li><a href="#">Photo Gallery</a></li>
              <li style="background:none;"><a href="#">Video Gallery</a></li>
            </ul>
        </div>
        <!--Inner Nav Menu-->
        
        <!--Comment Box-->
       	<?php echo $render_comment_box; ?>
        <!--Comment Box-->
        
        <!--User Detail-->
		<div class="user_detail_main" id="comment_history">
			<div class="user_detail_1">
            	<div class="user_photo_name">
                	<div class="user_photo"><img src="/assets/images/wall/user_3.jpg" alt="" /></div>
                    <div class="user_deta_right">
                    	<div class="user_name"><span><a href="#">David Mathew</a></span> Today Match created History!!! <label>11 minutes ago</label></div>
                        <ul>
                        	<li><a href="#">Like</a></li>
                            <li><a href="#">Comment</a></li>
                            <li><a href="#">Share</a></li>
                        </ul>
					</div>
                </div>
                <div class="comment_post">
                	<div class="comment_post_user">
                    	<div class="comment_post_image"><img src="/assets/images/wall/user_4.jpg" alt="" /></div>
                        <div class="comment_post_data">
                        	<h5><a href="#">Niladri Roy</a></h5>
                            <p>lovely 1.....................</p>
                        </div>
                    </div>
                    <input type="text" name="" class="comment_input" value="Write a Comment..." />
                </div>
            </div>
            
            <div class="user_detail_1">
            	<div class="user_photo_name">
                	<div class="user_photo"><img src="/assets/images/wall/user_3.jpg" alt="" /></div>
                    <div class="user_deta_right">
                    	<div class="user_name"><span><a href="#">David Mathew</a></span> This is testing description. <label>11 minutes ago</label></div>
                        <ul>
                        	<li><a href="#">Like</a></li>
                            <li><a href="#">Comment</a></li>
                            <li><a href="#">Share</a></li>
                        </ul>
					</div>
                </div>
                <div class="comment_post">
                    <input type="text" name="" class="comment_input" value="Write a Comment..." />
                </div>
            </div>
            
        </div>        	
        <!--User Detail-->
    </div>
    <!--Inner Left Part-->	    
</div>    
    
</div>
</body>
</html>
