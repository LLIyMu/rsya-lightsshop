<?php
namespace AIOSEO\Plugin\Common\Migration;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use AIOSEO\Plugin\Common\Models;

// phpcs:disable WordPress.Arrays.ArrayDeclarationSpacing.AssociativeArrayFound

/**
 * Migrates the Social Meta settings from V3.
 *
 * @since 4.0.0
 */
class SocialMeta {
	/**
	 * The old V3 options.
	 *
	 * @since 4.0.0
	 *
	 * @var array
	 */
	protected $oldOptions = [];

	/**
	 * Class constructor.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		$this->oldOptions = aioseo()->migration->oldOptions;

		if ( empty( $this->oldOptions['modules']['aiosp_opengraph_options'] ) ) {
			return;
		}

		$this->migrateHomePageOgTitle();
		$this->migrateHomePageOgDescription();
		$this->migrateTwitterUsername();
		$this->migrateTwitterCardType();
		$this->migrateSocialPostImageSettings();
		$this->migrateDefaultObjectTypes();
		$this->migrateAdvancedSettings();
		$this->migrateProfileSocialUrls();

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_sitename'] ) ) {
			aioseo()->options->social->facebook->general->siteName = aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_sitename'] );
		}

		$settings = [
			'aiosp_opengraph_facebook_author' => [ 'type' => 'boolean', 'newOption' => [ 'social', 'facebook', 'general', 'showAuthor' ] ],
			'aiosp_opengraph_twitter_creator' => [ 'type' => 'boolean', 'newOption' => [ 'social', 'twitter', 'general', 'showAuthor' ] ],
		];

		aioseo()->migration->helpers->mapOldToNew( $settings, $this->oldOptions['modules']['aiosp_opengraph_options'] );

		$this->maybeShowOgNotices();
	}

	/**
	 * Check if we need to add a notice about the OG deprecated settings.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function maybeShowOgNotices() {
		$include = [];

		// Check if any of thw following are set to true.
		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_generate_descriptions'] ) ) {
			$include[] = __( 'Use Content for Autogenerated Descriptions', 'all-in-one-seo-pack' );
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_description_shortcodes'] ) ) {
			$include[] = __( 'Run Shortcodes in Description', 'all-in-one-seo-pack' );
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_title_shortcodes'] ) ) {
			$include[] = __( 'Run Shortcodes in Title', 'all-in-one-seo-pack' );
		}

		if ( empty( $include ) ) {
			return;
		}

		$content = __( 'Due to some changes in how our Open Graph integration works, your Facebook Titles and Descriptions may have changed. You were using the following options that have been removed:', 'all-in-one-seo-pack' ) . '<ul>'; // phpcs:ignore Generic.Files.LineLength.MaxExceeded

		foreach ( $include as $setting ) {
			$content .= '<li><strong>' . $setting . '</strong></li>';
		}

		$content .= '</ul>';

		$notification = Models\Notification::getNotificationByName( 'v3-migration-deprecated-opengraph' );
		if ( $notification->notification_name ) {
			return;
		}

		Models\Notification::addNotification( [
			'slug'              => uniqid(),
			'notification_name' => 'v3-migration-deprecated-opengraph',
			'title'             => __( 'Review Your Facebook Open Graph Titles and Descriptions', 'all-in-one-seo-pack' ),
			'content'           => $content,
			'type'              => 'warning',
			'level'             => [ 'all' ],
			'button1_label'     => __( 'Learn More', 'all-in-one-seo-pack' ),
			'button1_action'    => aioseo()->helpers->utmUrl( AIOSEO_MARKETING_URL . 'docs/deprecated-opengraph-settings', 'notifications-center', 'v3-migration-deprecated-opengraph' ),
			'start'             => gmdate( 'Y-m-d H:i:s' )
		] );
	}

	/**
	 * Migrates the Open Graph homepage title.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateHomePageOgTitle() {
		$showOnFront        = get_option( 'show_on_front' );
		$pageOnFront        = (int) get_option( 'page_on_front' );
		$useHomePageMeta    = ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_setmeta'] );
		$format             = $this->oldOptions['aiosp_home_page_title_format'];

		// Latest Posts.
		if ( 'posts' === $showOnFront ) {
			$ogTitle = aioseo()->helpers->pregReplace( '#%page_title%#', '#site_title', $format );
			if ( ! $useHomePageMeta ) {
				if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_hometitle'] ) ) {
					$ogTitle = $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_hometitle'];
				}
				aioseo()->options->social->facebook->homePage->title = aioseo()->helpers->sanitizeOption( aioseo()->migration->helpers->macrosToSmartTags( $ogTitle ) );
				aioseo()->options->social->twitter->homePage->title  = aioseo()->helpers->sanitizeOption( aioseo()->migration->helpers->macrosToSmartTags( $ogTitle ) );
				return;
			}
			$title   = aioseo()->options->searchAppearance->global->siteTitle;
			$ogTitle = $title ? $title : $ogTitle;
			aioseo()->options->social->facebook->homePage->title = aioseo()->helpers->sanitizeOption( $ogTitle );
			aioseo()->options->social->twitter->homePage->title  = aioseo()->helpers->sanitizeOption( $ogTitle );
			return;
		}

		// Static Home Page.
		$post       = 'page' === $showOnFront && $pageOnFront ? aioseo()->helpers->getPost( $pageOnFront ) : '';
		$aioseoPost = Models\Post::getPost( $post->ID );
		$seoTitle   = get_post_meta( $post->ID, '_aioseop_title', true );
		$ogMeta     = get_post_meta( $post->ID, '_aioseop_opengraph_settings', true );

		if ( ! $ogMeta ) {
			return;
		}

		$ogMeta = maybe_unserialize( $ogMeta );

		$ogTitle = '';
		if ( ! $useHomePageMeta ) {
			if ( empty( $this->oldOptions['aiosp_use_static_home_info'] ) ) {
				$ogTitle = ! empty( $this->oldOptions['aiosp_home_title'] ) ? $this->oldOptions['aiosp_home_title'] : $ogTitle;
				if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_hometitle'] ) ) {
					$ogTitle = $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_hometitle'];
				}
				if ( ! empty( $ogMeta['aioseop_opengraph_settings_title'] ) ) {
					$ogTitle = $ogMeta['aioseop_opengraph_settings_title'];
				} elseif ( ! empty( $seoTitle ) ) {
					if ( empty( $ogTitle ) ) {
						$ogTitle = $seoTitle;
					} elseif ( empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_hometitle'] ) ) {
						$ogTitle = $seoTitle;
					}
				}
			}
		} else {
			if ( empty( $this->oldOptions['aiosp_use_static_home_info'] ) ) {
				$ogTitle = $aioseoPost->title;
				if ( ! empty( $ogMeta['aioseop_opengraph_settings_title'] ) ) {
					$ogTitle = $ogMeta['aioseop_opengraph_settings_title'];
				}
				$ogTitle = ! empty( $this->oldOptions['aiosp_home_title'] ) ? $this->oldOptions['aiosp_home_title'] : $ogTitle;
				if ( ! empty( $seoTitle ) ) {
					$ogTitle = $seoTitle;
				}
			} else {
				$ogTitle = ! empty( $seoTitle ) ? $seoTitle : $ogTitle;
			}
		}

		$ogTitle = aioseo()->helpers->sanitizeOption( aioseo()->migration->helpers->macrosToSmartTags( $ogTitle ) );
		$aioseoPost->set( [
			'post_id'       => $post->ID,
			'og_title'      => $ogTitle,
			'twitter_title' => $ogTitle
		] );
		$aioseoPost->save();
	}

	/**
	 * Migrates the Open Graph homepage description.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateHomePageOgDescription() {
		$showOnFront        = get_option( 'show_on_front' );
		$pageOnFront        = (int) get_option( 'page_on_front' );
		$useHomePageMeta    = ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_setmeta'] );
		$format             = $this->oldOptions['aiosp_description_format'];

		if ( 'posts' === $showOnFront ) {
			$ogDescription = aioseo()->helpers->pregReplace( '#%description%#', '#tagline', $format );
			if ( ! $useHomePageMeta ) {
				if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_description'] ) ) {
					$ogDescription = $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_description'];
				}
				aioseo()->options->social->facebook->homePage->description = aioseo()->helpers->sanitizeOption( aioseo()->migration->helpers->macrosToSmartTags( $ogDescription ) );
				aioseo()->options->social->twitter->homePage->description = aioseo()->helpers->sanitizeOption( aioseo()->migration->helpers->macrosToSmartTags( $ogDescription ) );
				return;
			}
			$description   = aioseo()->options->searchAppearance->global->metaDescription;
			$ogDescription = $description ? $description : $ogDescription;
			aioseo()->options->social->facebook->homePage->description = aioseo()->helpers->sanitizeOption( $ogDescription );
			aioseo()->options->social->twitter->homePage->description  = aioseo()->helpers->sanitizeOption( $ogDescription );
			return;
		}

		$post           = 'page' === $showOnFront && $pageOnFront ? aioseo()->helpers->getPost( $pageOnFront ) : '';
		$aioseoPost     = Models\Post::getPost( $post->ID );
		$seoDescription = get_post_meta( $post->ID, '_aioseop_description', true );
		$ogMeta         = get_post_meta( $post->ID, '_aioseop_opengraph_settings', true );

		if ( ! $ogMeta ) {
			return;
		}

		$ogMeta = maybe_unserialize( $ogMeta );

		$ogDescription = '';
		if ( ! $useHomePageMeta ) {
			if ( empty( $this->oldOptions['aiosp_use_static_home_info'] ) ) {
				$ogDescription = ! empty( $this->oldOptions['aiosp_home_description'] ) ? $this->oldOptions['aiosp_home_description'] : $ogDescription;
				if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_description'] ) ) {
					$ogDescription = $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_description'];
				}
				if ( ! empty( $ogMeta['aioseop_opengraph_settings_desc'] ) ) {
					$ogDescription = $ogMeta['aioseop_opengraph_settings_desc'];
				} elseif ( ! empty( $seoDescription ) ) {
					if ( empty( $ogDescription ) ) {
						$ogDescription = $seoDescription;
					} elseif ( empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_description'] ) ) {
						$ogDescription = $seoDescription;
					}
				}
			}
		} else {
			if ( empty( $this->oldOptions['aiosp_use_static_home_info'] ) ) {
				$ogDescription = $aioseoPost->description;
				if ( ! empty( $ogMeta['aioseop_opengraph_settings_desc'] ) ) {
					$ogDescription = $ogMeta['aioseop_opengraph_settings_desc'];
				}
				$ogDescription = ! empty( $this->oldOptions['aiosp_home_description'] ) ? $this->oldOptions['aiosp_home_description'] : $ogDescription;
				if ( ! empty( $seoDescription ) ) {
					$ogDescription = $seoDescription;
				}
			} else {
				$ogDescription = ! empty( $seoDescription ) ? $seoDescription : $ogDescription;
			}
		}

		$ogDescription = aioseo()->helpers->sanitizeOption( aioseo()->migration->helpers->macrosToSmartTags( $ogDescription ) );
		$aioseoPost->set( [
			'post_id'             => $post->ID,
			'og_description'      => $ogDescription,
			'twitter_description' => $ogDescription
		] );
		$aioseoPost->save();
	}

	/**
	 * Migrates the Open Graph default post images.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateSocialPostImageSettings() {
		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_homeimage'] ) ) {
			$value = esc_url( wp_strip_all_tags( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_homeimage'] ) );
			aioseo()->options->social->facebook->homePage->image = $value;
			aioseo()->options->social->twitter->homePage->image  = $value;
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_defimg'] ) ) {
			$value = aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_defimg'] );
			aioseo()->options->social->facebook->general->defaultImageSourcePosts = $value;
			aioseo()->options->social->twitter->general->defaultImageSourcePosts  = $value;
		}

		if (
			! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_dimg'] ) &&
			! preg_match( '/default-user-image.png$/', $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_dimg'] )
		) {
			$value = esc_url( wp_strip_all_tags( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_dimg'] ) );
			aioseo()->options->social->facebook->general->defaultImagePosts = $value;
			aioseo()->options->social->twitter->general->defaultImagePosts  = $value;
		} else {
			aioseo()->options->social->facebook->general->defaultImagePosts = '';
			aioseo()->options->social->twitter->general->defaultImagePosts  = '';
		}

		if (
			! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_dimgwidth'] ) ||
			! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_dimgheight'] )
		) {
			aioseo()->options->social->facebook->general->defaultImageWidthPosts =
				aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_dimgwidth'] );
			aioseo()->options->social->facebook->general->defaultImageHeightPosts =
				aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_dimgheight'] );
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_meta_key'] ) ) {
			$value = aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_meta_key'] );
			aioseo()->options->social->facebook->general->customFieldImagePosts = $value;
			aioseo()->options->social->twitter->general->customFieldImagePosts  = $value;
		}
	}

	/**
	 * Migrates the Twitter username.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateTwitterUsername() {
		if (
			! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_twitter_site'] ) &&
			! aioseo()->options->social->profiles->urls->twitterUrl
		) {
			$username = ltrim( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_twitter_site'], '@' );
			aioseo()->options->social->profiles->urls->twitterUrl =
				esc_url( 'https://twitter.com/' . aioseo()->social->twitter->prepareUsername( aioseo()->helpers->sanitizeOption( $username ), false ) );
		}
	}

	/**
	 * Migrates the Twitter card type.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateTwitterCardType() {
		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_defcard'] ) ) {
			aioseo()->options->social->twitter->general->defaultCardType =
				aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_defcard'] );
			aioseo()->options->social->twitter->homePage->cardType =
				aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_defcard'] );
		}
	}

	/**
	 * Migrates the default object types.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateDefaultObjectTypes() {
		foreach ( aioseo()->helpers->getPublicPostTypes( true ) as $postType ) {
			$settingName = "aiosp_opengraph_{$postType}_fb_object_type";
			if ( ! in_array( $settingName, array_keys( $this->oldOptions['modules']['aiosp_opengraph_options'] ), true ) ) {
				continue;
			}

			$options = aioseo()->options->noConflict();
			if ( $options->social->facebook->general->dynamic->postTypes->has( $postType ) ) {
				aioseo()->options->social->facebook->general->dynamic->postTypes->$postType->objectType =
					aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options'][ $settingName ] );
			}

			if ( 'post' === $postType ) {
				aioseo()->options->social->facebook->homePage->objectType =
					aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options'][ $settingName ] );
			}
		}
	}

	/**
	 * Migrates a number of advanced settings.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateAdvancedSettings() {
		$advancedEnabled = false;

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_key'] ) ) {
			$advancedEnabled = true;
			aioseo()->options->social->facebook->advanced->adminId = aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_key'] );
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_appid'] ) ) {
			$advancedEnabled = true;
			aioseo()->options->social->facebook->advanced->appId  = aioseo()->helpers->sanitizeOption( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_appid'] );
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_gen_tags'] ) ) {
			$advancedEnabled = true;
			aioseo()->options->social->facebook->advanced->generateArticleTags = true;
		} else {
			aioseo()->options->social->facebook->advanced->generateArticleTags = false;
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_gen_keywords'] ) ) {
			$advancedEnabled = true;
			aioseo()->options->social->facebook->advanced->useKeywordsInTags = true;
		} else {
			aioseo()->options->social->facebook->advanced->useKeywordsInTags = false;
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_gen_categories'] ) ) {
			$advancedEnabled = true;
			aioseo()->options->social->facebook->advanced->useCategoriesInTags = true;
		} else {
			aioseo()->options->social->facebook->advanced->useCategoriesInTags = false;
		}

		if ( ! empty( $this->oldOptions['modules']['aiosp_opengraph_options']['aiosp_opengraph_gen_post_tags'] ) ) {
			$advancedEnabled = true;
			aioseo()->options->social->facebook->advanced->usePostTagsInTags = true;
		} else {
			aioseo()->options->social->facebook->advanced->usePostTagsInTags = false;
		}

		aioseo()->options->social->facebook->advanced->enable = $advancedEnabled;
	}

	/**
	 * Migrates the social URLs for the author users.
	 *
	 * @since 4.0.0
	 *
	 * @return void
	 */
	private function migrateProfileSocialUrls() {
		$records = aioseo()->db
			->start( 'usermeta' )
			->select( '*' )
			->where( 'meta_key', 'facebook' )
			->run()
			->result();

		if ( count( $records ) ) {
			foreach ( $records as $record ) {
				if ( ! empty( $record->user_id ) && ! empty( $record->meta_value ) ) {
					update_user_meta(
						(int) $record->user_id,
						'aioseo_facebook',
						esc_url( $record->meta_value )
					);
				}
			}
		}

		$records = aioseo()->db
			->start( 'usermeta' )
			->select( '*' )
			->where( 'meta_key', 'twitter' )
			->run()
			->result();

		if ( count( $records ) ) {
			foreach ( $records as $record ) {
				if ( ! empty( $record->user_id ) && ! empty( $record->meta_value ) ) {
					update_user_meta(
						(int) $record->user_id,
						'aioseo_twitter',
						sanitize_text_field( $record->meta_value )
					);
				}
			}
		}
	}
}