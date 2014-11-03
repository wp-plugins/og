<?php

/*
Plugin Name: OG
Plugin URI: http://iworks.pl/
Description: Very tiny Open Graph plugin - add featured image as facebook image.
Version: trunk
Author: Marcin Pietrzak
Author URI: http://iworks.pl/
License: GNU GPL
*/

if ( !class_exists( 'iWorks_Simple_Facebook_Open_Graph' ) ) {
    class iWorks_Simple_Facebook_Open_Graph
    {
        private static $meta = 'iworks_yt_thumbnails';

        function __construct()
        {
            add_action( 'wp_head', array( &$this, 'wp_head' ), 9 );
            add_action( 'save_post', array( &$this, 'add_youtube_thumbnails' ), 10, 2 );
        }

        public function add_youtube_thumbnails($post_ID, $post)
        {
            delete_post_meta($post_ID, self::$meta);
            if ( 'revision' == $post->post_type ) {
                return;
            }
            if (
                array_key_exists('post_content', $_POST)
                && $_POST['post_content']
                && 'publish' == $post->post_status
            ) {
                $iworks_yt_thumbnails = array();
                if ( preg_match_all( '#https?://youtu.be/([0-9a-z\-]+)#i', $_POST['post_content'], $matches ) ) {
                    foreach( $matches[1] as $youtube_id ) {
                        $iworks_yt_thumbnails[] = sprintf( 'http://img.youtube.com/vi/%s/maxresdefault.jpg', $youtube_id );
                    }
                }
                if ( preg_match_all( '#https?://(www\.)?youtube\.com/watch\?v=([0-9a-z\-]+)#i', $_POST['post_content'], $matches ) ) {
                    foreach( $matches[2] as $youtube_id ) {
                        $iworks_yt_thumbnails[] = sprintf( 'http://img.youtube.com/vi/%s/maxresdefault.jpg', $youtube_id );
                    }
                }
                if ( count( $iworks_yt_thumbnails ) ) {
                    update_post_meta( $post_ID, self::$meta, array_unique($iworks_yt_thumbnails) );
                }
            }
        }

        public function wp_head()
        {
            echo '<!-- OG -->';
            echo PHP_EOL;
            $og = array(
                'og' => array(
                    'image' => array(),
                    'description' => '',
                    'type' => 'blog',
                    'locale' => esc_attr( strtolower(preg_replace( '/-/', '_', get_bloginfo( 'language' ) ) )),
                ),
                'article' => array(
                    'tag' => array(),
                ),
            );
            // plugin: Facebook Page Publish
            remove_action( 'wp_head', 'fpp_head_action' );
            /**
             * produce
             */
            if ( is_single() ) {
                global $post;
                $iworks_yt_thumbnails = get_post_meta( $post->ID, self::$meta, true );
                if ( is_array( $iworks_yt_thumbnails ) && count( $iworks_yt_thumbnails ) ) {
                    foreach( $iworks_yt_thumbnails as $image ) {
                        $og['og']['image'][] = $image;
                    }
                }
                /**
                 * attachment image page
                 */
                if ( is_attachment() && wp_attachment_is_image($post->ID)) {
                    $og['og']['image'][] = wp_get_attachment_url($post->ID);
                }

                /**
                 * get post thumbnail
                 */

                if ( function_exists( 'has_post_thumbnail' ) ) {
                    if( has_post_thumbnail( $post->ID ) ) {
                        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                        $src = esc_attr( $thumbnail_src[0] );
                        printf( '<link rel="image_src" href="%s" />%s', $src, PHP_EOL );
                        printf( '<meta itemprop="image" content="%s" />%s', $src, PHP_EOL );
                        echo PHP_EOL;
                        array_unshift( $og['og']['image'], $src );
                    }
                }

                $og['og']['title'] = esc_attr(get_the_title());
                $og['og']['type'] = 'article';
                $og['og']['url'] = get_permalink();
                if ( has_excerpt( $post->ID ) ) {
                    $og['og']['description'] = strip_tags( get_the_excerpt() );
                } else {
                    $og['og']['description'] = strip_tags( strip_shortcodes( $post->post_content ) );
                }
                /**
                 * add tags
                 */
                $tags = get_the_tags();
                if (is_array($tags) && count($tags) > 0) {
                    foreach ($tags as $tag) {
                        $og['article']['tag'][] = esc_attr( $tag->name );
                    }
                }
                $og['article']['published_time'] = get_the_date( 'c' );
                $og['article']['modified_time'] = get_the_modified_date( 'c' );
                $og['article']['author'] = get_author_posts_url($post->post_author);
            } else {
                if(is_home() || is_front_page()) {
                    $og['og']['type'] = 'website';
                }
                $og['og']['description'] = esc_attr( get_bloginfo( 'description' ) );
                $og['og']['title'] = esc_attr( get_bloginfo( 'title' ) );
                $og['og']['url'] = home_url();
            }
            if ( mb_strlen( $og['og']['description'] ) > 300 ) {
                $og['og']['description'] = mb_substr( $og['og']['description'], 0, 400 );
                $og['og']['description'] = preg_replace( '/[\n\t\r]/', ' ', $og['og']['description'] );
                $og['og']['description'] = preg_replace( '/ {2,}/', ' ', $og['og']['description'] );
                $og['og']['description'] = preg_replace( '/ [^ ]+$/', '', $og['og']['description'] );
                $og['og']['description'] .= '...';
            }
            foreach( $og as $tag => $data ) {
                foreach( $data as $subtag => $value ) {
                    if( empty($value) ) {
                        continue;
                    }
                    if ( is_array($value) ) {
                        foreach( $value as $single_value) {
                            printf(
                                '<meta property="%s:%s" content="%s" />%s',
                                $tag,
                                $subtag,
                                $single_value,
                                PHP_EOL
                            );
                        }
                    } else {
                        printf(
                            '<meta property="%s:%s" content="%s" />%s',
                            $tag,
                            $subtag,
                            $value,
                            PHP_EOL
                        );
                    }
                }
            }
            echo '<!-- /OG -->';
            echo PHP_EOL;
        }
    }
    new iWorks_Simple_Facebook_Open_Graph();
}
