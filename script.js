$(function(){

/* スマホ版でハンバーガーでクリックしたらナビを開閉 */
$('.btn-trigger').on('click',function(){
	if( $(this).hasClass('active') ){
		$(this).removeClass('active');
		$('.navigation').addClass('close').removeClass('open');
	}else{
		$(this).addClass('active');
		$('.navigation').addClass('open').removeClass('close'); 
	}
});

$('.navigation').on('click',function(){
	if( $('.btn-trigger').hasClass('active') ){
		$('.btn-trigger').removeClass('active');
		$('.navigation').addClass('close').removeClass('open');
	}else{
		$('.btn-trigger').addClass('active');
		$('.navigation').addClass('open').removeClass('close'); 
	}
});

/* スクロールに合わせてフェイドイン３種類 */
$(function(){
$(window).scroll(function (){
	$('.effect-fade-l-1').each(function(){
		var elemPos = $(this).offset().top;
		var scroll = $(window).scrollTop();
		var windowHeight = $(window).height();
		if (scroll > elemPos - windowHeight){
			$(this).addClass('effect-scroll');
		}
	});
});
});
$(function(){
	$(window).scroll(function (){
		$('.effect-fade-l-2').each(function(){
			var elemPos = $(this).offset().top;
			var scroll = $(window).scrollTop();
			var windowHeight = $(window).height();
			if (scroll > elemPos - windowHeight){
				$(this).addClass('effect-scroll');
			}
		});
	});
});
$(function(){
	$(window).scroll(function (){
		$('.effect-fade-l-3').each(function(){
			var elemPos = $(this).offset().top;
			var scroll = $(window).scrollTop();
			var windowHeight = $(window).height();
			if (scroll > elemPos - windowHeight){
				$(this).addClass('effect-scroll');
			}
		});
	});
});

$(function(){
	$(window).scroll(function (){
		$('.effect-fade-r-1').each(function(){
			var elemPos = $(this).offset().top;
			var scroll = $(window).scrollTop();
			var windowHeight = $(window).height();
			if (scroll > elemPos - windowHeight){
				$(this).addClass('effect-scroll');
			}
		});
	});
});
$(function(){
	$(window).scroll(function (){
		$('.effect-fade-r-2').each(function(){
			var elemPos = $(this).offset().top;
			var scroll = $(window).scrollTop();
			var windowHeight = $(window).height();
			if (scroll > elemPos - windowHeight){
				$(this).addClass('effect-scroll');
			}
		});
	});
});
$(function(){
	$(window).scroll(function (){
		$('.effect-fade-r-3').each(function(){
			var elemPos = $(this).offset().top;
			var scroll = $(window).scrollTop();
			var windowHeight = $(window).height();
			if (scroll > elemPos - windowHeight){
				$(this).addClass('effect-scroll');
			}
		});
	});
});

/* マウスオーバーによるビデオの再生停止 */
$(document).on({
	mouseenter:function(){
		$(this).find('.video')[0].play(); 
	},
	mouseleave:function(){
		$(this).find('.video')[0].pause();
	}
},'.news_list>.news_item:nth-child(3)');

/* 送信ボタンクリックでクラス追加 */
$(function(){
	$("#pop").click(function(){
		$("#cbwrp").addClass('cow_bg_pop');// 巨大牛フェードイン
		const str1 = $('#input_name').val();//名前入力読み取り
		$("#output_name").text(str1);
		$("#proverb").addClass('proverb');
		// $("#output_name").addClass('proverb');
	});
});

/* アニメーション完了後に要素クリックでクラス削除 */
$(function(){
	$("#cbwrp").click(function(){
		$("#cbwrp").removeClass('cow_bg_pop');
		$("#proverb").removeClass('proverb');
	});
});


});