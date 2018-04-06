Packing Slip for Commerce
------------------------

Adds an option to order shipments to generate a packing slip or packing list.

After installing the package, navigate to Extras > Commerce > Configuration > Modules and
find Packing Slip in the list. Enable it in test and/or live mode.

Next, go to the order detail view of any order, scroll down to the Shipments section,
and hover over the Actions menu to expose the Print Packing Slip action.

The default template is located in:

    core/components/commerce_packingslip/templates/packingslip/standard.twig

You can override this in your own Commerce theme by creating a packingslip/standard.twig file.
