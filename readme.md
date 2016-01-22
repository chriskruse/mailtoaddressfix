# MailToAddressFix

This plugin attempts to resolve `to` email addresses which are formatted using the recipient name (i.e. John Smith <johns@whoamI.com>). For some reason, PHP's built-in `mail()` method does not like these address and will cause the `mail()` function to return false. This plugin filters the `wp_mail()` function in an attempt to remove the formatting in favor of the email address alone.

# Installation

Download a `.zip` of the plugin and upload to Wordpress via the Upload Plugin interface.