# What to do to TeamUp 
This is where I write out, and keep up with, business rules and designs for future features.
## Features

* Users
    * CRUD

* Posts
    * CRUD
    * Manage which groups or users can Read, Update, or Delete Posts and Post Types.

* Files
    * CRUD &#10003;
    * Manage which groups or users can Read, Update, or Delete Files.

* Tasks
    * CRUD
    * Assign to Users or Groups
    * Manage which groups or users can Read, Update, or Delete Tasks.
    * Only Users or Users in Group assigned to task can manage the given task.

* Groups
    * CRUD
    * Assign To User &#10003;
    * Unassign from User &#10003;

* Permissions
    * CRUD  
    * Assign To User
    * Unassign from User

## Database

* Users
    * belongsToMany Groups &#10003;
    * belongsToMany Permissions &#10003;
    * hasMany Posts &#10003;
    * belongsTo Edits &#10003;
    * hasMany Files &#10003;
    * hasMany Tasks

* Groups &#10004;
    * hasMany Users &#10003;
    * belongsToMany Permissions &#10003;
    * hasMany Files &#10003;
    * hasMany Tasks

* Permissions &#10004;
    * belongsToMany Users &#10003;
    * belongsToMany Groups
    * belongsToMany Posts
    * belongsToMany Files
    * belongsToMany Tasks

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
    * belongsToMany Permissions

* PostTypes &#10004;
    * belongsToMany Posts &#10003;
    * belongsToMany Permissions

* Tasks
    * belongsTo Users
    * belongsTo Groups
    * belongsToMany Permissions