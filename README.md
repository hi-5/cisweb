CIS Web Student Athlete Database
==============

About
--------------
CIS Web is a PHP, jQuery, and MySQL based database application used to track and manager athletes in a post-secondary institution sport for the Canadian Interuniversity Sport governing body.

This application was developed as part of a college project and was primarily developed specifically for the University of Lethbridge.

This branch is the point which we began finalizing code to be delivered to the University and our instructor. At this time testing features were removed.

How it Works
--------------
The application does not strictly follow any development framework. The application is largely divided between views or pages and the PHP documents that allow for the interaction with the database. These PHP files located in the /php folder largely correspond to interactions regarding a specific view or a specific table in the database.

The main view files located in /pages contain all required javascript in their script tag at the bottom of the document. These pages were largely developed independent of one another and require only the cislib.js file to manage AJAX interactions with the php handlers.

The login for this system was designed to be easy to interface with the University’s identity provider service Shibboleth and relies only on being provided a valid student ID for login as well as verification that the user has authenticated against Shibboleth.

The markup and CSS is entirely built with default Bootstrap 3. At this time no additional CSS has been added and no changes have been made to the Bootstrap package.

Installation
--------------
The application should require little work to install on any web server running Apache and MySQL. There are a few steps that will need to be followed to ensure everything is configured directly.

-          Enter database connection settings in php/connect.php.
-          Adjust the login code to fit the needs of your preferred login method. A sample can be found in php/login.php
-          Create the database structure as defined in cisweb.sql.
-          Add an initial administrator to the faculty table manually. This will included at minimum a valid student number and the f_isAdmin field being set to 1.

Authors
--------------
The initial version of this application was written by


Mike Paulson

Chris Wright


With support from the following individuals


Jesse Wilson

Kyungman Kim

Brian Booth


These individuals made up the group that worked on this project as part of a Computer Information and Technology program at the Lethbridge College.

