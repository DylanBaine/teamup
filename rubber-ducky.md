# What to do to TeamUp 
## Features

* Add Users 

* Add groups and assign users to groups

* Add Posts

* Manage what posts and post types that a user can edit, update, and delete.

* Mange what posts types a user can create.

* Add files to share with posts

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
