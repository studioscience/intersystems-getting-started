# ISC Twenty Eleven

- Contributors: wordpressdotorg
- Requires at least: WordPress 3.2
- Tested up to: WordPress 5.0
- Requires PHP: 5.2.4
- Stable tag: 3.3
- License: GPLv2 or later
- License URI: http://www.gnu.org/licenses/gpl-2.0.html
- Tags: blog, one-column, two-columns, left-sidebar, right-sidebar, custom-background, custom-colors, custom-header, custom-menu, editor-style, featured-image-header, featured-images, flexible-header, footer-widgets, full-width-template, microformats, post-formats, rtl-language-support, sticky-post, theme-options, translation-ready

## Content editors guide

### Integrating the sandbox

#### Insert the sandbox launch/login/registration widget

Use this shortcode:

```
[iris_eval_creds][openid_connect_generic_login_button][/iris_eval_creds]
```

This will handle logging in or registering the user with InterSystems SSO, launching the sandbox, and showing configuration settings.

#### Full list of sandbox settings available via user metadata

- sandbox_ide_url: Cloud IDE (Theia)
- sandbox_smp: Management Portal
- username: user name
- password: password
- sandbox_ext_ide_ip: External IDE IP Address
- sandbox_ext_ide_port: External IDE Port
- sandbox_isc_ip: Server IP Address
- sandbox_isc_port: Server Port
- sandbox_expires: Expiration time for sandbox

#### Use sandbox settings info throughout the page

**Use this shortcode:**

```html
[iris_eval_settings setting="" linktext="" fallback="" prefix="" suffix=""][/iris_eval_settings]
```

**Attributes:**

- **setting:** one of (#)[sandbox settings] above
- **linktext:** if the setting is a link (i.e. `sandbox_ide_url` or `sandbox_smp`), an `<a>` tag is created, and the setting value becomes the href and this text will be in the anchor
- **prefix:** any HTML will be output *before* the setting value
- **sufffix:** any HTML will be output *after* the setting value
- **fallback:** if the setting isn't found, output this HTML

## Notes on ISC modifications

### For SSO

Use OAuth plugin: https://github.com/daggerhart/openid-connect-generic

In `openid-connect-generic-login-form.php` modify the function `function make_login_button()` to have class attributes that work for our theme.

### For sandbox startup

This ["Update user meta using with ajax"](https://wordpress.stackexchange.com/questions/216140/update-user-meta-using-with-ajax) question helped me figure out how to save data obtained via Javascript to the Wordpress PHP layer.

### For EnlighterJS plugin compatibility with Autoptimize

Add this to the "Exclude scripts from Autoptimize" under Settings->Autoptimize->JS, CSS & HTML

`wp-content/plugins/enlighter/resources/`

## Production checklist

### Before copying

- Uncomment Analytics (Heap and GA/GTM)
- Uncomment Drift
- Disable Daggerhart OpenID plugin

### After copy

- Check WordPress address and site address (in General -> Settings or from phpmyadmin in `wp_options` table -- WPEngine should fix this automatically)
<!-- - Change SSO URLs (now handled in functions.php by changing URL based on site) -->
- Update Daggerhart OpenID settings
  - login in as iscdeveloper (Wordpress user -- not SSO)
  - enable Daggerhart OpenID plugin
  - change the plugin settings (client id, secret, URL endpoints, ...) to those for production (Raj Singh has these settings stored securely)
- Allow search engine indexing
- Check to make sure debug flag is set to FALSE in wp-config.php 
- Check time zone

## Description

Based on the Wordpress 2011 theme.

The 2011 theme for WordPress is sophisticated, lightweight, and adaptable. Make it yours with a custom menu, header image, and background -- then go further with available theme options for light or dark color scheme, custom link colors, and three layout choices. Twenty Eleven comes equipped with a Showcase page template that transforms your front page into a showcase to show off your best content, widget support galore (sidebar, three footer areas, and a Showcase page widget area), and a custom "Ephemera" widget to display your Aside, Link, Quote, or Status posts. Included are styles for print and for the admin editor, support for featured images (as custom header images on posts and pages and as large images on featured "sticky" posts), and special styles for six different post formats.

For more information about Twenty Eleven please go to https://codex.wordpress.org/Twenty_Eleven.


## Developers guide

### LSIRIS sandbox launcher

1. request token
2. request sandbox
3. successful response (takes half a minute)

    ```json
    {
        "IDE": "https://3000-0-c9dd0b12.staging-labs.learning.intersystems.com",
        "username": "tech",
        "password": "demo",
        "MP": "https://52773-1-c9dd0b12.staging-labs.learning.intersystems.com/csp/sys/UtilHome.csp?IRISUsername=tech&IRISPassword=demo",
        "IDEConnections": "(including VSCode and Atelier)",
        "HostServerAddress": "52773-1-c9dd0b12.staging-labs.learning.intersystems.com",
        "HostWebPort": "80",
        "ExtConnections": "(including InterSystems Studio)",
        "InterSystemsIP": "23.236.52.154",
        "InterSystems1972Port": "25619",
        "InterSystems51773Port": "14409",
        "TheiaIDE4200Port": "24473",
        "exp": "2021-02-07T23:26:54.572079-05:00"
    }
    ```
