EabRelatedNodesBundle
=====================

Summary
-------
eZ Publish 5 bundle providing a very simple Related Nodes datatype for eZ Publish 5.

Fields using the Related Nodes datatype can be accessed or displayed using the
Symfony stack. To edit them you need to use the legacy stack.

The datatype does not check that locations/nodes exist or can be accessed by the
current user. You will need to write your own code to do that.

[More documentation](ezpublish_legacy/relatednodes/README.md)

Copyright
---------
Copyright (C) 2015 [Enterprise AB Ltd](http://eab.uk/)

License
-------
Licensed under [GNU General Public License 2.0](http://www.gnu.org/licenses/gpl-2.0.html)

Requirements
------------
Requires eZ Publish 5.

Installation
------------

1. If you have configured EAB's package repository you can use composer to install the bundle:

        composer require --update-no-dev --prefer-dist eab/relatednodesbundle

   Otherwise, clone the bundle using git:

        cd src
        git clone https://github.com/eab-dev/RelatedNodesBundle.git Eab/RelatedNodesBundle

2. Edit the file `ezpublish/EzPublishKernel.php`, look for the function `registerBundles()` and add:

        new Eab\RelatedNodesBundle\EabRelatedNodesBundle(),

3. Run (in Windows you should be administrator to create symlinks):

        php ezpublish/console ezpublish:legacybundles:install_extensions
        php ezpublish/console ezpublish:legacy:script bin/php/ezpgenerateautoloads.php
        php ezpublish/console cache:clear --no-warmup --env=prod

4. Use eZ Publish's admin interface to add a field using this datatype to a content type and create some content.

5. Test it in a Twig template using the `ez_render` function.
