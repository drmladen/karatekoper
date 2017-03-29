$(document).ready(function(){
	$(".comments_see").each(function(index) {
		var size = $(this).children('div[id^=comment_list]').length;
		var number = 5-size;
		$(this).children("#comment_list").slice(0, number).show();
		$(this).children('#loadMore').show();

		if ($(this).children('div[id^=comment_list]').length <= 5){
			$(this).children("#comment_list").slice(0, 5).show();
			$(this).children('#loadMore').hide();
			$(this).children('#showLess').hide();
			$(this).children('.see-more').hide();
		}

		$(this).children('#loadMore').click(function(e){
			e.preventDefault();

			$(this).siblings("#comment_list:hidden").slice(0, 5).show(); // select next 5 hidden divs and show them
			
			$(this).siblings('#showLess').show();

			$(this).siblings('#showLess').click(function(e){
				e.preventDefault();

				var size = $('div[id^=comment_list]').length;
				var number = 5-size;
				var more = $('<div id="loadMore">Prikaži še komentarjev</div>');

				$(this).siblings("#comment_list").hide();
				$(this).siblings("#comment_list:hidden").slice(0, 5).show();
				$(this).hide();
				$('.see-more').hide();
				$(this).siblings("#loadMore").show();
			});

			if($(this).siblings("#comment_list:hidden").length == 0){
				$(this).siblings('.see-more').show();
				$(this).hide();
			};
		});
	});
	$(".show-menu").click(function(){  
		$("#menu").slideToggle();
	});
	$("#show_signin").click(function(){
		$("#mobile_down").slideToggle();
	});
	$(".ontop").click(function(){
		$("html, body").animate({scrollTop:0}, "slow");
	});
	$(".fancybox").fancybox({
		openEffect	: 'elastic',
		closeEffect	: 'elastic',

		helpers: {
			title: {
			type: 'float'
			}
		}
	});
	$(".various").fancybox({
		maxWidth	: 1000,
		maxHeight	: 600,
		fitToView	: false,
		width		: '85%',
		height		: '85%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'elastic',
		closeEffect	: 'elastic',
		nextEffect  : 'none',
		prevEffect  : 'none',
        padding     : 10,
        margin      : 50
	});
	$(".del").each(function(){
		$(this).click(function(e){
			e.preventDefault();

			var albumId = this.id;

			function album_delete(_album_id) {
				$.ajax({
					type: "POST",
					url: "delete_album.php",
					data: {
						task: "album_delete",
						albumId: _album_id
					},
					success: function(data) {
						$('#del' + _album_id).detach();
					}
				});
			};
			album_delete(albumId);
		});
	});
	$(".delete_news").each(function(){
		$(this).click(function(e){
			e.preventDefault();

			var newsId	= this.id;

			function news_delete(_news_id) {
				$.ajax({
					type: "POST",
					url: "delete.php",
					data: {
						task: "news_delete",
						newsId: _news_id
					},
					success: function(data) {
						$('#' + _news_id).detach();
					}
				});
			};
			news_delete(newsId);
		});
	});
	$(".comment-btn").each(function(){
		$(this).click(function(e){
			e.preventDefault();

			var commentArea = $(this).siblings(".comment-area");
			var text 		= commentArea.val();
			var userId 		= $('#userId').val();
			var userName 	= $('#userName').val();
			var news 		= $(this).siblings("#newsId");
			var newsId		= news.val();
			var type 		= $('#type').val();

			function num_deleted_handlers() {
				$('.delete-comment').each(function() {
					var btn = this;
					$(btn).click(function() {
						countComments(newsId);
					});
				});
			}

			function countComments(newsId) {
				$.ajax({
					type: "POST",
					url: "count_comment.php",
					data: {
						task: "count_comments",
						_newsId: newsId,
						_type: type
					},
					success: function(data) {
						document.getElementById("num_comments" + newsId + type).innerHTML = data;
					}
				});
			}

			function comment_insert(data) {
				var date = new Date();
				var day = ('0' + date.getDate()).slice(-2);
				var month = (date.getMonth() + 1);
				var year = date.getFullYear();
				var hour = date.getHours();
				var min = (date.getMinutes()<10?'0':'') + date.getMinutes();
				var t = '';
				var comments_see = '#comments_see' + newsId;
				t += '<div id="' + data.comment.comment_id + '" class="comments_see1">';
				t += '<div class="profile-img"><img src="images/head.png"></div>'; 
				t += '<div class="username">' + data.user.username;
				t += ' (' + day + '.' + ("0" + month).slice(-2);
				t += '.' + year + ', ' + hour + ':' + min + ')';
				t += '<div id="';
				t += data.comment.comment_id;
				t += '" class="delete-comment">X</div></div>';
				t += '<p class="username-p">' + data.comment.comment + '</p></div>';

				$(comments_see).prepend(t);
				add_delete_handlers();
				countComments(newsId);
				num_deleted_handlers();
			}

			if (text.length > 0 && userId != null) {
				$(commentArea).css('border', '3px solid #424242');

				var type = $('#type').val();
				var connect = newsId;

				$.ajax({ 
					type: "POST",
					url: "comment.php",
					data: {
						task : "comment",
						_userId : userId,
						_type : type,
						_connect : connect,
						_comment : text 
					},
					success : function(data) {
						comment_insert(jQuery.parseJSON(data));
					}
				});﻿

				$.ajax({
					type: "POST",
					url: "mail_comments.php",
					data: {
						task: "mail",
						_userId: userId,
						_newsId: newsId,
						_connect: connect,
						_comment: text
					}
				});
			} else {
				$(commentArea).css('border', '3px solid #ff0000');
			}
		commentArea.val('');
		});
	});
	add_delete_handlers();
	num_deleted_handlers();
});
function num_deleted_handlers() {
	$('.delete-comment').each(function() {
		var btn = this;
		$(btn).click(function() {
			countComments(newsId);
		});
	});
}
function add_delete_handlers() {
	$('.delete-comment').each(function() {
		var btn = this;
		$(btn).click(function() {
			comment_delete(btn.id);
		});
	});
}
function countComments(newsId) {
	$('.count').each(function() {
		var count = this;
		var countId = count.id;
		var type = countId.slice(- 1);
		var id = countId.slice(0, -1);
		var newsId = document.getElementById(countId).id;

		$.ajax({
			type: "POST",
			url: "count_comment.php",
			data: {
				task: "count_comments",
				_newsId: id,
				_type: type
			},
			success: function(data) {
				document.getElementById("num_comments" + newsId).innerHTML = data;
			}
		});
	});
}
function comment_delete(_comment_id) {
	$.ajax({
		type: "POST",
		url: "comment_delete.php",
		data: {
			task: "comment_delete",
			comment_id: _comment_id
		},
		success: function(data) {
			$('#' + _comment_id).detach();
		}
	});
}