Qualification
===============

Manage qualification types and user qualifications
There are two separate ElggObject in this plugin. 'qualification_type' and 'qualification'


1. Qualification Type
-----------

There are two different kind of qualification types

- General: All general qualification types have metadata attribute called 'general'. type->general
Some general qualifications types are White card, Driver License and ...

- Internal: The qualification types provided by each organization have the value for general equal to internal. type->internal
When you create an induction, an internal qualification type will be automatically added to the system for that organization

Possible attributes
--------------

- type
- title
- description

2. Qualification
-----------

User qualifications store as qualification sub type.

Possible attributes
--------------

- title
- description
- number
- granted_date
- expired_date
- organization
- document

FOR MORE INFORATION SEE MODEL PAGE IN CONFLUENCE
