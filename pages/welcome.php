<!--
  - This page is included from body.php. It
  - is the default page for logged out users.
  -
  - File: welcome.php
  - Author: Chris Wright
  - Last updated: 2014/04/14
  - Last updated by: Chris W.
-->

Welcome to our CIT System Design project.<br /><br />
There are 2 types of accounts in our system; athlete and faculty.<br />
- All faculty type accounts can search athlete/team data and generate reports<br />
- Both athlete and faculty account types can submit registration forms<br /><br />


Athlete (athlete type):<br />
<a href="php/login.php?t=athlete">Log in as an Athlete</a>

<br /><br />

Coach (faculty type /w no special permissions):<br />
<a href="php/login.php?t=coach">Login in as a Coach</a>

<br /><br />

Admin (faculty type /w admin permission):<br />
- can approve/delete registration forms<br />
- can update athlete information<br />
- can add/update faculty<br />
- can add/update teams<br />
<a href="php/login.php?t=admin">Login in as Admin</a>