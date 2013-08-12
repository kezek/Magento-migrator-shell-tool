Magento-migrator-shell-tool
===========================

Shell tool for facilitating module migration operations

Description
-------------------

This little shell tool will help you migrate your Magento modules to any version 
by using the CLI. 

Current features :

- delete resource name from 'core_resource' table
- change version for resource name from 'core_resource' table
(probably more to come but these two are the most useful)

You will find this very useful if you constantly have to migrate modules in any development 
environment. If you have to change any 'core_resource' entry in a Production env. then you're 
doing it wrong !

Usage
-------------------

Basic usage of a Magento Shell Tool can be easily research by doing a Google search . This one
is no different.

    Usage:  php migrator.php -- [options]
    --module <module> --reset             Show current version of <module> (as in core_resource)
    --module <module> --to <version>      Migrate module in database to <version> (in core_resource)
    help                                  This help
    
Requirements
-------------------

Any Magento installation (tested on CE and EE) .


Installation
--------------------

Clone the rep into your local /shell directory. That's it.

