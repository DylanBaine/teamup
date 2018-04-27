# Team Up 

## Features
    
    * Add Users

    * Add groups and assign users to groups

    * Add Doc pages (posts)

    * Manage what docs users can and cant see with permissons

## Database

    *Users
        *belongsToMany Groups
        *hasMany Permissions
        *hasMany Posts
    *Groups
        *hasMany Users
        *hasMany Permissions
    *Permissions
       * belongsToMany Users
        *belongsToMany Users
        *hasOne PermissionMode
        *hasMany Posts
    *Posts
        *belongsTo Users
        *hasMany Edits
        *belongsToMany Permisssons
    *PermissionModes
        *belongsToMany Permissons
