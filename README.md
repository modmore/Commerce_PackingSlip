# Packing Slip for Commerce

Adds an action to order shipments to create a packing slip.

Requires Commerce 0.11 or higher.

## Configuration & Usage

[Documentation can be found on the modmore documentation site.](https://docs.modmore.com/en/Commerce/v1/Modules/Shipping/PackingSlip.html)

## Install as a package

Packing Slip for Commerce is available as a free package from the modmore.com package provider.

## Building from source

To run the module from source, for example if you'd like to contribute a change, you'll need to take a few steps.

1. Clone the repository (or better yet, a clone of your own fork)

2. Copy config.core.sample.php to config.core.php, and if needed adjust it so that it includes your MODX site's config.core.php. Make sure you have [Commerce](https://www.modmore.com/commerce/) installed as well, of course.

3. From the browser open `_bootstrap/index.php`, this will set up the necessary settings and will make the module known to Commerce.

4. Enable the module under Configuration > Modules.
