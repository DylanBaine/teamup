# Team Up 
## Features

* Add Users

* Add groups and assign users to groups

* Add Posts

* Manage what posts and post types that a user can edit, update, and delete.

* Mange what posts types a user can create.

* Add files to share with posts

## Database

* Users
    * belongsToMany Groups
    * hasMany Permissions
    * hasMany Posts
    * belongsTo Edits
    * hasMany Files

* Groups
    * hasMany Users
    * hasMany Permissions
    * hasMany Files

* Permissions
    * belongsToMany Users
    * hasMany Posts

* Posts
    * belongsToMany Permissions
    * belongsTo Users
    * hasMany Edits
    * hasOne PostType

* Edits
    * hasOne Users
    * belongsTo Posts

* Files
    * belongsTo Users
    * belongsTo Groups

* PostTypes
    * belongsToMany Posts
