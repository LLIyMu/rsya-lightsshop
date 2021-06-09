<?php
get_header();
/* Template Name: Служба поддержки */
$url = get_template_directory_uri();
?>
<div class="headLine"></div>

<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<h1 class="page-title">Служба поддержки Крымкинг.ру</h1>
 	<div class="contact-title">Мы на связи и готовы Вам помочь. Свяжитесь с нами удобным для Вас способом.</div>
 	<div class="contacts-wrap">
 		<div class="contacts-left">
 			<div class="contacts-list">
 				<div class="contact-item contact-phone">
 					<div class="contact-phone">
 						<span>Звоните нам:</span>
 						<a href="tel:<?=the_field('phone2', 'options');?>"><?=the_field('phone2', 'options');?></a>
 					</div>
 					<!-- <div class="contact-phone">
 						<a href="tel:+79781234567">+7 (978) 123 45 67</a>
 						<span>WhatsApp и Viber</span>
 					</div> -->
 				</div>
 				<div class="contact-item contact-email">
 					<span>Пишите нам по электронной почте:</span>
 					<a href="mailto:<?=the_field('support_email', 'options');?>" class="email"><?=the_field('support_email', 'options');?></a>
 				</div>
 			</div>
 		</div>
 		<div class="contacts-right contact-form">
 			<div class="contact-title">Мы обещаем, что ответим на ваше письмо так быстро, как только сможем.</div>
		 	<?=do_shortcode( '[contact-form-7 id="837" title="Служба поддержки"]' );?>
 		</div>
 	</div>
</div>

<?php
get_footer();