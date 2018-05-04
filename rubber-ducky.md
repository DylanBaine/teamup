# What to do to TeamUp 
## Features

* Manage Users and Groups
    * Add groups and assign users to groups.
    * Assign Permissions.
    * CRUD

* Posts
    * CRUD
    * Manage which groups or users can Read, Update, or Delete Posts and Post Types.

* Files
    * CRUD
    * Manage which groups or users can Read, Update, or Delete Files.

* Tasks
    * CRUD
    * Assign to Users or Groups
    * Manage which groups or users can Read, Update, or Delete Tasks.

* Groups
    * CRUD
    * Assign To User &#10003;
    * Unassign from User &#10003;

## Database

* Users &#10004;
    * belongsToMany Groups &#10003;
    * hasMany Permissions &#10003;
    * hasMany Posts &#10003;
    * belongsTo Edits &#10003;
    * hasMany Files &#10003;

* Groups &#10004;
    * hasMany Users &#10003;
    * hasMany Permissions &#10003;
    * hasMany Files &#10003;

* Permissions &#10004;
    * belongsToMany Users &#10003;
    * hasMany Posts &#10003;

* Posts &#10004;
    * belongsToMany Permissions &#10003;
    * belongsTo Users &#10003;
    * hasMany Edits &#10003;
    * hasOne PostType &#10003;

* Edits &#10004;
    * hasOne Users &#10003;
    * belongsTo Posts &#10003;

* Files &#10004;
    * belongsTo Users &#10003;
    * belongsTo Groups &#10003;

* PostTypes &#10004;
    * belongsToMany Posts &#10003;

* Tasts
    * belongsToMany Users
    * belongsToMany Groups