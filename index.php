<?php
//Include the system's core
	require_once("system/server/index.php");

/**
 * Insert content into page
 * --------------------------------------------------
 */
 
//Insert a text and images box into the page
	if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['action']) && $_POST['action'] == "insert_text") {
	//Insert the data into the database
		$db->insert("INSERT INTO `application`", array(
	 		"position" => $db->nextPosition("application"),
			"display_from_date" => Validate::numeric($_POST['fromDate'], false, false, false, true),
			"display_from_time" => $_POST['fromTime'],
			"display_to_date" => Validate::numeric($_POST['toDate'], false, false, false, true),
			"display_to_time" => $_POST['toTime'],
			"title" => Validate::required($_POST['title']),
			"content" => Validate::required($_POST['content'])
		));
		
	//Return a message to the ajax submitter
		echo "success";
		exit;
	}
	
//Delete a text and images box from the page
	if (isset($_POST['id']) && isset($_POST['action']) && $_POST['action'] == "delete_text") {
	//Delete the data from the database
		$db->delete("application", $_POST['id']);
		
	//Return a message to the ajax submitter
		echo "success";
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>Blog | HTML5 Template Portfolio</title>
<script src="system/javascripts/ajax_libraries/jQuery.1.7.1.js"></script>
<script src="system/javascripts/ajax_libraries/jQuery-UI.1.8.16.js"></script>
<script src="system/javascripts/jQuery.ribbon.js"></script>
<link href="system/stylesheets/ajax_libraries/jQuery-UI.1.8.16.css" rel="stylesheet" />
<link href="system/stylesheets/ribbon.css" rel="stylesheet" />
<link href="system/stylesheets/application.css" rel="stylesheet" />
<link href="system/stylesheets/style.css" rel="stylesheet" />
<script>
  var triggeredDrop = false;
  var widthStart;

  $(document).ready(function() {
	 $('.draggables').draggable({
		connectToSortable : '.connect',
		helper : 'clone',
		revert : 'invalid',
		start : function(event, ui) {
			ui.helper.css({
				width : $(this).width()
			});
		}
	 });
	  
	 $('.connect').sortable({
		 placeholder : 'dropHighlight'
	 }); 
	 
	  $('.connect').droppable({
		drop : function(event, ui) {
			if (!triggeredDrop) {
			  triggeredDrop = true;
			  var text = ui.draggable.text();
			  
			  ui.draggable.empty().html('<div style="display: block;"><p class="loading">Loading...</p></div>');
			  
			  setTimeout(function() {
				$('<div></div>').dialog({
				  title : 'Create a ' + text,
				  modal : true,
				  width : window.innerWidth - (window.innerWidth * 0.2),
				  height : window.innerHeight - (window.innerHeight * 0.2),
				  close : function() {
					$(this)  
				  },
				  buttons : {
					Submit : function() {
						
					},
					Reset : function() {
						
					},
					Cancel : function() {
						$(this).dialog('destroy').remove();
					}
				  }
				})}, 750);
			} else {
			  triggeredDrop = false;
			}
		}
	 });
  });
</script>
</head>

<body class="normalpage">
<div class="mainContainer">
  <ul class="ribbon">
    <li>
      <ul class="menu">
        <li><a href="javascript:;" accesskey="1">Home</a>
          <ul>
            <li>
              <h2><span>Site Settings</span></h2>
              <div><img src="system/images/ribbon/settings.png" />Page Settings</div>
              <div class="ribbon-list">
                <div><img src="system/images/ribbon/search_engine.png" />Search Engine</div>
                <div><img src="system/images/ribbon/users.png" />User Management</div>
              </div>
            </li>
            <li>
              <h2><span>Page Content</span></h2>
              <div><span class="draggables"><img src="system/images/ribbon/text_and_images.png" />Text and Images Box</span></div>
              <div><span class="draggables"><img src="system/images/ribbon/poll.png" />Poll</span></div>
              <div><span class="draggables"><img src="system/images/ribbon/forum.png" />Discussion Forum</span></div>
              <div><span class="draggables"><img src="system/images/ribbon/calendar.png" />Calendar Event</span></div>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>
<section id="page">
  <div id="bodywrap">
    <section id="top">
      <nav>
        <h1 id="sitename"> <a href="#">Portfolio | Premium CSS Template </a></h1>
      </nav>
      <header id="normalheader"></header>
    </section>
    <section id="contentwrap">
      <div id="contents" class="normalcontents">
        <section id="normalpage">
          <section id="content">
            <h2>Latest Blog Entries</h2>
            <section class="connect" style="display:block; height:300px; background:#CCC;"> </section>
          </section>
          <div class="clear"></div>
        </section>
      </div>
    </section>
  </div>
  <footer id="pagefooter">
    <div id="credits">
      <p> <span class="copyright"> &copy; 2011 | 2MJ |  All Rights Reserved</span> <span id="designcredit"> 
        <!--Creative Common Non-Commercial, Attribution License
Designed by : Roshan Ravi
Author URI : cssheaven.org
Do Not Remove this Credits and Link back to CSSHeaven from the template--> 
        <a href="http://cssheaven.org" title="Free CSS Website Template by CSSHeaven">Website Template</a> 
        <!--Design Credits--> by CSSHeaven.org </span> </p>
    </div>
  </footer>
</section>
</body>
</html>
