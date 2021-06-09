<footer>
	<div class="footer-menus">
		<div class="wrapper">
			<div class="footer-item">
				<div class="footer-title">О нас</div>
				<?php wp_nav_menu( array(
				'menu'       => 'О нас', 
				'container'  => false,
				'items_wrap' => '<ul>%3$s</ul>'
				));
				?>
			</div>
			<div class="footer-item">
				<div class="footer-title">Гостям</div>
				<?php wp_nav_menu( array(
				'menu'       => 'Гостям', 
				'container'  => false,
				'items_wrap' => '<ul>%3$s</ul>'
				));
				?>
			</div>
			<div class="footer-item">
				<div class="footer-title">Владельцам</div>
				<?php wp_nav_menu( array(
				'menu'       => 'Владельцам', 
				'container'  => false,
				'items_wrap' => '<ul>%3$s</ul>'
				));
				?>
			</div>
			<div class="footer-item">
				<div class="footer-title">Юридическая информация</div>
				<?php wp_nav_menu( array(
				'menu'       => 'Юридическая информация', 
				'container'  => false,
				'items_wrap' => '<ul>%3$s</ul>'
				));
				?>
			</div>
			<div class="footer-item">
				<div class="footer-title">Мы в социальных сетях</div>
				<div class="social">
					<a href="<?=the_field('vk', 'options');?>" class="vk" target="_blank" rel="nofollow"></a>
					<a href="<?=the_field('fb', 'options');?>" class="fb" target="_blank" rel="nofollow"></a>
					<a href="<?=the_field('inst', 'options');?>" class="inst" target="_blank" rel="nofollow"></a>
					<a href="<?=the_field('ok', 'options');?>" class="ok" target="_blank" rel="nofollow"></a>
					<a href="<?=the_field('telegram', 'options');?>" class="telegram" target="_blank" rel="nofollow"></a>
					<a href="<?=the_field('viber', 'options');?>" class="viber" target="_blank" rel="nofollow"></a>
					<a href="<?=the_field('whatsapp', 'options');?>" class="whatsapp" target="_blank" rel="nofollow"></a>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="wrapper">
			<div class="footer-logo"><span>Krymking.ru</span> Посуточная аренда жилья в Крыму!</div>
			<div class="copyright">© 2021 ООО Крымкинг. Все права защищены</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(71608147, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/71608147" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>

    let radioItem = null

    let filerRadio = document.querySelectorAll('.filter input[type="radio"]')

    filerRadio.forEach(item => {
        item.addEventListener('click', () => {

            if(item === radioItem){

                item.checked = false
                radioItem = null

            }else{

                radioItem = item;

                item.closest('.filter').querySelector('#val').value = 0

            }
        })
    })

    let inputIdVal = document.querySelector('#val')

    if(inputIdVal){

        ['change', 'input'].forEach(e => {
            inputIdVal.addEventListener(e, () => {
                filerRadio.forEach(item => {
                    item.checked = false
                })
                radioItem = null
            })
        })

        let scrollUi = document.querySelector('#budget')

        if(scrollUi){

            scrollUi.addEventListener('mousedown', () => {
                filerRadio.forEach(item => {
                    item.checked = false
                })
                radioItem = null
            })

        }

    }

    document.addEventListener('DOMContentLoaded', () => {
		
		

        $(document).on('click', '.filter .sidebar-title', function() {
            $(this).toggleClass('collapse');

            if($(this).next().hasClass('switcher')){
                $(this).siblings().toggleClass('collapse');
            }else{
                $(this).next('.filter-options').toggleClass('collapse');
            }
        });
		
		$('#verification input[name="agreement"]').change(function () {
			if ($('#verification input[name="agreement"]').is(':checked')) {
				$('#verification .btn-confirm').css('pointer-events', 'unset');
			} else {
				$('#verification .btn-confirm').css('pointer-events', 'none');
			}
		});
		
		let ymapFlag = false
		
		setTimeout(() => {
			document.querySelectorAll('.hotel-address .map-link').forEach(item => {
			
			item.addEventListener('click', () => {
				ymapFlag = true
			})
		})
		}, 5000)
		
		
		/*document.querySelectorAll('.hotels-list').forEach(item => {
			console.log(item)
			item.addEventListener('click', () => {
				console.log('sdfssdfsdfsdfsdf')
			})
		})*/
		
		let coordsEl = document.querySelector('.show-maps')
		
		let waitHideBallon = false

		window.addEventListener('scroll', function (){

			if(!ymapFlag){
				
				document.querySelectorAll('.ymaps-2-1-78-balloon__close').forEach(item =>{
					item.click()
					
				})
			}else if(window.pageYOffset < 0.5 ){
				waitHideBallon = true
			}else if(waitHideBallon && coordsEl.getBoundingClientRect().top < 0){
				
				waitHideBallon = false
				ymapFlag = false
			}
				

		})

    })
	
	/*var scroll = 0;
	window.onscroll = onScroll;
	function onScroll() {
	  var top = window.pageYOffset;
	  
	  if (scroll < top) {
		  console.log(top);
		window.addEventListener('scroll', function (){
			document.querySelectorAll('.ymaps-2-1-78-balloon__close').forEach(item => item.click())
		})
	  }
	  scroll = top;
	}*/

</script>

</body>
</html>
