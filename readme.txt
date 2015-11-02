=== OG ===
Contributors: iworks
Donate link: http://iworks.pl/donate/og.php
Tags: open graph, facebook, social, thumbnail, feature image, og, open graph, fb, meta, share, 
Requires at least: 3.3
Tested up to: 4.3.1
Stable tag: 2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple and tiny Open Graph WordPress plugin to handle Facebook data.

== Description ==

This is a simple, tiny plugin to produce og:tags. Just that and only
that. No configuration, pure power.

If post contain YouTube links, this plugin save as postmeta video
thumbnail link and add it to og:image as post thumbnail.

The Facebook Open Graph Tags that this plugin inserts are:

= for all type of content =

* og:locale - site locale
* og:site_name - blog title
* og:title - post/page/archive/tag/... title
* og:url - the post/page permalink
* og:type - "website" for the homepage, "article" for single content and blog for all others
* og:description - site description

= for single content =

* og:image: From a specific custom field of the post/page, or if not set from the post/page featured/thumbnail image, or if it doesn't exist from the first image in the post content, or if it doesn't exist from the first image on the post media gallery, or if it doesn't exist from the default image defined on the options menu. The same image chosen here will be used and enclosure/media:content on the RSS feed.
* article:author - author of post link
* article:published_time - date of first article publication
* article:modified_time - date of last article modification
* article:tag - tags used in post

== Installation ==

There are 3 ways to install this plugin:

= 1. The super easy way =
1. In your Admin, go to menu Plugins > Add
1. Search for `OG`
1. Click to install
1. Activate the plugin
1. A new menu `OG` in `Appearance` will appear in your Admin

= 2. The easy way =
1. Download the plugin (.zip file) on the right column of this page
1. In your Admin, go to menu Plugins > Add
1. Select the tab "Upload"
1. Upload the .zip file you just downloaded
1. Activate the plugin
1. A new menu `OG` in `Appearance` will appear in your Admin

= 3. The old and reliable way (FTP) =
1. Upload `upprev` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. A new menu `OG` in `Appearance` will appear in your Admin

== Frequently Asked Questions ==

= I installed OG and ... nothing happen! =

Please be patient, sometime you need more a day to see results. Reason
of this is cache on Facebook. But check your plugins too and if you use
and caching plugins, try do "flush cache" on your site.

= How to filter values? =

Use auto filters. If you have value like this:

    <meta property="og:title" content="WordPress Trunk" />

Then auto filter is created like this:

og_ + (word before ":") + _ + (word after ":") + _value

In this case:

og_og_title_value

    add_filter('og_og_title_value', 'my_og_og_title_value');
    function my_og_og_title_value($title)
    {
        if ( is_home() ) {
            return __('This is extra home title!', 'translate-domain');
        }
        return $title;
    }

= How to filter whole meta tag? =

Use auto filters. If you have value like this:

    <meta property="og:title" content="WordPress Trunk" />

Then auto filter is created like this:

og_ + (word before ":") + _ + (word after ":") + _meta

In this case:

og_og_title_meta

    add_filter('og_og_title_meta', 'my_og_og_title_meta');
    function my_og_og_title_meta($title)
    {
        if ( is_home() ) {
            return '<meta property="og:title" content="WordPress Title" />';
        }
        return $title;
    }

= How to setup default image? =

Use filter "og_image_init":

    add_filter('og_image_init', 'my_og_image_init');
    function my_og_image_init($images)
    {
        if ( is_front_page() || is_home() ) {
            $images[] = 'http://wordpress/wp-content/uploads/2014/11/DSCN0570.jpg';
        }
        return $images;
    }

= How to setup image on front page? =

Use filter "og_image_init":

    add_filter('og_og_image_value', 'my_og_og_image_value');
    function my_og_og_image_value($images)
    {
        if ( empty($images) ) {
            $images[] = 'http://wordpress/wp-content/uploads/2014/11/DSCN0570.jpg';
        }
        return $images;
    }


== Changelog ==

= 2.2 (2015-08-19) =

* IMPROVEMENT: add the site icon as og:image for home page.

= 2.1 (2015-05-21) =

* IMPROVEMENT: add checking site locale with facebook allowed locale.

= 2.0 (2014-12-11) =

* IMPROVEMENT: add check to post_content exists for CPT without this filed.
* IMPROVEMENT: add og:author link
* IMPROVEMENT: big refactoring
* IMPROVEMENT: add filters, see [FAQ](https://wordpress.org/plugins/og/faq/) section

= 1.0 (2014-10-02) =

Init.

