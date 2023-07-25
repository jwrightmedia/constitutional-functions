# constitutional-functions
---

Custom functions outside of WordPress theme file, normally found in `functions.php`. This method of putting functions ensures that if you switch themes, something you might do while troubleshooting a problem, you won't lose widgets, custom post types, and other data. This is to serve as a base modification for custom theming and was built originally to work with my empty [Shibui](https://github.com/jwrightmedia/shibui) theme.

**custom_post_type.php** - This adds custom post types and taxonomy to your theme. The include, found on `constitutional-functions.php`, is commented out and the `custom_post_type.php` file must be filled out with name of CPT and taxonomies as well as the body slug before you uncomment the include.

**sample.php** - This has all functions I've used up to now. Do *not* remove sample from the file name and use. It is just the dumping ground and I do not always use every function found here. Keep things lean and mean by only using what you need.

**constitutional-functions.php** - Modify this for use. This is the default functions which are used with your theme. Copy functions from the sample file for use here when you find something not needed. Keep it clean and keep it light!

**class-wp-bootstrap-navwalker.php** - A Bootstrap 4.3.0 navwalker, must include Bootstrap 4.3 in your theme in order for this to style properly. See [wp-bootstrap-navwalker](https://github.com/wp-bootstrap/wp-bootstrap-navwalker) for more details and support.

**shortcodes.php** - REMOVED - no longer in use. A shortcodes list/file I forked from a project I enherited. I couldn't find who originally used it, so I won't claim originality on it, but it combines work I've done to make layout more user-friendly for the non-code friendly person. This is depreciated and not called in the constitutional-functions.php file. Advanced Custom Fields and moving away from Bootstrap in my projects has largely made this file obsolete in my workflow. */File no longer updated. Depreciating and removing in next version./*

**wp_bootstrap_navwalker.php** - REMOVED - no longer in use. A Bootstrap 3 navwalker that I've used in nearly every project that has dropdown navigation. /*Depreciated and only included as a back up.*/ From [wp-bootstrap-navwalker](https://github.com/wp-bootstrap/wp-bootstrap-navwalker/tree/v3-branch)

## Creator

**Josh Wright**

-[Mastodon](https://subculture.chat/@jwright)

-[Twitter](https://www.twitter.com/_joshw)

## Copyright and license

Code and documentation copyright 2014-2023 Josh Wright and jwrightmedia, LLC. Used on projects via the copyright owner's permission.