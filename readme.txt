=== OG ===
Contributors: iworks
Donate link: http://iworks.pl/donate/og.php
Tags: open graph, facebook, social, thumbnail, feature image, og
Requires at least: 3.3
Tested up to: 4.0
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple and tiny Open Graph WordPress plugin to handle Facebook data.

== Description ==

This is a simple, tiny plugin to produce og:tags. Just that and only
that. No configuration, pure power.

If post contain YouTube links, this plugin save as postmeta video
thumbnail link and add it to og:image as post thumbnail.

The Facebook Open Graph Tags that this plugin inserts are:

=== for all type of content ===

* og:locale - site locale
* og:site_name - blog title
* og:title - post/page/archive/tag/... title
* og:url - the post/page permalink
* og:type - "website" for the homepage, "article" for single content and blog for all others
* og:description - site description

=== for single content ===

* og:image: From a specific custom field of the post/page, or if not set from the post/page featured/thumbnail image, or if it doesn't exist from the first image in the post content, or if it doesn't exist from the first image on the post media gallery, or if it doesn't exist from the default image defined on the options menu. The same image chosen here will be used and enclosure/media:content on the RSS feed.
* article:author - author of post link
* article:published_time - date of first article publication
* article:modified_time - date of last article modification


== Installation ==

1. Upload OG to your plugins directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure OG plugin using Appearance -> OG

== Frequently Asked Questions ==

== Screenshots ==


== Changelog ==

= 1.0.1 (future) =

* IMPROVEMENT: add check to post_content exists for CPT without this filed.
* IMPROVEMENT: add og:author link

= 1.0 (2014-10-02) =

Init.

