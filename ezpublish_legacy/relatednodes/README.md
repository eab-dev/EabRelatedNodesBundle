EAB Related Nodes Datatype
==========================

##Summary

EAB Related Nodes Datatype extension for eZ Publish 4.0

##Copyright

Copyright (C) 2015 [Enterprise AB Ltd](http://eab.uk)

##License

Licensed under GNU General Public License v2.0

##Requirements

Requires eZ Publish 4 or eZ Publish 5 Legacy Edition.

##Install

1. Copy the `eabrelatednodes` folder to the `extension` folder.

2. Edit `settings/override/site.ini.append.php` and under `[ExtensionSettings]` add:

        ActiveExtensions[]=relatednodes

3. Update the autoloads array and clear the cache:

        bin/php/ezpgenerateautoloads.php
        bin/php/ezcache.php --clear-all

##Usage

Edit classes and add attributes using the relevant datatype.
